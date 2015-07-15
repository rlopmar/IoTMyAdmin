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

//set variables
if (isset($_GET['newDev_checkDevNameErrorMsg'])) {
    $newDev_checkDevNameErrorMsg = $_GET['newDev_checkDevNameErrorMsg'];
}
if (isset($_GET['newDev_checkPwdError'])) {
    $newDev_checkPwdErrorMsg = $_GET['newDev_checkPwdError'];
}
if (isset($_GET['newDev_insertErrorMsg'])) {
    $newDev_insertErrorMsg = $_GET['newDev_insertErrorMsg'];
}


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - New Device");
$header->closeHeader();

openBody();
printNavbarAndSidebar("newDevice");
printBody($_GET['devName'],$_GET['devType'],$_GET['devNumOfFields'],$_GET['devPrivacy'],$_GET['devStatus'],$newDev_insertErrorMsg, $newDev_checkDevNameErrorMsg, $newDev_checkPwdErrorMsg);
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody($postDevName, $postDevType, $postDevNumOfFields, $postDevPrivacy, $postDevStatus, $newDev_insertErrorMsg, $newDev_checkDevNameErrorMsg, $newDev_checkPwdErrorMsg){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row" >
            <div class="col-lg-12">
                <h1 class="page-header">
                    Add Device
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php"> Devices</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-plus"></i> Add Device
                    </li>
                </ol>                        
            </div>
        </div>
        <!-- /.Page Heading -->
        
        <!-- New device form -->
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="text-center" style="margin-bottom: 10px"><h2>New device details</h2></div>
                <div id="loginFormWrapper" class="modal-body">
                    <div style="text-align:center; color:red;"><p><?php echo $newDev_insertErrorMsg ?></p></div>
                    <form data-toggle="validator" role="form" name="newDevice_form" method="post" action="actions/addDevice.php" class="form col-md-12 center-block">
                        <div class="row">
                            <div class="form-group">
                                <input type="text" name="devName" id="devName" class="form-control input" placeholder="Name" value="<?php echo $postDevName; ?>">
                                <h4><small style="color: red"><?php echo $newDev_checkDevNameErrorMsg ?></small></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <select name="devType" id="devType" class="form-control input" placeholder="Type" value="<?php echo $postDevType; ?>">
                                    <option value="General Data">General Data</option>
                                    <option value="Coordinates">Coordinates</option>
                                </select>
                                <h4><small style="color: red"></small></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-4">
                                    <input type="number" name="devNumOfFields" id="devNumOfFields" class="form-control input" placeholder="Number of fiedls" value="<?php $postDevNumOfFields; ?>">
                                    <h4><small style="color: red"></small></h4>
                                </div>
                                <div class="col-lg-4">
                                    <?php 
                                    $optionPublic=""; 
                                    $optionPrivate="";
                                    if($postDevPrivacy == 'Public'){$optionPublic="selected";}
                                    if($postDevPrivacy == 'Private'){$optionPrivate="selected";}
                                    ?>
                                    <select name="devPrivacy" id="devPrivacy" class="form-control" placeholder="Privacy"><option <?php echo $optionPublic; ?>>Public</option><option <?php echo $optionPrivate; ?>>Private</option></select>
                                    <h4><small style="color: red"></small></h4>
                                </div>
                                <div class="col-lg-4">
                                    <?php 
                                    $optionActive=""; 
                                    $optionInactive="";
                                    if($postDevStatus == 'Active'){$optionActive="selected";}
                                    if($postDevStatus == 'Inactive'){$optionInactive="selected";}
                                    ?>
                                    <select name="devStatus" id="devStatus" class="form-control" placeholder="Status"><option <?php $optionActive; ?>>Active</option><option <?php echo $optionInactive; ?>>Inactive</option></select>
                                    <h4><small style="color: red"></small></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input title="Password needed to insert data" type="password" name="devPwd" id="devPwd" class="form-control input" placeholder="Password (Minimum of 6 characters)">
                                <h4><small style="color: red"><?php echo $newDev_checkPwdErrorMsg ?></small></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input type="password" name="devConfirmPwd" id="devConfirmPwd" class="form-control input" placeholder="Confirm password">
                                <h4><small style="color: red"></small></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input id="btnAdd" type="submit" name="btnAdd" class="btn btn-primary btn-block" value="Add">
                            </div>
                        </div>
                    </form>                            
                </div>
            </div>
        </div>
        <!-- /.New device form -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}