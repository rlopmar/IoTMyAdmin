-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 14-07-2015 a las 15:26:39
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6
-- 
-- Database config for IoT MyAdmin web app
-- 

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `IoTMyAdmin`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dev1`
-- 

CREATE TABLE IF NOT EXISTS `dev1` (
  `tableLogId` int(11) NOT NULL auto_increment,
  `logDate` char(128) NOT NULL,
  `logTime` char(30) NOT NULL,
  `devData_0` varchar(30) NOT NULL,
  `devData_1` varchar(30) NOT NULL,
  PRIMARY KEY  (`tableLogId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `dev1`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dev2`
-- 

CREATE TABLE IF NOT EXISTS `dev2` (
  `tableLogId` int(11) NOT NULL auto_increment,
  `logDate` char(128) NOT NULL,
  `logTime` char(30) NOT NULL,
  `devData_0` varchar(30) NOT NULL,
  `devData_1` varchar(30) NOT NULL,
  PRIMARY KEY  (`tableLogId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `dev2`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `devices`
-- 

CREATE TABLE IF NOT EXISTS `devices` (
  `devId` int(11) NOT NULL auto_increment,
  `devName` varchar(50) NOT NULL,
  `devPwd` char(128) NOT NULL,
  `devType` char(150) NOT NULL,
  `devRegisteredOn` date NOT NULL,
  `devStatus` char(15) NOT NULL default 'Active',
  `devPrivacy` char(30) NOT NULL,
  `devTableName` varchar(30) NOT NULL,
  `devNumOfFields` int(11) NOT NULL,
  `devNameOfFields` varchar(300) NOT NULL,
  `devLastLog` datetime default NULL,
  PRIMARY KEY  (`devId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `devices`
-- 

INSERT INTO `devices` VALUES (1, 'TempLightWiFiShield', 'password', 'General Data', '2015-07-14', 'Active', 'Public', 'dev1', 2, 'Temperature,Light', NULL);
INSERT INTO `devices` VALUES (2, 'FonaLocation', 'password', 'Coordinates', '2015-07-14', 'Active', 'Public', 'dev2', 2, 'latitude, longitude', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `last_logs`
-- 

CREATE TABLE IF NOT EXISTS `last_logs` (
  `logId` int(11) NOT NULL auto_increment,
  `devId` int(11) NOT NULL,
  `tableLogId` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`logId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `last_logs`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `login_attempts`
-- 

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `login_attempts`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `members`
-- 

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `verified` int(1) default '0',
  `blocked` int(1) default '0',
  `role` varchar(16) default 'master',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `members`
-- 

INSERT INTO `members` VALUES (1, 'testUser', 'testuser@test.com', 'bdca6dd8d60fe5a4d73161405127c742892c92cc1167b70aa73c1671f86285dd12b7a0e04388e3087adc8c01294f7e1b28db0321f82cdac12963a51ab048fcb9', 'af69537e53f4507c1f98845f24106f3d1f1d2f32506cfa76b6789cb06c849ac84bb806599b947affb513f6dd5b668eae086f200b684136eee8547fd19afb9faa', 0, 0, 'master');
