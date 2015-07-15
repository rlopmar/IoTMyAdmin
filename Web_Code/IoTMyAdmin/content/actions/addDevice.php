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
  
include_once '../../includes/includes.php';

sec_session_start();
if(!isset($_SESSION['username'])) {
    header("Location: ../../logout.php");
    exit();
}


//Check parameters
$message = dbCheckNewDevName($_POST['devName']);
if($message!="true"){
    header('Location: ../newDevice.php?newDev_checkDevNameErrorMsg='.$message.'&devName='.$_POST['devName'].'&devType='.$_POST['devType'].'&devNumOfFields='.$_POST['devNumOfFields'].'&devPrivacy='.$_POST['devPrivacy'].'&devStatus='.$_POST['devStatus']);
    exit();
}
$message = newDev_checkDevPwd($_POST['devPwd'], $_POST['devConfirmPwd']);
if($message!="true"){
    header('Location: ../newDevice.php?newDev_checkPwdError='.$message.'&devName='.$_POST['devName'].'&devType='.$_POST['devType'].'&devNumOfFields='.$_POST['devNumOfFields'].'&devPrivacy='.$_POST['devPrivacy'].'&devStatus='.$_POST['devStatus']);
    exit();
}

//Parameters ok. Insert in database
$devPrivacy="Public";
if($_POST['devPrivacy']=='Private'){$devPrivacy=$_SESSION['username'];}
$message = dbInsertNewDev($_POST['devName'], $_POST['devPwd'], $_POST['devType'], $_POST['devStatus'], $devPrivacy, $_POST['devNumOfFields']);
if($message!="true"){
    header('Location: ../newDevice.php?newDev_insertErrorMsg='.$message.'&devName='.$_POST['devName'].'&devType='.$_POST['devType'].'&devNumOfFields='.$_POST['devNumOfFields'].'&devPrivacy='.$_POST['devPrivacy'].'&devStatus='.$_POST['devStatus']);
    exit();
}
header('Location: ../newDevice_success.php');
exit();

/*
 * Check device passwords
 */
function newDev_checkDevPwd($devPwd, $devConfirmPwd){
    //check password format and lenght
    if(!preg_match('/^[a-zA-Z0-9]{6,}$/', $devPwd)) {
        return "Device password is not valid. Minimum 6 alphanumeric characters.";
    }
    if($devPwd != $devConfirmPwd){
        return "These passwords do not match.";        
    }
    return true;
}
