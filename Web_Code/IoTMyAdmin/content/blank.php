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
$header->printSimpleHeader("IoT MyAdmin - Blank");
$header->closeHeader();

openBody();
printNavbarAndSidebar("blank");
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Page under construction
                    <small>Subheading</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="blank.php">Blank</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i> Under construction
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.Page Headimg -->               

        <div class="row">
            <div class="col-lg-12">
                <div class="text-center alert alert-warning" role="alert" style="margin-bottom: 10px">
                    <h1><i class="glyphicon glyphicon-warning-sign"></i> Page under construction <br><small></small></h1>
                </div>                
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php
}