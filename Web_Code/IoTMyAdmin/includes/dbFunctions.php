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

include_once 'dbConfig.php';
include_once 'paginator.php';

/*
 * create a new connection with the database
 */
function dbConnect(){
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        header("Location: ../error.php?err=Unable to connect to MySQL");
        exit();
    }
    return $conn;
}



/********************
 * devices functions
 ********************/

/*
 * Insert new device
 *  - Insert a new device in 'devices' table. Create a new table for this device
 *  - return true or error message 
 * - devPrivacy = public or username
 */
function dbInsertNewDev($devName, $devPwd, $devType, $devStatus, $devPrivacy, $devNumOfFields){
    $conn = dbConnect();
    
    //check if new device name aready exists
    $result = dbCheckNewDevName($devName);
    if($result!="true"){
        $conn->close();
        return $result;
    }
    for($i=0; $i<$devNumOfFields; $i++){
        if($devType=="Coordinates" && $i==0){
            $devNameOfFieldsStr = "latitude, longitude, ";
            $i=$i+2;
        }
        else{
            $devNameOfFieldsStr .= "dataField".$i.",";
        }
    }
    //delete last comma
    $devNameOfFieldsStr = substr($devNameOfFieldsStr, 0, strlen($devNameOfFieldsStr)-1);
    
    //insert new device into 'devices' table
    $query = "INSERT INTO devices (devName, devPwd, devType, devRegisteredOn, devStatus, devPrivacy, devNumOfFields, devNameOfFields) VALUES ('".$devName."', '".$devPwd."', '".$devType."', CURDATE(), '".$devStatus."', '".$devPrivacy."', ".$devNumOfFields.", '".$devNameOfFieldsStr."')";
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - insert device: ".$query);
    
    //set new table name as "dev"+deviceID. Example: deviceId=1 --> tableName=dev1
    $lastID = mysqli_insert_id($conn);
    $newTableName = "dev".$lastID;
    $query = "UPDATE devices SET devTableName = '".$newTableName."' WHERE devId = ".$lastID;
    $result = mysqli_query($conn, $query) or die("impossible to do query3 - insert device: ".$query);
    
    //create a new table for the new device
    $fieldsQueryStr = "";
    for($i=0; $i<$devNumOfFields; $i++){
        $fieldsQueryStr = $fieldsQueryStr.", devData_".$i." varchar(30) NOT NULL";
    }
    $query = "CREATE TABLE IF NOT EXISTS ".$newTableName." (tableLogId int(11) NOT NULL AUTO_INCREMENT, logDate char(128) NOT NULL, logTime char(30) NOT NULL".$fieldsQueryStr.", PRIMARY KEY (tableLogId))";
    $result = mysqli_query($conn, $query) or die("impossible to do query4 - insert device: ".$query);
    
    $conn->close();
    return true;
}

/*
 * Change device name
 *  - Change the device name in 'devices' table
 *  - return true or error message
 */
function dbChangeDevName($devName, $devPwd, $newDevName){
    $conn = dbConnect();
    
    //check if new device name aready exists
    $result = dbCheckNewDevName($devName);
    if($result!="true"){
        $conn->close();
        return $result;
    }
    
    //check devName & devPwd
    $query = "SELECT * FROM devices WHERE devName = '".$devName."' AND devPwd = '".$devPwd."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - change deviceName: ".$query);
    if(mysqli_num_rows($result)>1){
        $conn->close();
        return "This device is duplicated, admin should fix this problem";
    }else if(mysqli_num_rows($result)<1){
        $conn->close();
        return "This device does not exist or password is not correct";
    }
    $devInfo = mysqli_fetch_assoc($result);
    
    //change device name    
    $query = "UPDATE devices SET devName = '".$newDevName."' WHERE devId = ".$devInfo['devId'];
    $result = mysqli_query($conn, $query) or die("impossible to do query3 - change deviceName: ".$query);
       
    $conn->close(); 
    return true;
}

/*
 * Change device password
 *  - Change the device password in 'devices' table
 *  - return true or error message
 */
