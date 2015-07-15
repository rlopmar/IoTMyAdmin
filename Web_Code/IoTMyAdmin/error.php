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


$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
if (! $error) {
    $error = 'An unknown error happened.';
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
        <div id="wrapper">

        <!-- Navigation -->      

        <div id="page-wrapper-inverse">

            <div class="container-fluid">

                <!--login modal-->
                <div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true" style="overflow:auto">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: 0px">
                            <h1 class="text-center" style="font-size: 30pt; font-family: Levenim MT; font-weight: bold;">ChurLum</h1>
                        </div>
                      </div>
                  </div>
                  <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h1 class="text-center">Oops!!!</h1>
                      </div>
                      <div id="loginFormWrapper" class="modal-body">
                          <div style="text-align:center; color:red;"><p><?php echo $error ?></p></div>                          
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