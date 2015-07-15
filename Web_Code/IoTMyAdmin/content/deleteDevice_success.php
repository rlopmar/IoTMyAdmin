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
$header->printSimpleHeader("IoT MyAdmin - Delete");
$header->closeHeader();

openBody();
printNavbarAndSidebar("deleteDevice_succcess");
printBody($_GET['devName']);
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody($devName){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row" >
            <div class="col-lg-12">
                <h1 class="page-header">
                    Device Deleted
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="devices.php"> Devices</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-remove"></i> Device Deleted
                    </li>
                </ol>                        
            </div>
        </div>
        <!-- Alert message -->
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center alert alert-danger" role="alert" style="margin-bottom: 10px">
                    <h2><i class="glyphicon glyphicon-remove"></i> Device "<?php echo $devName; ?>" deleted!!!</h2>
                </div>                
            </div>
        </div>
        <!-- /. Alert message -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}