function dbChangeDevPwd($devName, $newDevPwd){
    $conn = dbConnect();
    
    //change device password    
    $query = "UPDATE devices SET devPwd = '".$newDevPwd."' WHERE devName = '".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devPwd: ".$query);
            
    $conn->close();
    return true;
}

/*
 * Change device basic info
 *  - return true or error message
 */
function dbChangeBasicInfo($devName, $devNewName, $devNewType, $devNewPrivacy, $devNewStatus){
    $conn = dbConnect();
    
    if($devNewPrivacy=='Private'){$devNewPrivacy=$_SESSION['username'];}
    //change device basic info    
    $query = "UPDATE devices SET devName='".$devNewName."', devType='".$devNewType."', devPrivacy='".$devNewPrivacy."', devStatus='".$devNewStatus."' WHERE devName = '".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change device basic info: ".$query);
            
    $conn->close();
    return true;
}

/*
 * Change device type
 *  - Change the device password in 'devices' table
 *  - return true or error message
 */
function dbChangeDevType($devName, $devPwd, $newDevType){
    $conn = dbConnect();
    
    //check devName & devPwd
    $query = "SELECT * FROM devices WHERE devName = '".$devName."' AND devPwd = '".$devPwd."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devType: ".$query);
    if(mysqli_num_rows($result)>1){
        $conn->close();
        return "This device is duplicated, admin should fix this problem";
    }else if(mysqli_num_rows($result)<1){
        $conn->close();
        return "This device does not exist or password is not correct";
    }
    $devInfo = mysqli_fetch_assoc($result);
    
    //change device name    
    $query = "UPDATE devices SET devType = '".$newDevType."' WHERE devId = ".$devInfo['devId'];
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - change devType: ".$query);
            
    $conn->close();
    return true;
}

/*
 * Get the list of devices
 *  - return the rows of the 'devices' table into an array
 */
function dbGetDevList($limit, $page, $links, $username){
    $conn = dbConnect();
    
    //check deviceName & devicePwd
    $query = "SELECT * FROM devices";
    $paginator  = new paginator( $conn, $query );
    $query = $paginator->getPaginatorQuery( $limit, $page);
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devicePwd: ".$query);
    
    if(mysqli_num_rows($result)>0){
        for($i=0; $i<mysqli_num_rows($result);$i++){
            $result2 = mysqli_fetch_assoc($result);
            if($result2['devPrivacy']=="Public" || $result2['devPrivacy']==$username){
                $table[$i] = $result2;
            }
        }
    }else{
        $conn->close();
        return false;
    }
    
    $table['links'] = $paginator->createLinks($links, 'pagination pagination-sm', "");            
    $conn->close();
    return $table;
}

/*
 * Get the list of device names
 *  - return all the devNames into an array
 */
function dbGetDevNamesList($username){
    $conn = dbConnect();
    
    //check deviceName & devicePwd
    $query = "SELECT devName, devPrivacy FROM devices";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devicePwd: ".$query);
    
    if(mysqli_num_rows($result)>0){
        for($i=0; $i<mysqli_num_rows($result);$i++){
            $temp = mysqli_fetch_assoc($result);
            if($temp['devPrivacy']=="Public" || $temp['devPrivacy'] == $username){
                $table[] = $temp['devName'];
            }
        }
    }else{
        $conn->close();
        return false;
    }
            
    $conn->close();
    return $table;
}

/*
 * Get the list of device names of the type "General Data"
 *  - return all the devNames into an array
 */
function dbGetDevNamesListGeneral($username){
    $conn = dbConnect();
    
    //check deviceName & devicePwd
    $query = "SELECT devName, devPrivacy FROM devices WHERE devType = 'General Data'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devicePwd: ".$query);
    
    if(mysqli_num_rows($result)>0){
        for($i=0; $i<mysqli_num_rows($result);$i++){
            $temp = mysqli_fetch_assoc($result);
            if($temp['devPrivacy']=="Public" || $temp['devPrivacy'] == $username){
                $table[] = $temp['devName'];
            }
        }
    }else{
        $conn->close();
        return false;
    }
            
    $conn->close();
    return $table;
}

