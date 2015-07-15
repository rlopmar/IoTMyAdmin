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

//Check Data
if(isset($_POST) && sizeof($_POST)!=0){
    $errorMessages = array(0,0,0,0);//(0=noErrors/1=errors) selectDeviceError, selectChartType, firstDataError, numOfDataError
    if(!isset($_POST['devName'])){$errorMessages[0]=1;}
    if(!isset($_POST['chartType'])){$errorMessages[1]=1;}
    if($_POST['firstData']<0){$errorMessages[2]=1;}
    if(!isset($_POST['numOfDataAll']) && $_POST['numOfData']<0){$errorMessages[3]=1;}
    else if (isset($_POST['numOfData']) && $_POST['numOfData']>0){ $numOfData = $_POST['numOfData']; }
    else { $numOfData = "all"; }
}

//set data
$devNamesList = dbGetDevNamesListGeneral($_SESSION['username']);


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Charts");
$header->closeHeader();

openBody();
printNavbarAndSidebar("devCharts");
printBody($devNamesList, $errorMessages);
closeBody();

$footer = new outputFooter();
if($errorMessages==array(0,0,0,0)){
    printChartsScript($_POST['devName'], $_POST['chartType'], $_POST['firstData'], $numOfData);
}
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody($devNamesList, $errorMessages){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Charts
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php">Devices</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-area-chart"></i> Charts
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.Page Heading -->               

        
        <!-- Chart Form -->         
        <div class="row">
            <div class="col-lg-12">    
                <form role="form" name="chartForm" method="post" action="<?php echo $_SERVER[REQUEST_URI]; ?>">
                    <div class="col-lg-2">
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
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="chartType">Chart type: </label>
                            <select name="chartType" id="chartType" class="form-control">
                                <option disabled selected>Select</option>
                                <option id="Line" value="Line">Line</option>
                                <option id="Area" value="Area">Area</option>
                                <option id="Column" value="Column">Column</option>
                            </select>
                            <?php
                            if ($errorMessages[1]==1){
                                echo '<p style="color: red">Select a chart type</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="firstData">First data: </label>
                            <input type="number" name="firstData" id="firstData" class="form-control" value="0">
                            <?php
                            if ($errorMessages[3]==1){
                                echo '<p style="color: red">Can\'t be negative</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="numOfData"># of samples: </label>
                            <input type="number" name="numOfData" id="numOfData" class="form-control" value="0">
                            <input type="checkbox" name="numOfDataAll" id="numOfDataAll" value="all"> Select all
                            <?php
                            if ($errorMessages[3]==1){
                                echo '<p style="color: red">Can\'t be negative</p>';
                            }
                            ?>
                            <script>
                            document.getElementById('numOfDataAll').onchange = function() {
                                document.getElementById('numOfData').disabled = this.checked;
                            };
                            </script>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group" style="margin-top: 25px">
                            <input type="submit" class="btn btn-block btn-primary" value="Draw Chart">
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
                <div class="col-lg-10" style="box-shadow: 2px 2px 10px grey; border-radius: 5px">
                    <div id="chartHolder"></div>                
                </div>              
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
function printChartsScript($devName, $chartType, $firstData, $numOfData){    
$dataNames= dbGetNameOfFields($devName);

$dataStr = chartsPrepMultData_offset($devName, $firstData, $numOfData);
?>
<script type="text/javascript">
    
  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawVisualization);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawVisualization() {
    var data = new google.visualization.DataTable();
    
    data.addColumn('datetime', 'Time of Day');
    <?php
    foreach ($dataNames as $name){
    ?>
        data.addColumn('number', '<?php echo $name; ?>' );
    <?php
    }
    ?>
    data.addRows([<?php echo $dataStr; ?>]);

    var options = {
      title: 'Device: <?php echo $devName ?>',
      curveType: 'function',
      height: 400,
      vAxis:{minValue:0}
    };

    new google.visualization.<?php echo $chartType; ?>Chart(document.getElementById('chartHolder')).
      draw(data, options);
    }
</script>
<?php
}
