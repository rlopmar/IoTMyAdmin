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

include_once 'includes.php';


/*
 * Prepare multiple data string for JavaScript functions
 *  - select data: select the first entry and how many entries to show
 */
function chartsPrepMultData_offset($devName, $firstData, $numOfSamples){
    $data = dbGetDataTable_offset($devName, $firstData, $numOfSamples);
    if($data>0){
        foreach ($data as $row){
            $rowDate = explode('-',$row['logDate']);
            $rowTime = explode(':',$row['logTime']);
            $resultStr .= "[new Date(".$rowDate[0].",".$rowDate[1].",".$rowDate[2].",".$rowTime[0].",".$rowTime[1].",".$rowTime[2].")";
            $index =0;
            foreach ($row['data'] as $data){
                $resultStr .= ",".$data;
                $index+=1;
            }
            $resultStr .= "],";
        }
        //delete last comma
        if(strlen($resultStr)>0){
            $resultStr= substr($resultStr, 0, strlen($resultStr)-1);
        }
    }
return $resultStr;
}

function chartsPrepColNames($devName){    
    $dataNames= dbGetNameOfFields($devName);
    foreach ($dataNames as $name){
        echo "data.addColumn('number', '.$name.' )";
    }
}
function chartsPrepRows_mainPage($username){    
    $devNames= dbGetDevNamesList($username);
    foreach ($devNames as $name){
        $numOfLogs = dbGetDevNumOfLogs($name);
        $resultStr .="['".$name."',".$numOfLogs."],";
    }
    //delete last comma
    if(strlen($resultStr)>0){
        $resultStr= substr($resultStr, 0, strlen($resultStr)-1);
    }
    return $resultStr;
}