/*
 * Get the list of device names of the type "Coordinates"
 *  - return all the devNames into an array
 */
function dbGetDevNamesListCoordinates($username){
    $conn = dbConnect();
    
    //check deviceName & devicePwd
    $query = "SELECT devName, devPrivacy FROM devices WHERE devType = 'Coordinates'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devicePwd: ".$query);
    
    if(mysqli_num_rows($result)>0){
        for($i=0; $i<mysqli_num_rows($result);$i++){
            $temp = mysqli_fetch_assoc($result);
            if($temp['devPrivacy']=="Public" || $temp['devPrivacy'] == $username){
                $table[] = $temp['devName'];
            }
        }
    }else{
        $conn->close();
        return false;
    }
            
    $conn->close();
    return $table;
}

/*
 * Get the list of device names
 *  - return all the devNames into an array
 */
function dbGetDevNumOfLogs($devName){
    $conn = dbConnect();
    
    //check deviceName & devicePwd
    $query = "SELECT devTableName FROM devices WHERE devName='$devName'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devicePwd: ".$query);
    $result = mysqli_fetch_assoc($result);
            
    $query = "SELECT * FROM ".$result['devTableName'];
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devicePwd: ".$query);
    $result = mysqli_num_rows($result);
            
    $conn->close();
    return $result;
}

/*
 * Get device basic info
 *  - return the row of the 'devices' table into an array
 */
function dbGetDevInfo($devName){
    $conn = dbConnect();
    
    //check deviceName & devicePwd
    $query = "SELECT * FROM devices WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - change devicePwd: ".$query);
    
    if(mysqli_num_rows($result)>0){
        $data = mysqli_fetch_assoc($result);
    }else{
        $conn->close();
        return false;
    }
    $conn->close();
    return $data;
}
            

/*
 * Delete device
 *  - Insert a new device in 'devices' table. Create a new table for this device
 *  - return true or error message
 */
function dbDeleteDevice($devName){
    $conn = dbConnect();
    
    //get device info
    $query = "SELECT * FROM devices WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - delete device: ".$query);
    $devInfo = mysqli_fetch_assoc($result);
    
    //Delete individual table
    $query = "DROP TABLE ".$devInfo['devTableName'];
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - delete device: ".$query);
        
    //Delete row in 'devices' table
    $query = "DELETE FROM devices WHERE devId=".$devInfo['devId'];
    $result = mysqli_query($conn, $query) or die("impossible to do query3 - delete device: ".$query);
        
    //Delete rows in 'last_logs' table
    $query = "DELETE FROM last_logs WHERE devId=".$devInfo['devId'];
    $result = mysqli_query($conn, $query) or die("impossible to do query4 - delete device: ".$query);
    
    $conn->close();
    return true;
}

/*
 * Get the name of each field of a device
 *  - return an array with all the names
 */
function dbGetNameOfFields($devName){
    $conn = dbConnect();
    
    //get device info
    $query = "SELECT devNameOfFields FROM devices WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getNameOfFields: ".$query);
    $strNames = mysqli_fetch_assoc($result);
    
    $names = explode(',',$strNames['devNameOfFields']);
    
    $conn->close();
    return $names;
}

/*
 * Change name of each field in one device
 *  - return true if success
 */
function dbChangeNameOfFields($devName, $nameOfFields){    
    $conn = dbConnect();
    
    //get device info
    $query = "SELECT devNumOfFields FROM devices WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - changeNameOfFields: ".$query);
    $devInfo = mysqli_fetch_assoc($result);
    
    if($nameOfFields[0]==""){
        $nameOfFields[0]="dataField0";
    }
    $strNameOfFields = $nameOfFields[0];
    for ($i=1; $i<$devInfo['devNumOfFields']; $i++){
        if($nameOfFields[$i]==""){
            $nameOfFields[$i]="dataField".$i;
        }
        $strNameOfFields = $strNameOfFields.",".$nameOfFields[$i];
    }
    $query = "UPDATE devices SET devNameOfFields = '".$strNameOfFields."' WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - changeNameOfFields: ".$query);
            
    $conn->close();
    return true;
}


