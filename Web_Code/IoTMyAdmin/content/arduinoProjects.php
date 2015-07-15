<?php
/**
 * Written by Rafael Lopez Martinez in June 2015
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once 'outputs/includeOutputs.php';
include_once '../includes/includes.php';

//session management
sec_session_start();
if(!isset($_SESSION['username'])) {
    header("Location: ../logout.php");
    exit();
}


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Arduino Projects");
$header->closeHeader();

openBody();
printNavbarAndSidebar("arduino");
printBody();
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody(){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Arduino Projects
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <img src="../img/Arduino.png" style="height: 12px; padding-right: 5px;"> Arduino Projects
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row --> 

        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#Project1" aria-controls="Project1" role="tab" data-toggle="tab">Project1</a></li>
              <li role="presentation"><a href="#Project2" aria-controls="Project2" role="tab" data-toggle="tab">Project2</a></li>
              <li role="presentation"><a href="#Project3" aria-controls="Project4" role="tab" data-toggle="tab">Project3</a></li>
            </ul>
            <!-- /.Nav tabs --> 

            <!-- Tab panes content-->
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active" id="Project1">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="h1">Project 1: <small>Upload temperature and light data</small></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Introduction </h4>
                                            <p> 
                                                This project shows you how to upload temperature 
                                                and light data to this web. It is written for an Arduino
                                                WiFi shield, but it can be easily adapted for an Arduino Ethernet Shield.
                                            </p>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Components </h4>
                                            <lo>
                                                <li>Arduino UNO Rev3 (<a target="_blank" href="https://www.arduino.cc/en/main/arduinoBoardUno">link</a>)</li>
                                                <li>Arduino WiFi Shield (<a target="_blank" href="https://www.arduino.cc/en/Main/ArduinoWiFiShield">link</a>)</li>
                                                <li>Photoresistor</li>
                                                <li>Temperature sensor TMP36GZ (<a target="_blank" href="http://www.analog.com/media/en/technical-documentation/data-sheets/TMP35_36_37.pdf">datasheet</a>)</li>
                                                <li>10K resistor</li>
                                                <li>Breadboard</li>
                                                <li>Wires</li>
                                            </lo>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Design </h4>
                                            <p> Plug the WiFi shield on the Arduino UNO and hook all wires and sensors like in the schema </p>
                                            <lo style="list-style: decimal inside;">
                                                <li>Vin pin of the temperature sensor to Arduino 5V pin</li>
                                                <li>GND pin of the temperature sensor to Arduino GND pin</li>
                                                <li>Middle pin of the temperature sensor (Vout) to Arduino A0 pin</li>
                                                <li>One of the leads of the photoresistor to Arduino 5V pin</li>
                                                <li>The second lead is connected a 10K resistor and to Arduino A1 pin</li>
                                                <li>Now connect the second lead of the 10k resistor to GND</li>
                                            </lo>
                                            <br>
                                            <img style="max-width: 90%" src="../arduino/projects/WifiWebClientRepeating_TempLightSensors/WifiWebClientRepeating_TempLightSensors.png"><br><br>
                                            <p> If you need more details you can download the <a target="_blank" href="http://fritzing.org/download/">Fritzing</a> project in this <a target="_blank" href="../arduino/projects/WifiWebClientRepeating_TempLightSensors/WifiWebClientRepeating_TempLightSensors.fzz">link</a></p>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Code </h4>
                                            <i>
                                                <p><u>IMPORTANT NOTE</u><br>
                                                The Arduino WiFi Shield has a firmware bug.
                                                The official procedure to fix it is upgrading the shield firmware which is difficult 
                                                and can be dangerous for the shield. Otherwise, it works really smoothly uploading the 
                                                code from Arduino IDE version 1.0.2. You can download it <a target="_blank" href="https://www.arduino.cc/en/Main/OldSoftwareReleases">here</a>.
                                                </p>
                                            </i><br>
                                            <ol>
                                                <li><p>Download the code: <a target="_blank" href="../arduino/projects/WifiWebClientRepeating_TempLightSensors/WifiWebClientRepeating_TempLightSensors.ino"><i class="fa fa-download"></i></a></p></li>
                                                <li><p>
                                                Before upload this code to your Arduino, go to the <a target="_blank" href="devices.php">devices list</a> and click 
                                                on "details" in the correct device. Then copy the code lines from the "Arduino code" 
                                                panel and paste them in your code.</p></li>
                                                <li><p>Write your device password and your WiFi network details (SSID and password)</p></li>
                                            </ol><br>
                                            <p>You can find more details <a target="_blank" href="tutorial.php?tutorial=4">here</a>.</p>
                                        </div>
                                    </div>         
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
                <!-- /.Tab pane #1-->
              
                <div role="tabpanel" class="tab-pane" id="Project2">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="h1">Project 2: <small>Upload your location using Adafruit FONA GSM/GPRS module</small></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Introduction </h4>
                                            <p> 
                                                This project shows you how get your location from the Adafruit FONA
                                                and upload it to this web through the GPRS network.
                                            </p>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Components </h4>
                                            <lo>
                                                <li>Arduino UNO Rev3 (<a target="_blank" href="https://www.arduino.cc/en/main/arduinoBoardUno">link</a>)</li>
                                                <li>Adafruit FONA (<a target="_blank" href="https://learn.adafruit.com/adafruit-fona-mini-gsm-gprs-cellular-phone-module/overview">link</a>)</li>
                                                <li>GPRS/GSM antenna</li>
                                                <li>3,7V LiPo battery</li>
                                                <li>Breadboard</li>
                                                <li>Wires</li>
                                            </lo>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Design </h4>
                                            <p> Hook all wires like in the schema </p>
                                            <lo style="list-style: decimal inside;">
                                                <li>Insert your SIM card in the tray of your FONA</li>  
                                                <li>Connect FONA Vio pin to Arduino 5V pin</li>
                                                <li>Connect FONA RX pin to Arduino digital pin 3</li>
                                                <li>Connect FONA TX pin to Arduino digital pin 4</li>
                                                <li>Connect FONA Key pin to Arduino digital pin 7</li>
                                                <li>Connect FONA PS pin to Arduino digital pin 6</li>
                                                <li>Connect FONA GND pin to Arduino GND</li>
                                                <li>Connect the LiPo battery and the antenna to your FONA</li>
                                            </lo>
                                            <br>
                                            <p> The FONA is powered by the LiPo battery, so it should be charged. If it's not charged, connect the FONA (with the battery pluged in) to a computer using the micro-USB port.</p>
                                            <img style="max-width: 90%" src="../arduino/projects/FONA_Location/FONA_Location.png"><br><br>
                                            <p> If you need more details you can download the <a target="_blank" href="http://fritzing.org/download/">Fritzing</a> project in this <a target="_blank" href="../arduino/projects/FONA_Location/FONA_Location.fzz">link</a></p>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Code </h4>
                                            <ol>
                                                <li><p>Download the code: <a target="_blank" href="../arduino/projects/FONA_Location/FONA_Location.ino"><i class="fa fa-download"></i></a></p></li>
                                                <li><p>
                                                Before upload this code to your Arduino, go to the <a target="_blank" href="devices.php">devices list</a> and click 
                                                on "details" in the correct device. Then copy the code lines from the "Arduino code" 
                                                panel and paste them in your code.</p></li>
                                                <li><p>Write the carrier APN in the correct variable</p></li>
                                            </ol><br>
                                            <p>You can find more details <a target="_blank" href="tutorial.php?tutorial=4">here</a>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- /.Tab pane #2-->
              
                <div role="tabpanel" class="tab-pane" id="Project3">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="h1">Project 3: <small>GPS logger</small></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Introduction </h4>
                                            <p> 
                                                This project shows you how get your location from a GPS module
                                                and write it into a micro-SD card.
                                            </p>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Components </h4>
                                            <lo>
                                                <li>Arduino UNO Rev3 (<a target="_blank" href="https://www.arduino.cc/en/main/arduinoBoardUno">link</a>)</li>
                                                <li>Adafruit Ultimate GPS breakout V3 (<a target="_blank" href="http://www.adafruit.com/products/746">link</a>)</li>
                                                <li>Adafruit 5V ready micro-SD breackout board (<a target="_blank" href="http://www.adafruit.com/products/254">link</a>)</li>
                                                <li>Micro-SD card</li>
                                                <li>Breadboard</li>
                                                <li>Wires</li>
                                            </lo>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Design </h4>
                                            <p> Hook all wires like in the schema </p>
                                            <lo style="list-style: decimal inside;">
                                                <li>Connect GPS 3.3V pin to Arduino 3.3V pin</li>
                                                <li>Connect GPS RX pin to Arduino digital pin 3</li>
                                                <li>Connect GPS TX pin to Arduino digital pin 4</li>
                                                <li>Connect GPS GND pin to Arduino GND pin</li>
                                                <li>Connect Micro-SD 5V pin to Arduino 5V pin</li>
                                                <li>Connect Micro-SD GND pin to Arduino GND pin</li>
                                                <li>Connect Micro-SD CLK pin to Arduino digital pin 13</li>
                                                <li>Connect Micro-SD DO pin to Arduino digital pin 12</li>
                                                <li>Connect Micro-SD DI pin to Arduino digital pin 11</li>
                                                <li>Connect Micro-SD CS pin to Arduino digital pin 10</li>
                                            </lo>
                                            <br>
                                            <img style="max-width: 90%" src="../arduino/projects/GPS_SDWriting/GPS_SDWriting.png"><br><br>
                                            <p> If you need more details you can download the <a target="_blank" href="http://fritzing.org/download/">Fritzing</a> project in this <a target="_blank" href="../arduino/projects/GPS_SDWriting/GPS_SDWriting.fzz">link</a></p>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <h4> Code </h4>
                                            <ol>
                                                <li><p>Download the code: <a target="_blank" href="../arduino/projects/GPS_SDWriting/GPS_SDWriting.ino"><i class="fa fa-download"></i></a></p></li>
                                                <li><p>Upload the code to your Arduino</p></li>
                                            </ol><br>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- /.Tab pane #3-->
                
            </div>
            <!-- /.Tab panes content-->
        </div>
        <!-- /.tabPanel -->  
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}