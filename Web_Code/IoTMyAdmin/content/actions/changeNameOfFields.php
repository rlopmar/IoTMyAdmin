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

if(isset($_POST['names'])&& isset($_GET['devName'])){
    if(isset($_POST['devActualPwd'])){
        $result = dbCheckCorrectDevPwd($_GET['devName'], $_POST['devActualPwd']);
        if($result == true){
            $result = dbChangeNameOfFields($_GET['devName'], $_POST['names']);
            if($result == true){
                header('Location: ../devDetails.php?devName='.$_GET['devName'].'&success=Name of fields changed');
                exit();
            }
            header('Location: ../devDetails.php?devName='.$_GET['devName'].'&errorMessage=Impossible to change name of fields');
            exit();
        }
        header('Location: ../devDetails.php?devName='.$_GET['devName'].'&errorMessage=Please insert the correct password for this device');
        exit();
    }
    header('Location: ../devDetails.php?devName='.$_GET['devName'].'&errorMessage=you should insert the password for this device');
    exit();
}
header('Location: ../devDetails.php?devName='.$_GET['devName'].'&errorMessage=Sorry an unknown error happened');
exit();