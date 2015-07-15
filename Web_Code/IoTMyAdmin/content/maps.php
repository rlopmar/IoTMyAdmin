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

//set data
$devNamesList = dbGetDevNamesListCoordinates($_SESSION['username']);


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Maps");
$header->closeHeader();

openBody();
printNavbarAndSidebar("devMaps");
printBody($devNamesList);
closeBody();

$footer = new outputFooter();
printKmlMaps($_POST['devName'], $_POST['iniDate']);
$footer->closeHtml();

/**************************************************************************
 * custom html code
 *******************/ 
function printBody($devNamesList){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Maps
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php">Devices</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-map-marker"></i> Maps
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.Page Heading -->               

        
        <!-- Chart Form -->         
        <div class="row">
            <div class="col-lg-12">    
                <form role="form" name="chartForm" method="post" action="<?php echo $_SERVER[REQUEST_URI]; ?>">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="devName">Device: </label>
                            <select name="devName" id="devName" class="form-control">
                                <option disabled selected>Select</option>
                                <?php
                                if($devNamesList!=""){
                                    foreach ($devNamesList as $value){
                                        echo "<option>".$value."</option>";
                                    }
                                }
                                else{
                                    echo "<option>There is not devices registed</option>";
                                }
                                ?>
                            </select>
                            <?php
                            if ($errorMessages[0]==1){
                                echo '<p style="color: red">Select a device</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="iniDate">Initial Date: </label>
                            <input type="date" name="iniDate" id="iniDate" class="form-control" value="2015-01-01">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group" style="margin-top: 25px">
                            <input type="submit" class="btn btn-block btn-primary" value="Show Map">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.Chart Form --> 
        
         
        <?php
        if(isset($_POST['devName'])){
        ?>
        <!-- Chart Holder -->
        <div class="row center-block">
            <div class="col-lg-1"></div>
            <div class="col-lg-10" style="box-shadow: 2px 2px 10px grey; padding: 10px; border-radius: 5px">
                <div id="map" style="height: 400px"></div>                
            </div>
        </div>
        <!-- /.Chart Holder -->  
        <?php
        }
        ?>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}
function printKmlMaps($devName, $iniDate){
    
    $devData = dbGetDevData_Coordinates($devName, $iniDate);
    $coordsString = prepareCoordString($devData);
    $startMarker = prepareStartMarker($devData);
    $endMarker = prepareEndMarker($devData);
?>
  <script type="text/javascript">
    var map;
    $(document).ready(function(){
        map = new GMaps({
          el: '#map',
          lat: <?php echo $startMarker['latitude'];?>,
          lng: <?php echo $startMarker['longitude'];?>,
          zoomControl : true,
          zoomControlOpt: {
              style : 'SMALL',
              position: 'TOP_LEFT'
          },
        });
      
        map.addMarker({
            lat: <?php echo $startMarker['latitude'];?>,
            lng: <?php echo $startMarker['longitude'];?>,
            title: 'Start',
        });
      
        map.addMarker({
            lat: <?php echo $endMarker['latitude'];?>,
            lng: <?php echo $endMarker['longitude'];?>,
            title: 'End',
        });
          
        path = [<?php echo $coordsString;?>];

        map.drawPolyline({
          path: path,
          strokeColor: '#131540',
          strokeOpacity: 0.6,
          strokeWeight: 6
        });
    });
  </script>
<?php
}
function prepareCoordString($devData){
    foreach ($devData as $row){
       $coords = $row['data'];
       $coordsString.="[".$coords['latitude'].",".$coords['longitude']."],";
    }
    //delete last comma
    if(strlen($coordsString)>0){
        $coordsString= substr($coordsString, 0, strlen($coordsString)-1);
    }
    return $coordsString;
}
function prepareStartMarker($devData){
    $lastRow = $devData[count($devData)-1];
    $lastCoords = $lastRow['data'];
    return $lastCoords;
}
function prepareEndMarker($devData){
    $firstRow = $devData[0];
    $firstCoords = $firstRow['data'];
    return $firstCoords;
}
