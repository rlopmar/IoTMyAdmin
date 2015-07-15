/*
 Get location from GPS module write it into a micro-SD card 
 
 Circuit:
 * Arduino UNO
 * Adafruit 5V ready micro-SD breackout board
 * Adafruit Utimate GPS breakout v3
 
 created 13 Jul 2015
 by Rafael Lopez Martinez

 This code is based on:
 http://www.toptechboy.com/arduino/lesson-22-build-an-arduino-gps-tracker/
*/

#include <SPI.h>
#include <SD.h>
#include <SoftwareSerial.h>
#include <Adafruit_GPS.h>

SoftwareSerial mySerial(3,2); //Software Serial port is iniziated with 3=Rx, 2=Tx
Adafruit_GPS GPS(&mySerial); //GPS object is created

char c; //Variable used to read characters coming from the GPS

int CSpin = 10; //Arduino pin10 = SD card reader pinCS
File GPSDataFile; //Data object to write data from the GPS sensor

float degWhole; //Variable for the whole part of position
float degDec;  //Variable for the decimal part of degree
float longitude; //Variable for the longitude in a simple decimal number
float latitude; //Variable for the latitude in a simple decimal number

void setup() {  
  Serial.begin(115200);
  Serial.println(F("Starting GPS logger"));
  GPS.begin(9600);
  GPS.sendCommand(PMTK_SET_NMEA_OUTPUT_RMCGGA); //Request $GPRMC and $GPGGA sentences only
  GPS.sendCommand(PMTK_SET_NMEA_UPDATE_1HZ); //Set GPS update rate to 1 hz
  delay(1000);
  
  pinMode(10, OUTPUT); //pin 10 = chipSelect
  SD.begin(CSpin); //Initialize the SD card reader
}

uint32_t timer = millis(); //timer
void loop(){
  getGPSData();
  
  // if millis() or timer wraps around, we'll just reset it
  if (timer > millis()) timer = millis();     
  // approximately every 5 seconds or so, print out the current stats (only if we have a fix)
  if (millis() - timer > 5000) {
    timer = millis(); // reset the timer
    if(GPS.fix){
      writeGPSData();
    }
  }
}

//read the NMEA sentences from de GPS
void getGPSData(){
  while(!GPS.newNMEAreceived()) {
    c=GPS.read();
  }
  GPS.parse(GPS.lastNMEA());
  Serial.println(GPS.lastNMEA());
  calcCoordinates();
}

//Calculate coordinates as a simple decimal number. Easy to export to Google Earth
void calcCoordinates(){
  //Longitude
  degWhole = float(int(GPS.longitude/100)); //gives me the whole degree part of Longitude
  degDec = (GPS.longitude - degWhole*100)/60; //give me fractional part of longitude
  longitude = degWhole + degDec; //Gives complete correct decimal form of Longitude degrees
  if (GPS.lon=='W') {  //If you are in Western Hemisphere, longitude degrees should be negative
    longitude= (-1)*longitude;
  }
  
  //Latitude
  degWhole = float(int(GPS.latitude/100)); //gives me the whole degree part of Longitude
  degDec = (GPS.latitude - degWhole*100)/60; //give me fractional part of longitude
  latitude = degWhole + degDec; //Gives complete correct decimal form of Latitude degrees
  if (GPS.lat=='S') {  //If you are in South Hemisphere, latitude degrees should be negative
    latitude= (-1)*latitude;
  }
}

//Write coordinates in SD card
void writeGPSData(){
  Serial.println(F("writing data file"));
  Serial.print(longitude,6);
  Serial.print(F(","));
  Serial.print(latitude,6);
  Serial.print(F(","));
  Serial.println(GPS.altitude,4);
  GPSDataFile = SD.open("GPSCoord.txt", FILE_WRITE);
  
  GPSDataFile.print(longitude,6);
  GPSDataFile.print(F(","));
  GPSDataFile.print(latitude,6);
  GPSDataFile.print(F(","));
  GPSDataFile.print(GPS.altitude,4);
  GPSDataFile.println();
  
  GPSDataFile.close();
}
