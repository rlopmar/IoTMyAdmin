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
include_once 'includes/register.inc.php';
include_once 'includes/includes.php';
?>
<!DOCTYPE html>
<html lang="en" style="background: url(img/login-circuit-wallpaper.jpg) no-repeat center center fixed; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Web app for bioengineering Arduino projects">
        <meta name="author" content="Rafael Lopez Martinez">
        <title>IoT MyAdmin: Registration</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <?php
        if (!empty($error_msg)) {
            $registrationMessage = $error_msg;
        }
        ?>        
        <div id="wrapper">

        <!-- Navigation -->      

        <div id="page-wrapper-inverse">
            <div class="container-fluid">
                <div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true" style="overflow:auto">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: 0px">
                            <h1 class="text-center" style="font-size: 30pt; font-family: Levenim MT; font-weight: bold;">IoT MyAdmin</h1>
                        </div>
                      </div>
                  </div>
                  <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h1 class="text-center"><small style="font-size: 20pt">Registration</small></h1>
                      </div>
                      <div id="loginFormWrapper" class="modal-body">
                          <div style="text-align:center; color:red;"><p><?php echo $registrationMessage ?></p></div>
                          <form name="registration_form" method="post" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" class="form col-md-12 center-block" >
                            <div class="form-group">
                              <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username">
                            </div>
                            <div class="form-group">
                              <input type="text" name="email" id="email" class="form-control input-lg" placeholder="Email">
                            </div>
                            <div class="form-group">
                              <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password (upper case + lower case + number)">
                            </div>
                            <div class="form-group">
                              <input type="password" name="confirmpwd" id="confirmpwd" class="form-control input-lg" placeholder="Confirm password">
                            </div>
                            <div class="form-group">
                                <input id="btnRegister" type="submit" name="btnRegister" class="btn btn-primary btn-lg btn-block" value="Register" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);">
                            </div>
                          </form>
                          <div style="text-align:center"><a href="index.php">Login page</a></div>
                      </div>
                      <div class="modal-footer"  style="border-top: 0px">
                      </div>
                  </div>
                  </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
