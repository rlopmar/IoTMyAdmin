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


/*************
 * PRINT HTML
 *************/    
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - New Device");
$header->closeHeader();

openBody();
printNavbarAndSidebar("newDevice_success");
printBody();
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody(){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row" >
            <div class="col-lg-12">
                <h1 class="page-header">
                    Device Inserted
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php"> Devices</a>
                    </li>
                    <li>
                        <a href="newDevice.php"><i class="fa fa-plus"></i> Add Device</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-check"></i> Device Inserted
                    </li>
                </ol>                        
            </div>
        </div>
        <!-- /.Page Heading -->
        
        <!-- Success message -->
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center alert alert-success" role="alert" style="margin-bottom: 10px">
                    <h2><i class="glyphicon glyphicon-ok"></i> Success!! Your new device was inserted.</h2>
                </div>                
            </div>
        </div>
        <!-- Success message -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}