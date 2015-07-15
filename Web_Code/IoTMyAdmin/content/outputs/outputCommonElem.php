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

/***********************************************************************
 * IMPORTANT NOTE
 *  - paths are relative to the folder where you are printing the html
 * lines. In this case, relative to "root/content/"
 ***********************************************************************/

    
/*
 * print opening tags for the wrapper div and body tag
 */
function openBody(){
?>
<body>
    <div id="wrapper">
<?php
}
    
/*
 * print closing tags for the wrapper div and body tag
 */
function closeBody(){
?>
    </div>
    <!-- /#wrapper -->
</body>
<?php
}

    
/*
 * print basic common lines (logo, navbar and sidebar)
 */
function printNavbarAndSidebar($sideBarSelection){
?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="mainPage.php">IoT MyAdmin</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo ' '.$_SESSION["username"] ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <!--
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li class="divider"></li>
                    -->
                    <li>
                        <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li <?php if($sideBarSelection=="home") echo "class='active'";?>>
                    <a href="mainPage.php"><i class="fa fa-fw fa-home"></i> Home</a>
                </li>
                <li <?php if($sideBarSelection=="devList" || $sideBarSelection=="devLastLogs"|| $sideBarSelection=="devCharts"|| $sideBarSelection=="devDataTables"|| $sideBarSelection=="devMaps") echo "class='active'";?>><a href="devices.php"> Devices </a></li>
                    <li style='margin-left: 30px' <?php if($sideBarSelection=="devList") echo "class='active'";?>>
                        <a href="devices.php"><i class="fa fa-fw fa-list-ol"></i> List</a>
                    </li>
                    <li style='padding-left: 30px' <?php if($sideBarSelection=="devLastLogs") echo "class='active'";?>>
                        <a href="lastLogs.php"><i class="fa fa-fw fa-bolt"></i> Last Logs</a>
                    </li>
                    <li style='padding-left: 30px' <?php if($sideBarSelection=="devDataTables") echo "class='active'";?>>
                        <a href="dataTables.php"><i class="fa fa-fw fa-table"></i> Data Tables</a>
                    </li>
                    <li style='padding-left: 30px' <?php if($sideBarSelection=="devCharts") echo "class='active'";?>>
                        <a href="charts.php"><i class="fa fa-fw fa-area-chart"></i> Charts</a>
                    </li>
                    <li style='padding-left: 30px' <?php if($sideBarSelection=="devMaps") echo "class='active'";?>>
                        <a href="maps.php"><i class="fa fa-fw fa-map-marker"></i> Maps</a>
                    </li>
                    <!--
                    <li style='padding-left: 30px' <?php if($sideBarSelection=="devMaps") echo "class='active'";?>>
                        <a href="blank.php"><i class="fa fa-fw fa-map-marker"></i> Maps</a>
                    </li>
                    -->
                <li <?php if($sideBarSelection=="tutorial") echo "class='active'";?>>
                    <a href="tutorial.php"><i class="fa fa-fw fa-edit"></i> Tutorial</a>
                </li>
                <li <?php if($sideBarSelection=="arduino") echo "class='active'";?>>
                    <a href="arduinoProjects.php"><img src="../img/Arduino.png" style="height: 12px; padding-right: 5px;"> Arduino projects</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
    <?php
}
