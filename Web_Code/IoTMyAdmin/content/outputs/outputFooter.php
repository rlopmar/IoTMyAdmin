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

/**
 * This object has the functions which print different footers in the web
 */
class outputFooter {
    //print basic common lines
    public function __construct(){
        ?>
            <!-- jQuery -->
            <script src="../js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="../js/bootstrap.min.js"></script>

            <!-- Morris Charts JavaScript -->
            <script src="../js/plugins/morris/raphael.min.js"></script>
            <script src="../js/plugins/morris/morris.min.js"></script>
            <script src="../js/plugins/morris/morris-data.js"></script>

            <!-- Flot Charts JavaScript -->
            <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
            <script src="../js/plugins/flot/jquery.flot.js"></script>
            <script src="../js/plugins/flot/jquery.flot.tooltip.min.js"></script>
            <script src="../js/plugins/flot/jquery.flot.resize.js"></script>
            <script src="../js/plugins/flot/jquery.flot.pie.js"></script>
            <script src="../js/plugins/flot/flot-data.js"></script>
            
            <!--Google charts AJAX API-->
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            
            <!--GMaps.js-->
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
            <script src="../js/gmaps.js "></script>
        <?php
    }
    /*
    * print the basic footer
    */
    public function closeHtml(){
    ?>
        </html>
    <?php
    }
}
