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

//set variables
$table = dbGetDevList($limit, $page, $links, $_SESSION['username']);


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Devices");
$header->closeHeader();

openBody();
printNavbarAndSidebar("devList");
printBody($table);
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody($table){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Devices
                </h1>
                <ol class="breadcrumb">
                    <li>
                        Devices
                    </li>
                    <li class="active">
                        <i class="fa fa-list-ol"></i> List
                    </li>
                </ol>                        
            </div>
        </div>
        <!-- /.Page Heading -->
        
        <!-- Add device button -->
        <div class="row">
            <div class="col-lg-4" style="margin-bottom: 10px">
                <a href='newDevice.php' class='btn btn-primary'><i class='fa fa-fw fa-plus'></i> Add Device</a>
            </div>
        </div>
        
        <!-- Devices table -->
        <div class="row">
            <div class="col-lg-12">
                <?php
                //pagination
                echo $table['links']; 
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Device Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center"># of Fields</th>
                                <th class="text-center">Last Log</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Privacy</th>
                                <th class="text-center">Details</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($table != ""){
                            foreach ($table as $row) {
                                if ($row[0]!='<'){
                                    echo "<tr>";
                                    echo "<td class='col-md-2 text-center'>".$row['devName']."</td>";
                                    echo "<td class='col-md-2 text-center'>".$row['devType']."</td>";
                                    echo "<td class='col-md-1 text-center'>".$row['devNumOfFields']."</td>";
                                    echo "<td class='col-md-2 text-center'>".$row['devLastLog']."</td>";
                                    echo "<td class='col-md-1 text-center'>".$row['devStatus']."</td>";
                                    echo "<td class='col-md-1 text-center'>".$row['devPrivacy']."</td>";
                                    echo "<td class='col-md-1 text-center'><a href='devDetails.php?devName=".$row['devName']."' class='btn btn-sm btn-info'><i class='fa fa-fw fa-search'></i> Details</a></td>";
                                    echo "<td class='col-md-1 text-center'><a href='actions/deleteDevice.php?devName=".$row['devName']."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this device?\");'><i class='fa fa-times'></i> Delete</a></td>";
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
        <!-- /.Devices table -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}