/********************
 * data functions
 ********************/

/*
 * Insert device data saving current date and time
 *  - Insert new data: $devData is an array with all fields data
 *  - return true or error message
 */
function dbInsertDevData($devName, $devPwd, $devData){
    $conn = dbConnect();
    
    //check devName & devPwd
    $query = "SELECT * FROM devices WHERE devName = '".$devName."' AND devPwd = '".$devPwd."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - insert data: ".$query);
    if(mysqli_num_rows($result)>1){
        $conn->close();
        return "This device is duplicated, admin should fix this problem";
    }else if(mysqli_num_rows($result)<1){
        $conn->close();
        return "This device does not exist or password is not correct";
    }
    $devInfo = mysqli_fetch_assoc($result);
        
    //insert new data into the device table
    if(sizeof($devData)<$devInfo['devNumOfFields']){
        $conn->close();
        return "Not enough fields sent.";
    }
    $dataQueryStr = "";
    for($i=0;$i<$devInfo['devNumOfFields']; $i++){
        $dataQueryStr = $dataQueryStr.", '$devData[$i]'";
    }
    $query = "INSERT INTO ".$devInfo['devTableName']." VALUES (NULL, CURDATE(), CURTIME()".$dataQueryStr.")";
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - insert data: ".$query);
    $lastID = mysqli_insert_id($conn);
    
    //insert new data into 'last_logs' table
    $query = "INSERT INTO last_logs (devId, tableLogId, timestamp) VALUES ('".$devInfo['devId']."', '".$lastID."', NOW())";
    $result = mysqli_query($conn, $query) or die("impossible to do query3 - insert data: ".$query);
        
    //update 'devLastLog' column in 'devices' table     
    $query = "UPDATE devices SET devLastLog = NOW() WHERE devId = ".$devInfo['devId'];
    $result = mysqli_query($conn, $query) or die("impossible to do query4 - insert data: ".$query);
            
    $conn->close();
    return true;
}

/*
 * Insert random data
 *  - Insert random data
 *  - return true or error message
 */
function dbInsertRandomData($devName){
    $conn = dbConnect();
    
    //check devName & devPwd
    $query = "SELECT * FROM devices WHERE devName = '".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - insert data: ".$query);
    if(mysqli_num_rows($result)>1){
        $conn->close();
        return "This device is duplicated, admin should fix this problem";
    }else if(mysqli_num_rows($result)<1){
        $conn->close();
        return "This device does not exist or password is not correct";
    }
    $devInfo = mysqli_fetch_assoc($result);
    
    $dataQueryStr = "";
    for($i=0;$i<$devInfo['devNumOfFields']; $i++){
        $dataQueryStr = $dataQueryStr.", '".rand(0,100)."'";
    }
    $query = "INSERT INTO ".$devInfo['devTableName']." VALUES (NULL, CURDATE(), CURTIME()".$dataQueryStr.")";
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - insert data: ".$query);
    $lastID = mysqli_insert_id($conn);
    
    //insert new data into 'last_logs' table
    $query = "INSERT INTO last_logs (devId, tableLogId, timestamp) VALUES ('".$devInfo['devId']."', '".$lastID."', NOW())";
    $result = mysqli_query($conn, $query) or die("impossible to do query3 - insert data: ".$query);
        
    //update 'devLastLog' column in 'devices' table     
    $query = "UPDATE devices SET devLastLog = NOW() WHERE devId = ".$devInfo['devId'];
    $result = mysqli_query($conn, $query) or die("impossible to do query4 - insert data: ".$query);
            
    $conn->close();
    return true;
}

/*
 * Insert device data saving current date and time
 *  - Insert new data: $devData is an array with all fields data
 *  - DATE and TIME must have a correct format
 *  - return true or error message
 */
