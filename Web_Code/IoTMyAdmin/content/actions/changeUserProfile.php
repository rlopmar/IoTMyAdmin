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

if(isset($_GET['opt'])){
    $check=dbCheckCorrectDevPwd($_POST['devName'], $_POST['devActualPwd']);
    if($check==true){
        if($_GET['opt']=="info"){
            $result = dbCheckDevName_format($_POST['devNewName']);
            if($result==false){
                header('Location: ../devDetails.php?devName='.$_POST['devName'].'&errorMessage=New device name has not correct format');
                exit();
            }
            $result = dbCheckDevName_exist($_POST['devNewName']);
            if($_POST['devName']!=$_POST['devNewName'] && $result==true){
                header('Location: ../devDetails.php?devName='.$_POST['devName'].'&errorMessage=New device name already exist');
                exit();                
            }
            
            $email = dbGetUserEmail($_SESSION['username']);
            if($email==false){                    
                header('Location: ../../error.php?err=Please log in again');
                exit();
            }
            //Change info
            $result = dbChangeBasicInfo($_POST['devName'], $_POST['devNewName'], $_POST['devNewType'], $_POST['devNewPrivacy'], $_POST['devNewStatus']);
            if ($result == true){                
                /* send email functions. It doesn't work in local
                $to = $email;
                $subject = "Device changes: Basic info";
                $txt = "There were some changes in your ".$_POST['devName']." device.\r\n\r\n"
                      ."Device name: ".$_POST['devNewName']
                      ."Type: ".$_POST['devNewType']
                      ."Num of Fields: ".$_POST['devNewNumOfFields']
                      ."Privacy: ".$_POST['devNewPrivacy']
                      ."Status: ".$_POST['devNewStatus'];
                $headers = "From: no_replay@".$_SERVER[HTTP_HOST]."\r\n";
                mail($to,$subject,$txt,$headers);
                */
                header('Location: ../devDetails.php?devName='.$_POST['devNewName'].'&success=Device info was changed');
                exit();
            }else{
                header('Location: ../devDetails.php?devName='.$_POST['devName'].'&errorMessage=Impossible to change device info');
                exit();
            }
        }
        else if($_GET['opt']=="pwd"){
            if($_POST['devNewPwd'] == $_POST['devConfirmNewPwd']){  
                if(strlen($_POST['devNewPwd'])<6){
                    header('Location: ../devDetails.php?devName='.$_POST['devName'].'&errorMessage=New password should have 6 or more characters');
                    exit();
                }
                
                $email = dbGetUserEmail($_SESSION['username']);
                if($email==false){                  
                    header('Location: ../../error.php?err=Please log in again');
                    exit();
                }
                //change password
                $result = dbChangeDevPwd($_POST['devName'], $_POST['devNewPwd']);
                if ($result == true){
                    /* send email functions. It doesn't work in local
                    $to = $email;
                    $subject = "Device changes: Password";
                    $txt = "There were some changes in your ".$_POST['devName']." device.\r\n\r\n"
                          ."New Password: ".$_POST['devNewPwd'];
                    $headers = "From: no_replay@".$_SERVER[HTTP_HOST]."\r\n";
                    mail($to,$subject,$txt,$headers);
                    */
                    header('Location: ../devDetails.php?devName='.$_POST['devName'].'&success=Device password was changed');
                    exit();                    
                }else{
                    header('Location: ../devDetails.php?devName='.$_POST['devName'].'&errorMessage=impossible to change password');
                    exit();
                }
            }else{
                header("Location: ../devDetails.php?devName=".$_POST['devName']."&errorMessage=Passwords don't match");
                exit();
            }
        }
    }else {
        header('Location: ../devDetails.php?devName='.$_POST['devName'].'&errorMessage=Please insert the correct password for this device');
        exit();
    }
}
header('Location: ../devDetails.php?devName='.$_POST['devName'].'&errorMessage=Sorry an unknown error happened');
exit();