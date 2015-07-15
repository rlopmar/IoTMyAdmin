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
include_once 'includes/includes.php';

//session management
sec_session_start();
if (login_check() == true) {
    header("Location: logout.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en" style="background: url(img/login-circuit-wallpaper.jpg) no-repeat center center fixed; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Web app for bioengineering Arduino projects">
        <meta name="author" content="Rafael Lopez Martinez">

        <title>IoT MyAdmin</title>
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
        <?php
        if (isset($_GET['error'])) {
            $loginMessage = 'Error Logging In! Check your email and password';
        }
        ?> 
        
        <div id="wrapper">

        <!-- Navigation -->      

        <div id="page-wrapper-inverse">

            <div class="container-fluid">

                <!--login modal-->
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
                          <h1 class="text-center"><small style="font-size: 20pt">Welcome</small></h1>
                      </div>
                      <div id="loginFormWrapper" class="modal-body">
                          <div style="text-align:center; color:red;"><p><?php echo $loginMessage ?></p></div>
                          <form id="login_form" method="post" action="includes/process_login.php" class="form col-md-12 center-block" >
                            <div class="form-group">
                              <input type="text" class="form-control input-lg" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                              <input type="password" id="password" class="form-control input-lg" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input id="btnLogin" type="submit" name="btnLogin" class="btn btn-primary btn-lg btn-block" value="Log In" onclick="formhash(this.form, this.form.password);">
                            </div>
                          </form>
                          <div style="text-align:center"><a href="register.php">Register</a></div>
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