function dbInsertDevDataAndTime($devName, $devPwd, $devData, $logDate, $logTime){
    $conn = dbConnect();
    
    //check devName & devPwd
    $query = "SELECT * FROM devices WHERE devName = '".$devName."' AND devPwd = '".$devPwd."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - insert dataAndTime: ".$query);
    if(mysqli_num_rows($result)>1){
        $conn->close();
        return "This device is duplicated, admin should fix this problem";
    }else if(mysqli_num_rows($result)<1){
        $conn->close();
        return "This device does not exist or password is not correct";
    }
    $devInfo = mysqli_fetch_assoc($result);
    
    $dataQueryStr = "";
    for($i=0;$i<sizeof($devData); $i++){
        $dataQueryStr = $dataQueryStr.", '$devData[$i]'";
    }
    //insert new data into the device table
    $query = "INSERT INTO ".$devInfo['devTableName']." VALUES (NULL, ".$logDate.", ".$logTime.", ".$dataQueryStr.")";
    $result = mysqli_query($conn, $query) or die("impossible to do query3 - insert data: ".$query);
    $lastID = mysqli_insert_id($conn);
    
    //insert new data into 'last_logs' table
    $query = "INSERT INTO last_logs (devId, tableLogId) VALUES ('".$devInfo['devId']."', '".$lastID."')";
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - insert data: ".$query);
    
    $conn->close();
    return true;
}

/*
 * Get the list of last logs
 *  - return the last logs info and data
 */
function dbGetLastLogs($limit, $page, $link, $username){
    $conn = dbConnect();  
    
    $query = "SELECT * FROM last_logs ORDER BY logId DESC";
    $paginator  = new paginator( $conn, $query );
    $query = $paginator->getPaginatorQuery( $limit, $page);
    
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getLastLogs: ".$query);
        
    if(mysqli_num_rows($result)>0){
        for($i=0; $i<mysqli_num_rows($result);$i++){
            $lastLogsRow = mysqli_fetch_assoc($result);
            
            $query = "SELECT devName, devTableName,devNumOfFields, devPrivacy FROM devices WHERE devId=".$lastLogsRow['devId'];
            $result2 = mysqli_query($conn, $query) or die("impossible to do query2 - getLastLogs: ".$query);
            $devicesRow = mysqli_fetch_assoc($result2);
            if ($devicesRow['devPrivacy']=='Public' || $devicesRow['devPrivacy']==$username){
                $myRow['logId']=$devicesRow['devTableName']."#".$lastLogsRow['tableLogId'];
                $myRow['devName']=$devicesRow['devName'];

                $query = "SELECT * FROM ".$devicesRow['devTableName']." WHERE tableLogId=".$lastLogsRow['tableLogId'];
                $result3 = mysqli_query($conn, $query) or die("impossible to do query4 - getLastLogs: ".$query);
                $dataTableRow = mysqli_fetch_array($result3); //['tabeLogId','logDate','logTime','devData1','devData2',...]
                $myRow['logDate']=$dataTableRow[1];
                $myRow['logTime']=$dataTableRow[2];
                $data=array();
                for($j=0;$j<$devicesRow['devNumOfFields'];$j++){
                    $data[]=$dataTableRow[$j+3];
                }
                $myRow['data']=$data;
                $table[]=$myRow;
            }
        }
    }else{
        $conn->close();
        return false;
    }
    //              ['logId']                 ['devName']['logDate']['logTime'] ['data']
    //table[][] = {logId(tbaleName+tableLogId), devName,   logDate,   logTime, (array)data}
    $table['links'] = $paginator->createLinks($links, 'pagination pagination-sm', "");
    $conn->close();
    return $table;
}

/*
 * Get device data from databse
 *  - return device data array (include paginator links)
 */
