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

//pagination parameters
$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 25;
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$links = (isset($_GET['links'])) ? $_GET['links'] : 1;

//get data needed
$devNamesList = dbGetDevNamesList($_SESSION['username']);
$table = "selectDevice";
if(isset($_GET['devName']) && $_GET['devName']!=""){
    //get data
    $table = dbGetDataTable($_GET['devName'], $limit, $page, $links);
}


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Data Tables");
$header->closeHeader();

openBody();
printNavbarAndSidebar("devDataTables");
printBody($devNamesList,$table,$_GET['devName']);
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody($devNamesList,$table,$devName){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Data Table
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php"> Devices</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> Data Table
                    </li>
                </ol>                           
            </div>
        </div>
        <!-- /.Page Heading -->
        
        <!-- Selection -->
        <div class="row">
            <div class="col-lg-2" style="margin-bottom: 10px">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                         Select Device
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <?php
                        if($devNamesList!=""){
                            foreach ($devNamesList as $value){
                                echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='dataTables.php?devName=".$value."'>".$value."</a></li>";
                            }
                        }
                        else{
                            echo "<li role='presentation'><a role='menuitem' tabindex='-1'>There is not devices registed</a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            if(isset($_GET['devName'])){
            ?>
            <div class="col-lg-2">
                <a class="btn btn-primary dropdown-toggle" type="button" id="btnRandomData" href="actions/addRandomData.php?devName=<?php echo $_GET['devName'] ?>&url=<?php echo $_SERVER[REQUEST_URI]; ?>">
                     Add random data
                </a>
            </div>
            <?php
            }
            ?>
        </div>
        <!-- /.Selection -->
        
        <?php
        if($table == ""){
        ?>
        <!-- No data info Message -->
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center alert alert-info" role="alert" style="margin-bottom: 10px">
                    <h2> Oops!! This device has no data. <br></h2>
                </div>                
            </div>
        </div>
        <!-- /.Message --> 
        <?php
        }
        if($table!="selectDevice" && $table != ""){
        ?>
        <div class="row">
                <div class="col-lg-12"> 
                <?php 
                //Pagination
                echo $table['links'];
                ?>
                <!-- Data table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Log ID</th>
                                <th class="text-center">Log Date</th>
                                <th class="text-center">Log Time</th>
                                <th class="text-center">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($table != ""){
                                $index=0;
                                //for each data row
                                foreach ($table as $row) {
                                    if ($row[0]!='<'){
                                        $index=$index+1;
                                        echo "<tr>";
                                        echo "<td class='col-xs-1 text-center'>".$row['logId']."</td>";
                                        echo "<td class='col-xs-1 text-center'>".$row['logDate']."</td>";
                                        echo "<td class='col-xs-1 text-center'>".$row['logTime']."</td>";                                           
                                        echo "<td class='col-xs-1 text-center'>";
                            ?>

                                        <!-- Show data button: trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $index; ?>">
                                            Show data
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal<?php echo $index; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Data</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped table-condensed">
                                                                <tr>
                                                                <?php
                                                                    $data = $row['data'];
                                                                    $nameOfFields = dbGetNameOfFields($devName);
                                                                    for($i=0;$i<sizeof($data);$i++){
                                                                        if($nameOfFields[$i]==""){
                                                                            $nameOfFields[$i]="dataField".$i;
                                                                        }
                                                                        echo "<th class='col-xs-1 text-center'><small>".$nameOfFields[$i]."</small></th>";
                                                                    }
                                                                ?>
                                                                </tr>
                                                                <tr>
                                                                <?php
                                                                    for($i=0;$i<sizeof($data);$i++){
                                                                        echo "<td class='col-xs-1 text-center'><small>".$data[$i]."</small></td>";
                                                                    }
                                                                ?>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.Modal -->
                                        
                                        <?php
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                //.END for each data row
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.Data table -->
                <?php 
                // pagination
                echo $table['links']; 
                ?>
            </div>
        </div>
        <?php
        }
        //end if
        ?> 
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}