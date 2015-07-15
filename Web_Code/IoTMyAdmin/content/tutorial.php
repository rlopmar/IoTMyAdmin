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
$header->printSimpleHeader("IoT MyAdmin - Web Tutorials");
$header->closeHeader();

openBody();
printNavbarAndSidebar("tutorial");
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
                    Web tutorials
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-edit"></i>  Web Tutorial
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.Page Heading --> 

        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" <?php if($_GET['tutorial'] == 1 || !isset($_GET['tutorial'])) echo 'class="active"'?>><a href="#tutorial1" aria-controls="home" role="tab" data-toggle="tab">Tutorial1</a></li>
              <li role="presentation" <?php if($_GET['tutorial'] == 2) echo 'class="active"'?>><a href="#tutorial2" aria-controls="#tutorial2" role="tab" data-toggle="tab">Tutorial2</a></li>
              <li role="presentation" <?php if($_GET['tutorial'] == 3) echo 'class="active"'?>><a href="#tutorial3" aria-controls="#tutorial3" role="tab" data-toggle="tab">Tutorial3</a></li>
              <li role="presentation" <?php if($_GET['tutorial'] == 4) echo 'class="active"'?>><a href="#tutorial4" aria-controls="#tutorial4" role="tab" data-toggle="tab">Tutorial4</a></li>
            </ul>
            <!-- /.Nav tabs --> 

            <!-- Tab panes content-->
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane <?php if($_GET['tutorial'] == 1 || !isset($_GET['tutorial'])) echo 'active'?>" id="tutorial1">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="h1"> Tutorial 1: <small> Insert a new device</small></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h4> Introduction </h4>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <p> This tutorial is about how to register a new device in the system. Once it is registered, this device can upload data directly from Arduino or other devices. </p>
                                        </div>
                                    </div>
                                    <h4> Step 1 </h4>
                                    <p> Go to the list of devices and and click on 'Add Device' </p>
                                    <div class="row">
                                        <div class="col-lg-8">
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
                                        <li><i>Active/Inactive: </i>This sets the status of your device</li>
                                        <li><i>Password: </i>This password will be needed to allow changes on this device and for data uploading</li>
                                    </ol>
                                    <div class="row">
                                        <div class="col-lg-8">
                                          <img src="../img/tutorials/tutorial1/tut1step2img1.png" class="img-thumbnail"><br> 
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
                <!-- /.Panel 1 -->
        
                <!-- Panel 2 --> 
                <div role="tabpanel" class="tab-pane <?php if($_GET['tutorial'] == 2) echo 'active'?>" id="tutorial2">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="h1">Tutorial 2: <small> Change device details</small></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h4> Introduction </h4>
                                    <p> This tutorial is about how to change the parameters of a device as well as its password. </p>
                                    <h4> Step 1 </h4>
                                    <p> Go to the list of devices and and click on 'Details' button for the device</p>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial2/tut2step1img1.png" class="img-thumbnail"><br> 
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 2 </h4>
                                    <p> Spread the 'Device Basic Info' submenu </p>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial2/tut2step2img1.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 3 </h4>
                                    <p><i>(Skip this step if you want to change the device password)</i></p>
                                    <ol>
                                        <li>Click on 'Change Info'</li>
                                        <li>Change the parameters that you want</li>
                                        <li>Write the device password in the bottom box</li>
                                        <li>Click on 'Save changes'</li>
                                    </ol>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial2/tut2step3img1.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 4</h4>
                                    <p><i>(This step is just for changing the device password)</i></p>
                                    <ol>
                                        <li>Click on 'Change password'</li>
                                        <li>Write new password</li>
                                        <li>Write the device password in the bottom box</li>
                                        <li>Click on 'Save new password'</li>
                                    </ol>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial2/tut2step4img1.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
                <!-- /.Panel 2 -->
        
                <!-- Panel 3 --> 
                
                <div role="tabpanel" class="tab-pane <?php if($_GET['tutorial'] == 3) echo 'active'?>" id="tutorial3">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="h1">Tutorial 3: <small> Change data fields names</small></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h4> Introduction </h4>
                                    <p> This tutorial is about how to customize the name of each data field for each device.</p>
                                    <h4> Step 1 </h4>
                                    <p> Go to the list of devices and and click on 'Details' button for the device</p>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial3/tut3step1img1.png" class="img-thumbnail"><br> 
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 2 </h4>
                                    <p> Spread the 'Device Data Fields' submenu </p>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial3/tut3step2img1.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 3 </h4>
                                    <ol>
                                        <li>Write new names for all the columns that you want (order can be important in your project)</li>
                                        <li>Write the device password in the bottom box</li>
                                        <li>Click on 'Save changes'</li>
                                    </ol>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial3/tut3step3img1.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
                <!-- /.Panel 3 -->
                
                <!-- Panel 4 --> 
                <div role="tabpanel" class="tab-pane <?php if($_GET['tutorial'] == 4) echo 'active'?>" id="tutorial4">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="h1">Tutorial 4: <small> Insert data from Arduino </small></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h4> Introduction </h4>
                                    <p> This tutorial is about how to insert data into the database from Arduino using an Arduino WiFi Shield</p>
                                    <h4> Step 1 </h4>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <p> In this tutorial we use an Arduino WiFi Shield plugged on an Arduino Uno, but it can be easily adapted for other shields or boards.</p>
                                            <i>
                                                <p><u>IMPORTANT NOTE</u><br>
                                                The Arduino WiFi Shield has a firmware bug.
                                                The official procedure to fix it is upgrading the shield firmware which is difficult 
                                                and can be dangerous for the shield. Otherwise, it works really smoothly uploading the 
                                                code from Arduino IDE version 1.0.2. You can download it <a target="_blank" href="https://www.arduino.cc/en/Main/OldSoftwareReleases">here</a>.
                                                </p>
                                            </i><br>
                                        </div>
                                    </div>
                                    <ul>
                                        <li><p><b>Download the code: </b><a target="_blank" href="../arduino/projects/WifiWebClientRepeating_Basic/WifiWebClientRepeating_Basic.ino"><i class="fa fa-download"></i></a></p></li>
                                    </ul>
                                    <br>
                                    <h4> Step 2 </h4>
                                    <p> Write your network SSID (name) and password</p>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <img src="../img/tutorials/tutorial4/tut4step2img1.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 3 </h4>
                                    <p>Copy the code for that device from the web site</p>
                                    <ol>
                                        <li>Go to the <a target="_blank" href="devices.php">devices list</a></li>
                                        <li>Click on 'Details' button for that device</li>
                                        <li>Spread the 'Arduino Code' submenu</li>
                                        <li>Copy the code for data insertioin</li>
                                    </ol>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="../img/tutorials/tutorial4/tut4step3img1.png" class="img-thumbnail" alt=""/>
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 4</h4>
                                    <p>Replace the custom config code for the code you have copied from 'Details'</p>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <img src="../img/tutorials/tutorial4/tut4step4img1.png" class="img-thumbnail"><br>
                                        </div>
                                        <div class="col-lg-5">
                                            <img src="../img/tutorials/tutorial4/tut4step4img2.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                    <h4> Step 5</h4>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <p>Set the data values</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <img src="../img/tutorials/tutorial4/tut4step5img1.png" class="img-thumbnail"><br>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
                <!-- /.Panel 4 -->
            </div>
        </div>
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}