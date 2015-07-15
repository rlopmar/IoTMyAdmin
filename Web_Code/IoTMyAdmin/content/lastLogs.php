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

//set varibles
$table = dbGetLastLogs($limit, $page, $links, $_SESSION['username']);



/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Last Logs");
$header->closeHeader();

openBody();
printNavbarAndSidebar("devLastLogs");
printBody($table);
closeBody();

$footer = new outputFooter();
$footer->closeHtml();


function printBody($table){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Last Logs
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php"> Devices</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-bolt"></i> Last Logs
                    </li>
                </ol>                           
            </div>
        </div>
        <!-- /.Page Heading -->
        
        <!-- Data table -->
        <div class="row">
            <div class="col-lg-12">
                <?php
                //pagination
                echo $table['links']; 
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Log ID</th>
                                <th class="text-center">Device Name</th>
                                <th class="text-center">Log Date</th>
                                <th class="text-center">Log Time</th>
                                <th class="text-center">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($table != ""){
                            $index=0;
                            foreach ($table as $row) {
                                if ($row[0]!='<'){
                                    $index=$index+1;
                                    echo "<tr>";
                                    echo "<td class='col-xs-1 text-center'>".$row['logId']."</td>";
                                    echo "<td class='col-xs-2 text-center'>".$row['devName']."</td>";
                                    echo "<td class='col-xs-1 text-center'>".$row['logDate']."</td>";
                                    echo "<td class='col-xs-1 text-center'>".$row['logTime']."</td>";                                           
                                    echo "<td class='col-xs-1 text-center'>";
                        ?>
                                    <!-- Show data button: trigger modal -->
                                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $index; ?>">
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
                                                    <div>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped table-condensed">
                                                                <tr>
                                                                <?php
                                                                $data = $row['data'];
                                                                $nameOfFields = dbGetNameOfFields($row['devName']);
                                                                for($i=0;$i<sizeof($data);$i++){
                                                                    if($nameOfFields[$i]==""){
                                                                        $nameOfFields[$i]="dataField".$i;
                                                                    }
                                                                    echo "<th class='text-center'><small>".$nameOfFields[$i]."</small></th>";
                                                                }
                                                                ?>
                                                                </tr>
                                                                <tr>
                                                                <?php
                                                                for($i=0;$i<sizeof($data);$i++){
                                                                    echo "<td class='text-center'><small>".$data[$i]."</small></td>";
                                                                }
                                                                ?>
                                                                </tr>
                                                            </table>
                                                        </div>
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
                        }
                        ?>                                  
                        </tbody>
                    </table>
                </div>
                <?php 
                //pagination
                echo $table['links']; 
                ?>
            </div>
        </div>
        <!-- /Data table -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}