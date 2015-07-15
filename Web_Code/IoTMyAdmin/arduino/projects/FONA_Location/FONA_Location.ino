/*
  Retrieves the location of the device fron a FONA board using cellular triangulation and posts to a online database. 
 
  Circuit:
  * Arduino UNO
  * Adafruit FONA module attached to pins 3, 4, 6, 7
  * LiPo batery powering FONA
  * GSM/GPRS antenna
 
  This code borrows some aspects from Chip McClelland @ Ubidots: http://ubidots.com/docs/devices/FONA.html
  
  created 7 March 2015
  by Kina Smith
  Modified 12 July 2015
  by Rafael Lopez Martinez
  
  This code is in the public domain.
*/

//--------------
// CUSTOM CONFIG
//--------------
String yourHost="yourHost.com"; //your web host name or IP address
String yourPath="/your/path/postData.php"; //your path for data insertion

String devName="__devName__"; //Device name which is inserting data
String devPwd="__devPassword__"; //Device password
//uncomment for multiple devices data insertion
//String devName2="myDevice2";
//String devPwd2="myDevice2Password";

String APN = "__yourAPN__"; //Set APN for Mobile Service. It depends on your carrier.
int SLEEP_MINUTES = 1; //delay between uploads in minutes

//------------
// FONA CONFIG
//------------
#include <SoftwareSerial.h>

//Pins setup
#define FONA_RX 3 //connect to FONA RX
#define FONA_TX 4 //connect to FONA TX
#define FONA_KEY 6 //connection to FONA KEY
#define FONA_PS 7 //connect to FONA PS

SoftwareSerial fonaSS = SoftwareSerial(FONA_TX, FONA_RX); //initialize software serial
String response; //global variable for pulling AT command responses from inside functions (there has to be a better way to do this)
int keyTime = 2000; // Time needed to turn on the Fona
unsigned long ATtimeOut = 10000; // How long we will give an AT command to comeplete

//Holders for Position Data
String Lat;
String Lon;

void setup() {
    Serial.begin(9600);
    Serial.println("Started setup");
    pinMode(FONA_PS, INPUT);
    pinMode(FONA_KEY,OUTPUT);   
    digitalWrite(FONA_KEY, HIGH);
    fonaSS.begin(9600);
    
    Serial.println("Setup DONE!");
}

void loop() {
    /*=============Get Location and Post EVERY "SLEEP_MINUTES" Minutes!=============*/
    turnOnFONA(); //turn on FONA
    Serial.println("Initializing: please wait 10 sec...");
    delay(10000);
    setupGPRS(); //Setup a GPRS context
    if(getLocation()) { //try to get location, if OK do the rest
        //Print Lat/Lon Values
        Serial.print("Latitude: ");
        Serial.print(Lat);
        Serial.println();
        Serial.print("Longitude: ");
        Serial.print(Lon);
        Serial.println();
        makeRequest(); //Make GET request
        turnOffFONA(); //turn off FONA
        flushFONA();
        for(int i = 0; i < SLEEP_MINUTES; i++) {
            delay(60000);
        }
    } else {
        delay(10000);
    }
    
}

boolean getLocation() {
    String content = "";
    char character;
    int complete = 0;
    char c;
    unsigned long commandClock = millis();                      // Start the timeout clock
    fonaSS.println("AT+CIPGSMLOC=1,1");
    delay(50);
    while(!complete && commandClock <= millis()+ATtimeOut) { // Need to give the modem time to complete command
        while(!fonaSS.available() && commandClock <= millis()+ATtimeOut){}; //wait while there is no data
        while(fonaSS.available()) {   // if there is data to read...
            delay(50);
            c = fonaSS.read();
            if(c == 0x0A || c == 0x0D) {
            } else {
                content.concat(c);
            }
        }
        if(content.startsWith("+CIPGSMLOC: 0,")) {
            Serial.println("Got Location"); //+CIPGSMLOC: 0,-73.974037,40.646976,2015/02/16,21:05:11OK
            Lon = content.substring(14, 24);
            Lat = content.substring(25, 34);
            return 1;
        } else {
            Serial.print("ERROR: ");
            Serial.println(content);
            return 0;
        }
        complete = 1; //this doesn't work. 
    }
}