function dbGetDataTable($devName, $limit, $page, $links){    
    $conn = dbConnect();
    
    $query = "SELECT devTableName,devNumOfFields FROM devices WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getDataTable: ".$query);
    $devMainInfo = mysqli_fetch_assoc($result);
    
    $query = "SELECT * FROM ".$devMainInfo['devTableName']." ORDER BY tableLogId DESC";
    $paginator  = new paginator( $conn, $query );
    $query = $paginator->getPaginatorQuery( $limit, $page);
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - getDataTable: ".$query);
    
    if(mysqli_num_rows($result)>0){
        for($i=0; $i<mysqli_num_rows($result);$i++){
            $dataTableRow = mysqli_fetch_array($result);            
            
            $myRow['logId']=$dataTableRow['tableLogId'];
            $myRow['logDate']=$dataTableRow['logDate'];
            $myRow['logTime']=$dataTableRow['logTime'];
            $data=array();
            for($j=0;$j<$devMainInfo['devNumOfFields'];$j++){
                $data[]=$dataTableRow[$j+3];
            }
            $myRow['data']=$data;
            $table[]=$myRow;
        }
    }else{
        $conn->close();
        return false;
    }
    //              ['logId']                 ['devName']['logDate']['logTime'] ['data']
    //table[][] = {logId(tbaleName+tableLogId), devName,   logDate,   logTime, (array)data}
    $extraGetParams = "&devName=".$devName;
    $table['links'] = $paginator->createLinks($links, 'pagination pagination-sm', $extraGetParams);
    $conn->close();
    return $table;
}

/*
 * Get device data from database from $firstData sample getting $numOfSamples samples
 *  - return device data array
 */
function dbGetDataTable_offset($devName, $firstData, $numOfSamples){    
    $conn = dbConnect();
    
    $query = "SELECT devTableName,devNumOfFields FROM devices WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getDataTable: ".$query);
    $devMainInfo = mysqli_fetch_assoc($result);
    
    $query = "SELECT * FROM ".$devMainInfo['devTableName']." ORDER BY tableLogId DESC";
    
    if ($numOfSamples == 'all') {
    } 
    else {
        $query = $query." LIMIT ".$firstData.",".$numOfSamples;
    }
    $result = mysqli_query($conn, $query) or die("impossible to do query2 - getDataTable: ".$query);
    
    if(mysqli_num_rows($result)>0){
        for($i=0; $i<mysqli_num_rows($result);$i++){
            $dataTableRow = mysqli_fetch_array($result);            
            
            $myRow['logId']=$dataTableRow['tableLogId'];
            $myRow['logDate']=$dataTableRow['logDate'];
            $myRow['logTime']=$dataTableRow['logTime'];
            $data=array();
            for($j=0;$j<$devMainInfo['devNumOfFields'];$j++){
                $data[]=$dataTableRow[$j+3];
            }
            $myRow['data']=$data;
            $table[]=$myRow;
        }
    }else{
        $conn->close();
        return false;
    }
    //              ['logId']                 ['devName']['logDate']['logTime'] ['data']
    //table[][] = {logId(tbaleName+tableLogId), devName,   logDate,   logTime, (array)data}
    $conn->close();
    return $table;
}

/*
 * Get number of logs within the last hour
 *  - return the number of logs within the last hour
 */
function dbGetNumLogsLastHour(){
       
    $conn = dbConnect();    
    
    $query = "SELECT * FROM last_logs WHERE timestamp > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getnumOfDevices: ".$query);
    
    $conn->close();
    return mysqli_num_rows($result);
}

/*
 * Get the total number of logs
 *  - return the total number of logs
 */
function dbGetTotalNumLogs(){
    $conn = dbConnect();    
    
    $query = "SELECT * FROM last_logs";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getnumOfDevices: ".$query);
    
    $conn->close();
    return mysqli_num_rows($result);
}

/*
 * Get dev data from coordinates devices
 *  - return device data array
 */
