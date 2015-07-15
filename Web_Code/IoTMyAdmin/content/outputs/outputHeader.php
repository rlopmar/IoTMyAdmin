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
 * This object has the functions which print different headers in the web
 */
class outputHeader {
    
    //print basic common lines
    public function __construct(){
        ?>
        <!DOCTYPE html>
        <html lang="en">
            
            <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="Web app for bioengineering Arduino projects">
            <meta name="author" content="Rafael Lopez Martinez">
        <?php
    }
    
    
    /*
    * print the basic header
    */
    public function printSimpleHeader($title){
        ?>
            
            <title><?php echo $title ?></title>
            <!-- Bootstrap Core CSS -->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="../css/sb-admin.css" rel="stylesheet">
            <!-- Morris Charts CSS -->
            <link href="../css/plugins/morris.css" rel="stylesheet">
            <!-- Custom Fonts -->
            <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <?php
    }
    
    
    /*
    * close head html tag
    */
    public function closeHeader(){
        ?>
        </head>        
        <?php
    }
}
