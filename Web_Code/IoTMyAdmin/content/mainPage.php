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
$header->printSimpleHeader("IoT MyAdmin - Home");
$header->closeHeader();

openBody();
printNavbarAndSidebar("home");
printBody($numOfDevices);
closeBody();

$footer = new outputFooter();
printChartsScript();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody(){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div style="margin-bottom: 10px">
        </div>
        <!-- /.Page Heading -->
        
        <!-- 3 small info panels -->
        <div class="row">
            <!-- panel 1-->
            <div class="col-lg-4 col-md-6">
                <a href="devices.php">
                    <div class="panel panel-primary" style="box-shadow: 2px 2px 10px grey;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><?php echo dbGetNumOfDevices(); ?></div>
                                    <div>Devices registered</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- panel 2-->
            <div class="col-lg-4 col-md-6">
                <a href="lastLogs.php">
                    <div class="panel panel-primary" style="box-shadow: 2px 2px 10px grey;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-clock-o fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><?php echo dbGetNumLogsLastHour(); ?></div>
                                    <div>Logs within the last hour</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- panel 3-->
            <div class="col-lg-4 col-md-6">
                <a href="dataTables.php">
                    <div class="panel panel-primary" style="box-shadow: 2px 2px 10px grey;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><?php echo dbGetTotalNumLogs(); ?></div>
                                    <div>Total logs</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- /.3 small info panels -->

        <!-- Chart Holder --> 
        <div class="row">
            <div class="col-lg-12 col-md-12" >
                <div class="panel panel-default" style="box-shadow: 2px 2px 10px grey;">
                    <div class="panel-heading">
                        <div class="row text-center">
                            <div class="h2" style="margin: 0px">Statistics</div>
                        </div>
                    </div>
                    <div class="panel-body" style="padding-bottom: 50px">
                        <div class="col-lg-1">
                        </div>
                        <div class="col-lg-5 center-block" style="padding: 2px">
                            <div id="chartHolder"></div>                
                        </div>
                        <div class="col-lg-5 center-block" style="padding: 2px">
                            <div id="chartHolder2"></div>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Chart Holder -->        
        
        <div class="row" >
            <div class="col-lg-12">
                <h1 class="page-header">
                    How to...
                </h1>
            </div>
            <!-- Web tutorials panel -->
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default" style="box-shadow: 2px 2px 10px grey;">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-question fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="h4">Web tutorials</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div style="max-height: 350px; overflow:auto;">
                            <div class="page-header h3" style="margin-top: 5px; padding-top: 0px;"> &nbsp; Tutorial 1:&nbsp; <small> Insert a new device</small></div>
                            <h4> Introduction </h4>
                            <div class="row">
                              <div class="col-lg-12">
                                <p> This tutorial is about how to register a new device in the system. Once it is registered, this device can upload data directly from Arduino or other devices. </p>
                              </div>
                            </div>
                            <h4> Step 1 </h4>
                            <p> Go to the list of devices and and click on 'Add Device' </p>
                            <div class="row">
                              <div class="col-lg-10">
                                <img src="../img/tutorials/tutorial1/tut1step1img1.png" class="img-thumbnail"><br> 
                              </div>
                            </div>
                            <br>
                            <h4> Step 2 </h4>
                            <p> Fill all fields of the list and click on 'Add'.</p>
                            <ol>
                                <li><i>Name: </i>This is how you will recognize your device</li>
                                <li><i>Type: </i>Small description of your device</li>
                                <li><i>Number of fieds: </i>How many different data the device is going to upload</li>
                                <li><i>Public/Private: </i>Private devices will be visible only with your user account</li>
                            </ol>
                            <p> ... </p>
                        </div>
                    </div>
                    <a href="tutorial.php">
                        <div class="panel-footer">
                            <span class="pull-left">See more about web tutorials</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.Web tutorials panel -->
            
            <!-- Arduino projects panel -->
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-info" style="box-shadow: 2px 2px 10px grey;">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="../img/Arduino.png" style="height: 40px; padding-right: 5px;">
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="h4">Arduino projects</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div style="max-height: 350px; overflow:auto;">
                            <div class="page-header h3" style="margin-top: 5px; padding-top: 0px;"> &nbsp; Project 1:  &nbsp;<small> Upload temperature and light data</small></div>
                            <h4> Introduction </h4>
                            <p> 
                                This project shows you how to upload temperature 
                                and light data to this web. It is written for an Arduino
                                WiFi shield, but it can be easily adapted for an Arduino Ethernet Shield.
                            </p>
                            <br>
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
                            <br>
                            <h4> Code </h4>
                            <i>
                                <p><u>IMPORTANT NOTE</u><br>
                                The Arduino WiFi Shield has a firmware bug.
                                The official procedure...
                                </p>
                            </i>
                            <p>...</p>
                        </div>
                    </div>
                    <a href="arduinoProjects.php">
                        <div class="panel-footer">
                            <span class="pull-left">See more about Arduino projects</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.Arduino projects panel -->
        </div>
        
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php
}
function printChartsScript(){ 
$dataStr = chartsPrepRows_mainPage($_SESSION['username']);
?>
<script type="text/javascript">
    
  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawVisualization);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawVisualization() {
    var data = new google.visualization.DataTable();
    
    data.addColumn('string', 'Device Name');
    data.addColumn('number', '# of logs' );
    data.addRows([<?php echo $dataStr; ?>]);

    var options = {
      title: '# of logs per device',
      curveType: 'function',
      height: 200,
      vAxis:{minValue:0}
    };

    new google.visualization.ColumnChart(document.getElementById('chartHolder')).
      draw(data, options);

    new google.visualization.PieChart(document.getElementById('chartHolder2')).
      draw(data, options);
    }
</script>
<?php
}