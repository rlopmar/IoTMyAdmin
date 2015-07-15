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

//Set variables
$username = $_SESSION['username'];
$email = dbGetUserEmail($username);
$role = dbGetUserRole($username);


/*************
 * PRINT HTML
 *************/
$header = new outputHeader();
$header->printSimpleHeader("IoT MyAdmin - Profile");
$header->closeHeader();

openBody();
printNavbarAndSidebar("blank");
printBody($username, $email, $role);
closeBody();

$footer = new outputFooter();
$footer->closeHtml();



/**************************************************************************
 * custom html code
 *******************/
function printBody($username, $email, $role){
?>
<div id="page-wrapper">
    <div class="container-fluid">

        

        <!-- Page Heading -->
        <div class="row" >
            <div class="col-lg-12">
                <h1 class="page-header">
                    User Profile
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-user"></i> User Profile
                    </li>
                </ol>                        
            </div>
        </div>
        <!-- /.Page Heading -->
        
        <!-- Panel 1 -->
        <div class="panel-body">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="form-group">
                    <div class="input-group input-group control-label">
                        <span class="input-group-addon" style="min-width:130px;" id="sizing-username">Username: </span>
                        <p class="form-control" aria-describedby="sizing-username" ><?php echo $username; ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group">
                        <span class="input-group-addon" style="min-width:130px;" id="sizing-email">Email: </span>
                        <p class="form-control" aria-describedby="sizing-email"><?php echo $email; ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group">
                        <span class="input-group-addon" style="min-width:130px;" id="sizing-role">Role: </span>
                        <p class="form-control" aria-describedby="sizing-role" ><?php echo $role; ?></p>
                    </div>
                </div>
                <!-- Change info button: modal trigger -->
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6" style="margin-bottom: 30px;">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#changeInfoModal">Change Info</button>                                  
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <div class="input-group">                               
                                <span class="input-group-addon" style="min-width:130px;" id="sizing-addon3">Password: </span>
                                <p class="form-control" aria-describedby="sizing-addon3" disabled>*************</p>
                            </div>
                        </div>
                    </div>
                    <!-- Change password button: modal trigger -->
                    <div class="col-lg-3">
                        <div class="form-group">
                            <div class="input-group">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePwdModal">Change password</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Change info modal -->
                <div class="modal fade" id="changeInfoModal" tabindex="-1" role="dialog" aria-labelledby="changeInfoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form role="form" name="changeDevBasicInfo_form" method="post" action="actions/changeUserProfile.php?opt=info">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Change User Profile</h4>
                                </div>
                                <div class="modal-body">                                          
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="loginFormWrapper" class="modal-body">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <input type="text" name="newUsername" id="newUsername" class="form-control input" placeholder="New username" value="<?php echo $username; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <input type="hidden" name="email" id="email" value="<?php echo $devInfo['devName']; ?>">
                                                        <input type="text" name="newEmail" id="newEmail" class="form-control input" placeholder="New email" value="<?php echo $email; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <input type="text" name="role" id="role" class="form-control input" placeholder="Role" value="<?php echo $role; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                  
                                <div class="modal-footer">
                                    <div class="row">       
                                        <div class="col-lg-6">                                         
                                            <div class="form-group">
                                                <input type="password" name="actualPwd" id="actualPwd" class="form-control input" placeholder="Introduce actual password">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>     
                        </div>
                    </div>
                </div>
                <!-- /.Change info modal -->
                <!-- Change password modal -->
                <div class="modal fade" id="changePwdModal" tabindex="-1" role="dialog" aria-labelledby="changePwdModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form role="form" name="changePwd_form" method="post" action="actions/changeUserProfile.php?opt=pwd">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Change User Password</h4>
                                </div>
                                <div class="modal-body">                                          
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="loginFormWrapper" class="modal-body">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <input type="password" name="newPwd" id="newPwd" class="form-control input" placeholder="New password">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <input type="password" name="confirmNewPwd" id="confirmNewPwd" class="form-control input" placeholder="Confirm new password">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="password" name="actualPwd" id="actualPwd" class="form-control input" placeholder="Introduce actual password">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save new password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>   
                        </div>
                    </div>
                </div>
                <!-- /.Change password modal -->
            </div>
        </div>
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
}