void setupGPRS() { //all the commands to setup a GPRS context and get ready for HTTP command
    //the sendATCommand sends the command to the FONA and waits until the recieves a response before continueing on. 
    Serial.print("Disable echo: ");
    if(sendATCommand("ATE0")) { //disable local echo
        Serial.println(response);
        delay(50);
    }
    Serial.print("Set to TEXT Mode: ");
    if(sendATCommand("AT+CMGF=1")){ //sets SMS mode to TEXT mode....This MIGHT not be needed. But it doesn't break anything with it there. 
        Serial.println(response);
        delay(50);
    }
    Serial.print("Attach GPRS: ");
    if(sendATCommand("AT+CGATT=1")){ //Attach to GPRS service (1 - attach, 0 - disengage)
        Serial.println(response);
        delay(50);
    }
    Serial.print("Set Connection Type To GPRS: "); //AT+SAPBR - Bearer settings for applications based on IP
    if(sendATCommand("AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"")){ //3 - Set bearer perameters
        Serial.println(response);
        delay(50);
    }
    Serial.print("Set APN: ");
    if(setAPN()) {
        Serial.println(response);
        delay(50);
    }
    if(sendATCommand("AT+SAPBR=1,1")) { //Open Bearer
        if(response == "OK") {
            Serial.println("Engaged GPRS");
        } else {
            Serial.println("GPRS Already on");
        }
    }
}

void makeRequest() { //Make HTTP GET request and then close out GPRS connection
    /* Lots of other options in the HTTP setup, see the datasheet: google -sim800_series_at_command_manual */
    Serial.print("HTTP Initialized: ");
    //this checks if it is on. If it is, it's turns it off then back on again. (This Is probably not needed. )
    sendATCommand("AT+HTTPTERM");
    delay(50);
    if(sendATCommand("AT+HTTPINIT")){ //initialize HTTP service. If it's already on, this will throw an Error.
        delay(50);
        if(response != "OK") { //if you DO NOT respond OK (ie, you're already on)
            Serial.print("Failed, Restarting: ");
            if(sendATCommand("AT+HTTPTERM")) { //TURN OFF
                Serial.print("Trying Again: ");
                if(sendATCommand("AT+HTTPINIT")) { //TURN ON
                    Serial.println(response);
                }
            }
        } else {
            Serial.println(response);
        }
        Serial.println(response);
    }
    Serial.print("Set Bearer Profile ID: ");
    if(sendATCommand("AT+HTTPPARA=\"CID\",1")){ //Mandatory, Bearer profile identifier
        delay(50);
        Serial.println(response);
    }
    Serial.print("Send URL: "); 
    if(sendURL()){ //sets the URL for Sparkfun.
        delay(50);
        Serial.println(response);
    }
    Serial.print("Make GET Request: ");
    if(sendATCommand("AT+HTTPACTION=0")){ //make get request =0 - GET, =1 - POST, =2 - HEAD
        Serial.println(response);
    }
    Serial.print("Delay for 2sec....");
    delay(2000); //wait for a bit for stuff to complete
    Serial.println("OK");
    Serial.println("Flush Serial Port....");
    flushFONA(); //Flush out the Serial Port
    Serial.print("Read HTTP Response: ");
    if(sendATCommand("AT+HTTPREAD")){ //Read the HTTP response and print it out
        delay(50);
        Serial.println(response);
    }
    Serial.print("Delay for 2sec...");
    delay(2000);//wait some more
    Serial.println("OK");
    Serial.println("Flush Serial Port.....");
    flushFONA(); //Flush out the Serial Port
    Serial.print("Terminate HTTP: ");
    if(sendATCommand("AT+HTTPTERM")){ //Terminate HTTP session. (You can make multiple HTTP requests while HTTPINIT is active. Maybe even to multiple URL's? I don't know)
        delay(50);
        Serial.println(response);
    }
    Serial.print("Disengage GPRS: ");
    if(sendATCommand("AT+SAPBR=0,1")){ //disengages the GPRS context.
        delay(50);
        Serial.println(response);
    }
}

boolean sendATCommand(char Command[]) { //Send an AT command and wait for a response
    int complete = 0; // have we collected the whole response?
    char c; //capture serial stream
    String content; //place to save serial stream
    unsigned long commandClock = millis(); //timeout Clock
    fonaSS.println(Command); //Print Command
    while(!complete && commandClock <= millis() + ATtimeOut) { //wait until the command is complete
        while(!fonaSS.available() && commandClock <= millis()+ATtimeOut); //wait until the Serial Port is opened
        while(fonaSS.available()) { //Collect the response
            delay(50);
            c = fonaSS.read(); //capture it
            if(c == 0x0A || c == 0x0D); //disregard all new lines and carrige returns (makes the String matching eaiser to do)
            else content.concat(c); //concatonate the stream into a String
        }
        //Serial.println(content); //Debug
        response = content; //Save it out to a global Variable (How do you return a String from a Function?)
        complete = 1;  //Lable as Done.
    }
    if (complete ==1) return 1; //Is it done? return a 1
    else return 0; //otherwise don't (this will trigger if the command times out) 
    /*
        Note: This function may not work perfectly...but it works pretty well. I'm not totally sure how well the timeout function works. It'll be worth testing. 
        Another bug is that if you send a command that returns with two responses, an OK, and then something else, it will ignore the something else and just say DONE as soon as the first response happens. 
        For example, HTTPACTION=0, returns with an OK when it's intiialized, then a second response when the action is complete. OR HTTPREAD does the same. That is poorly handled here, hence all the delays up above. 
    */
}

boolean setAPN() { //Set the APN. See sendATCommand for full comments on flow
    int complete = 0;
    char c;
    String content;
    unsigned long commandClock = millis();                      // Start the timeout clock
    fonaSS.print("AT+SAPBR=3,1,\"APN\",\"");
    fonaSS.print(APN);
    fonaSS.print("\"");
    fonaSS.println();
    while(!complete && commandClock <= millis() + ATtimeOut) {
        while(!fonaSS.available() && commandClock <= millis()+ATtimeOut);
        while(fonaSS.available()) {
            delay(50);
            c = fonaSS.read();
            if(c == 0x0A || c == 0x0D);
            else content.concat(c);
        }
        response = content;
        complete = 1; 
    }
    if (complete ==1) return 1;
    else return 0;
}

boolean sendURL() { //builds url for GET Request, sends request and waits for reponse. See sendATCommand() for full comments on the flow
  int complete = 0;
  char c;
  String content;
  unsigned long commandClock = millis(); // Start the timeout clock
  
  //Data string in this order:latitude,  longitude
  String devData= Lat+","+Lon;
    
  //uncomment for multiple devices data insertion
  //String devData2="data1,data2,data3,...";

  //Print all of the URL components out into the Serial Port  
  fonaSS.print("AT+HTTPPARA=\"URL\",\"");
  fonaSS.print("http://"+yourHost+yourPath);
  fonaSS.print("?data[]=["+devName+","+devPwd+","+devData+"]");
  //uncomment for multiple devices data insertion
  //fonaSS.print("&data[]=[\""+devName2+"\",\""+devPwd2+"\","+devData2+"]");
  fonaSS.println(); 
  
  //DEBUG: build correct URL
  Serial.print("AT+HTTPPARA=\"URL\",\"");
  Serial.print("http://"+yourHost+yourPath);
  Serial.print("?data[]=["+devName+","+devPwd+","+devData+"]");
  //uncomment for multiple devices data insertion
  //Serial.print("&data[]=[\""+devName2+"\",\""+devPwd2+"\","+devData2+"]");
  Serial.println(); 
  
  while(!complete && commandClock <= millis() + ATtimeOut) {
    while(!fonaSS.available() && commandClock <= millis()+ATtimeOut);
    while(fonaSS.available()) {
      delay(50);
      c = fonaSS.read();
      if(c == 0x0A || c == 0x0D);
      else content.concat(c);
    }
    response = content;
    complete = 1; 
  }
  if (complete ==1) return 1;
  else return 0;
}

void flushFONA() { //if there is anything is the fonaSS serial Buffer, clear it out and print it in the Serial Monitor.
    char inChar;
    while (fonaSS.available()){
        inChar = fonaSS.read();
        Serial.write(inChar);
        delay(20);
    }
}

void turnOnFONA() { //turns FONA ON
    if(! digitalRead(FONA_PS)) { //Check if it's On already. LOW is off, HIGH is ON.
        Serial.print("FONA was OFF, Powering ON: ");
        digitalWrite(FONA_KEY,LOW); //pull down power set pin
        unsigned long KeyPress = millis(); 
        while(KeyPress + keyTime >= millis()) {} //wait two seconds
        digitalWrite(FONA_KEY,HIGH); //pull it back up again
        Serial.println("FONA Powered Up");
    } else {
        Serial.println("FONA Already On, Did Nothing");
    }
}

void turnOffFONA() { //does the opposite of turning the FONA ON (ie. OFF)
    if(digitalRead(FONA_PS)) { //check if FONA is OFF
        Serial.print("FONA was ON, Powering OFF: "); 
        digitalWrite(FONA_KEY,LOW);
        unsigned long KeyPress = millis();
        while(KeyPress + keyTime >= millis()) {}
        digitalWrite(FONA_KEY,HIGH);
        Serial.println("FONA is Powered Down");
    } else {
        Serial.println("FONA is already off, did nothing.");
    }
}