function dbGetDevData_Coordinates($devName, $iniDate){
    $conn = dbConnect();
    
    $query = "SELECT devTableName,devNumOfFields FROM devices WHERE devName='".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getDataTable: ".$query);
    $devMainInfo = mysqli_fetch_assoc($result);
    
    $table = array();
    if($devName!=""){
        $query = "SELECT * FROM ".$devMainInfo['devTableName'];
        $query = $query." WHERE logDate <= CURDATE()";//STR_TO_DATE(".$iniDate.", '%Y/%m/%d')";
        $query = $query." ORDER BY tableLogId DESC";

        $result = mysqli_query($conn, $query) or die("impossible to do query2 - getDataTable: ".$query);

        if(mysqli_num_rows($result)>0){
            for($i=0; $i<mysqli_num_rows($result);$i++){
                $dataTableRow = mysqli_fetch_array($result);            

                $myRow['logId']=$dataTableRow['tableLogId'];
                $myRow['logDate']=$dataTableRow['logDate'];
                $myRow['logTime']=$dataTableRow['logTime'];
                $data=array();
                $data['latitude']=$dataTableRow[3];
                $data['longitude']=$dataTableRow[4];
                $myRow['data']=$data;
                $table[]=$myRow;
            }
        }else{
            $conn->close();
            return false;
        }
    }
    //              ['logId']                 ['devName']['logDate']['logTime'] ['data']
    //table[][] = {logId(tbaleName+tableLogId), devName,   logDate,   logTime, (array)data}
    $conn->close();
    return $table;
}


/********************
 * aux functions
 ********************/

/*
 * Check device name format
 *  - return true or false
 */
function dbCheckDevName_format($devName){
    //valid devname (alphanumeric + 6 characters min
    if(!preg_match('/^[a-zA-Z0-9]{6,}$/', $devName)) {
        return false;
    }
    return true;
}

/*
 * check if the device name aready exists
 *  - return true or false
 */
function dbCheckDevName_exist($devName){
    $conn = dbConnect();    
    
    $query = "SELECT * FROM devices WHERE devName = '".$devName."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - check devName_exist: ".$query);
    if(mysqli_num_rows($result)>0){
        $conn->close();
        return true;
    }
    $conn->close();
    return false;
}

/*
 * Check device name
 *  - return true or error message
 */
function dbCheckNewDevName($devName){
    //valid devname (alphanumeric + 6 characters min
    if(!dbCheckDevName_format($devName)) {
        return "Device name is not valid";
    }
    
    if(dbCheckDevName_exist($devName)) {
        return "This device name already exists. Please choose another one";
    }
    return true;
}

/*
 * Check correct password
 *  - return true is it is correct or false if it isn't
 */
function dbCheckCorrectDevPwd($devName, $devPwd){
    $conn = dbConnect();    
    
    $query = "SELECT * FROM devices WHERE devName= '".$devName."' AND devPwd= '".$devPwd."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - check devName_exist: ".$query);
    if(mysqli_num_rows($result)>0){
        $conn->close();
        return true;
    }
    $conn->close();
    return false;
}

/*
 * Get the number of devices registered
 *  - return the number of devices registered
 */
function dbGetNumOfDevices(){    
    $conn = dbConnect();    
    
    $query = "SELECT * FROM devices";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - getnumOfDevices: ".$query);
    
    $conn->close();
    return mysqli_num_rows($result);
}


/********************
 * user functions
 ********************/

/*
 * get the email from database
 *  - return the email or false
 */
function dbGetUserEmail($username){
    $conn = dbConnect();    
    
    $query = "SELECT email FROM members WHERE username= '".$username."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - check devName_exist: ".$query);
    if(mysqli_num_rows($result)>0){
        $result = mysqli_fetch_assoc($result);
        $conn->close();
        return $result['email'];
    }
    $conn->close();
    return false;
}
/*
 * get the email from database
 *  - return the email or false
 */
function dbGetUserRole($username){
    $conn = dbConnect();    
    
    $query = "SELECT role FROM members WHERE username= '".$username."'";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - check devName_exist: ".$query);
    if(mysqli_num_rows($result)>0){
        $result = mysqli_fetch_assoc($result);
        $conn->close();
        return $result['role'];
    }
    $conn->close();
    return false;
}

/*
 * get the users list
 *  - return the users list in an array
 */
function dbGetUsersList(){
    $conn = dbConnect();    
    
    $query = "SELECT username FROM members";
    $result = mysqli_query($conn, $query) or die("impossible to do query1 - GetUsersList: ".$query);
    if(mysqli_num_rows($result)>0){
        $i=0;
        while($i<mysqli_num_rows($result)){
            $users[] = mysqli_fetch_assoc($result);
            $i++;
        }
        $conn->close();
        return $users;
    }
    $conn->close();
    return false;
}