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
  
include_once '../includes/includes.php';

if (isset($_GET['data']) && !empty($_GET['data'])){
    foreach($_GET['data'] as $value){
        //url format: myhost.com/postTest?data=["devName","devPsw",devData1,devData2,...]
        $data = myDecode($value);
        $devName = $data[0];
        $devPwd = $data[1];
        for($i=2;$i<sizeof($data);$i++){
            $devData[$i-2]=$data[$i];
        }        
        $result = dbInsertDevData($devName, $devPwd, $devData);
        echo $result;
    }
    exit();
}
echo "check parameters<br>";
echo "data: ".$_GET['PostData'];
exit();

function myDecode($string){
    $result= stripslashes($string);
    $result=str_replace('[','',$result);
    $result=str_replace(']','',$result); 
    $result=str_replace('"','',$result);
    $result= explode(',',$result);
    return $result;
}