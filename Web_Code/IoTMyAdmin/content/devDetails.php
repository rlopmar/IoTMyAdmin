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

//Set variables
$errorMessage="";
if(isset($_GET['errorMessage'])) {
    $errorMessage=$_GET['errorMessage'];
}
$success="";
if(isset($_GET['success'])) {
    $success=$_GET['success'];
}
$devInfo = dbGetDevInfo($_GET['devName']);
$nameOfFields = dbGetNameOfFields($_GET['devName']);


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Device Details");
$header->closeHeader();

openBody();
printNavbarAndSidebar("devDetails");
printBody($devInfo, $nameOfFields, $errorMessage, $success);
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody($devInfo, $nameOfFields, $errorMessage, $success){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Device Details: 
                    <small><?php echo $devInfo['devName']; ?></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php">Devices</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-search"></i> Details
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.Page Heading -->
        <?php
        if($errorMessage!=""){
        ?>
        <!-- Error Message -->
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center alert alert-danger" role="alert" style="margin-bottom: 10px">
                    <h3><i class="glyphicon glyphicon-warning-sign"></i> <?php echo $errorMessage; ?></h3>
                </div>                
            </div>
        </div>
        <?php
        }
        if($success!=""){
        ?>
        <!-- Success Message -->
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center alert alert-success" role="alert" style="margin-bottom: 10px">
                    <h3><i class="glyphicon glyphicon-check"></i> <?php echo $success; ?></h3>
                </div>                
            </div>
        </div>
        <?php
        }
        ?>
        <!-- Accordion panels -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            
            <!-- Panel 1 -->
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h4 class="panel-title">
                        Device Basic Info
                        <i class="fa fa-caret-down" style="padding-left: 5px"></i>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group input-group control-label">
                                    <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Name: </span>
                                    <p class="form-control" aria-describedby="sizing-addon3" ><?php echo $devInfo['devName']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group">
                                    <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Type: </span>
                                    <p class="form-control" aria-describedby="sizing-addon3"><?php echo $devInfo['devType']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group">
                                    <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Registered on: </span>
                                    <p class="form-control" aria-describedby="sizing-addon3" ><?php echo $devInfo['devRegisteredOn']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group">
                                    <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Status: </span>
                                    <p class="form-control" aria-describedby="sizing-addon3" ><?php echo $devInfo['devStatus']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group">                               
                                    <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Privacy: </span>
                                    <p class="form-control" aria-describedby="sizing-addon3" ><?php echo $devInfo['devPrivacy']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group">                               
                                    <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Num of fields: </span>
                                    <p class="form-control" aria-describedby="sizing-addon3" ><?php echo $devInfo['devNumOfFields']; ?></p>
                                </div>
                            </div>
                            <!-- Change info button: modal trigger -->
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6" style="margin-bottom: 30px;">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#changeInfoModal">Change Info</button>                                  
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <div class="input-group">                               
                                            <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Password: </span>
                                            <p class="form-control" aria-describedby="sizing-addon3" disabled>*************</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Change password button: modal trigger -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeDevPwdModal">Change password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Change info modal -->
                            <div class="modal fade" id="changeInfoModal" tabindex="-1" role="dialog" aria-labelledby="changeInfoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form role="form" name="changeDevBasicInfo_form" method="post" action="actions/changeDevBasicInfo.php?opt=info">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Change device basic info</h4>
                                            </div>
                                            <div class="modal-body">                                          
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="loginFormWrapper" class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="devName" id="devName" value="<?php echo $devInfo['devName']; ?>">
                                                                    <input type="text" name="devNewName" id="devNewName" class="form-control input" placeholder="New device name" value="<?php echo $devInfo['devName']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <?php 
                                                                    $optionGeneral=""; $optionCoordinates="";
                                                                    if($devInfo['devType'] == 'General Data'){$optionGeneral="selected";}
                                                                    else{$optionCoordinates="selected";}
                                                                    ?>
                                                                    <select name="devNewType" id="devNewType" class="form-control" placeholder="Type"><option value="General Data" <?php echo $optionGeneral; ?>>General Data</option><option value="Coordinates" <?php echo $optionCoordinates;?>>Coordinates</option></select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <input type="number" name="devNewNumOfFields" id="devNewNumOfFields" class="form-control" placeholder="Number of fiels" value="<?php echo $devInfo['devNumOfFields'];?>" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <?php 
                                                                        $optionPublic=""; $optionPrivate="";
                                                                        if($devInfo['devPrivacy'] == 'Public'){$optionPublic="selected";}
                                                                        else{$optionPrivate="selected";}
                                                                        ?>
                                                                        <select name="devNewPrivacy" id="devNewPrivacy" class="form-control" placeholder="Privacy"><option <?php echo $optionPublic; ?>>Public</option><option <?php echo $optionPrivate;?>>Private</option></select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <?php 
                                                                        $optionActive=""; 
                                                                        $optionInactive="";
                                                                        if($devInfo['devStatus'] == 'Active'){$optionActive="selected";}
                                                                        else{$optionInactive="selected";}
                                                                        ?>
                                                                        <select name="devNewStatus" id="devNewStatus" class="form-control" placeholder="Status"><option <?php echo $optionActive; ?>>Active</option><option <?php echo $optionInactive; ?>>Inactive</option></select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                                  
                                            <div class="modal-footer">
                                                <div class="row">       
                                                    <div class="col-lg-6">                                         
                                                        <div class="form-group">
                                                            <input type="password" name="devActualPwd" id="devActualPwd" class="form-control input" placeholder="Introduce actual password">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>     
                                    </div>
                                </div>
                            </div>
                            <!-- /.Change info modal -->
                            <!-- Change password modal -->
                            <div class="modal fade" id="changeDevPwdModal" tabindex="-1" role="dialog" aria-labelledby="changeDevPwdModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form role="form" name="changeDevPwd_form" method="post" action="actions/changeDevBasicInfo.php?opt=pwd">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Change device password</h4>
                                            </div>
                                            <div class="modal-body">                                          
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="loginFormWrapper" class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="devName" id="devName" value="<?php echo $devInfo['devName']; ?>">                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <input type="password" name="devNewPwd" id="devNewPwd" class="form-control input" placeholder="New password (Minimum of 6 characters)">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <input type="password" name="devConfirmNewPwd" id="devConfirmNewPwd" class="form-control input" placeholder="Confirm new password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="password" name="devActualPwd" id="devActualPwd" class="form-control input" placeholder="Introduce actual password">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save new password</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>   
                                    </div>
                                </div>
                            </div>
                            <!-- /.Change password modal -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel 2 -->
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h4 class="panel-title">
                        Device Data Fields
                        <i class="fa fa-caret-down" style="padding-left: 5px"></i>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <form role="form" name="changeNameOfFields_form" method="post" action='actions/changeNameOfFields.php?devName=<?php echo $devInfo['devName']; ?>'>
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="text-center input-group-addon">Actual Names</th>
                                                    <?php
                                                    for($i=0; $i<$devInfo['devNumOfFields'];$i++){
                                                        if($nameOfFields[$i]==""){
                                                            $nameOfFields[$i]="dataField".$i;
                                                        }
                                                        echo "<th class='text-center'>".$nameOfFields[$i]."</th>";                                                        
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center input-group-addon">Change Names</td>                                                  
                                                    <?php
                                                    for($i=0; $i<$devInfo['devNumOfFields'];$i++){
                                                        echo "<td class='text-center'><input type='text' name='names[]' id='names[]' class='form-control' value=".$nameOfFields[$i]."></td>";                                                        
                                                    }
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input type="password" name="devActualPwd" id="devActualPwd" class="form-control input" placeholder="Insert device password">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel 3 -->
            <div class="panel panel-info">
                <div class="panel-heading" role="tab" id="headingThree"   data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <h4 class="panel-title">
                        <img src="../img/Arduino.png" style="height: 20px; padding-right: 10px;">
                        Arduino Code  
                        <i class="fa fa-caret-down" style="padding-left: 5px"></i>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h3>Code for data insertion</h3>
                            <p>1. Paste this code at the begining of the sketch</p>
                            <pre class="pre-scrollable" style="max-height: 300px">
<?php
$webPath= explode('/',$_SERVER['PHP_SELF']);
$strNameOfFields=$nameOfFields[0];
for($i=1; $i<$devInfo['devNumOfFields'];$i++){
$strNameOfFields=$strNameOfFields.", ".$nameOfFields[$i];                                                        
}

$code = '//--------------
// CUSTOM CONFIG
//--------------
String yourHost="'.$_SERVER[HTTP_HOST].'"; //your web host name or IP address
String yourPath="/'.$webPath[1].'/arduino/postData.php"; //your path for data insertion

String devName="'.$devInfo['devName'].'"; //Device name which is inserting data
String devPwd="mySecretPassword"; //Insert Device password

//uncomment for multiple devices data insertion
//String devName2="myDevice2";
//String devPwd2="myDevice2Password";';
echo $code;
?>
                            </pre>
                            <p>2. Paste this code before send the HTML request to know the order of your parameters</p>
                            <pre class="pre-scrollable" style="max-height: 300px">
<?php
$code = '//Data string in this order: '.$strNameOfFields.'
String devData="data1,data2,data3,...";
//uncomment for multiple devices data insertion
//String devData2="data1,data2,data3,...";';
echo $code;
?>
                            </pre>
                            <p>Click <a href="tutorial.php?tutorial=4">here</a> for more information about how to insert data from Arduino
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Accordion panels -->

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}