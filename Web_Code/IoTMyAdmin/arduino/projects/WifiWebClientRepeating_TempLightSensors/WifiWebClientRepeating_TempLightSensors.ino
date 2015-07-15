/*
 Repeating Wifi Web client_TempLightSensors
 
 Get light and temperature and upload the values to a web using
 Arduino WiFi shield
 
 Circuit:
 * Arduino UNO
 * Temperature sensor attached to pins A0
 * Light sensor attached to pins A1
 * Wifi shield attached to pins 10, 11, 12, 13
 
 created 23 April 2012
 modified 31 May 2012
 by Tom Igoe
 modified 13 Jan 2014
 by Federico Vanzati
 modified 13 Jul 2015
 by Rafael Lopez Martinez
 
 Modifying the code from:
 https://www.arduino.cc/en/Tutorial/WiFiWebClientRepeating
 This code is in the public domain.
 */

//---------------
//Sensors CONFIG
//---------------
const int tempPin =A0; //analog input where the temperature sensor is connected
const int lightPin =A1; //analog input where the light sensor is connected

//---------------
// CUSTOM CONFIG
//---------------
String yourHost="yourHost.com"; //your web host name or IP address
String yourPath="/your/path/postData.php"; //path for data posting

String devName="__devName__"; //Device name which is inserting data
String devPwd="__devPassword__"; //Device password
//uncomment for multiple devices data insertion
//String devName2="myDevice2";
//String devPwd2="myDevice2Password";

const unsigned long postingInterval = 30*1000;  // delay between uploads, in milliseconds

//------------
//WiFi CONFIG
//------------
#include <SPI.h>
#include <WiFi.h>

char ssid[] = "__yourNetworkSSID__";      //  your network SSID (name) 
char pass[] = "__yourNetworkPwd__";   // your network password
int keyIndex = 0;            // your network key Index number (needed only for WEP)

int status = WL_IDLE_STATUS;
// Initialize the Wifi client library
WiFiClient client;
//IPAddress server(64,131,82,241);
unsigned long lastConnectionTime = 0;           // last time you connected to the server, in milliseconds
boolean lastConnected = false;                  // state of the connection last time through the main loop


//------
//Setup
//------
void setup() {
  //Initialize serial and wait for port to open:
  Serial.begin(9600); 
  while (!Serial) {
    ; // wait for serial port to connect. Needed for Leonardo only
  } 
  // check for the presence of the shield:
  if (WiFi.status() == WL_NO_SHIELD) {
    Serial.println("WiFi shield not present"); 
    // don't continue:
    while(true);
  }  
  // attempt to connect to Wifi network:
  while ( status != WL_CONNECTED) { 
    Serial.print("Attempting to connect to SSID: ");
    Serial.println(ssid);
    // Connect to WPA/WPA2 network. Change this line if using open or WEP network:    
    status = WiFi.begin(ssid, pass);
    // wait 10 seconds for connection:
    delay(10000);
  }
  // you're connected now, so print out the status:
  printWifiStatus();
}

void loop() {
  // if there's incoming data from the net connection.
  // send it out the serial port.  This is for debugging
  // purposes only:
  while (client.available()) {
    char c = client.read();
    Serial.write(c);
  }

  // if there's no net connection, but there was one last time
  // through the loop, then stop the client:
  if (!client.connected() && lastConnected) {
    Serial.println();
    Serial.println("disconnecting.");
    client.stop();
  }

  // if you're not connected, and ten seconds have passed since
  // your last connection, then connect again and send data:
  if(!client.connected() && (millis() - lastConnectionTime > postingInterval)) {
    String temperature = getTemp();
    String light = getLight();
    httpRequest(temperature, light);
  }
  // store the state of the connection for next time through
  // the loop:
  lastConnected = client.connected();
}

// make HTTP request to the server:
void httpRequest(String temperature, String light) {
  // server address:
  char server[yourHost.length()];
  yourHost.toCharArray(server, yourHost.length()+1);
  
  if (client.connect(server, 80)) {
  // if there's a successful connection:
    Serial.println("connecting...");
    
    //Data string in this order:Temperature, Light
    String devData = temperature + "," + light;
    
    //uncomment for multiple devices data insertion
    //String devData2="data1,data2,data3,...";
    
    // send the HTTP PUT request:
    client.print("GET "+yourPath); 
    client.print("?data[]=["+devName+","+devPwd+","+devData+"]"); 
    //uncomment for multiple devices data insertion
    //client.print("&data[]=["+devName2+","+devPwd2+","+devData2+"]");
    client.println(" HTTP/1.1");
    client.println("Host: "+yourHost+"");
    client.println("User-Agent: arduino-ethernet");
    client.println("Connection: close");
    client.println();
    
    // note the time that the connection was made:
    lastConnectionTime = millis();
  } 
  else {
    // if you couldn't make a connection:
    Serial.println("connection failed");
    Serial.println("disconnecting.");
    client.stop();
  }
}

//Print WiFi Status in the Serial monitor
void printWifiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}

//Get temperature from sensor and convert voltage value to celsius degrees
String getTemp(){  
   int sensorVal = analogRead(tempPin);
   float voltage = (sensorVal/1024.0)*5.0; //convert the ADC reading to voltage   
   float temp = (voltage - 0.5)*100;
   int whole = (int)temp;
   int decimal = (int)(temp*1000) - whole*1000;
   String result = String(whole) + "." + String(decimal);
   
   return result;
}

//Get light from sensor map the voltage value into a [0,100] scale
String getLight(){  
   int sensorVal = analogRead(lightPin);
   int sensorValMapped = map(sensorVal, 0, 1024, 0, 100);
   String result = String(sensorValMapped);
   return result;
}

