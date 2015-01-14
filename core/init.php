<?php
session_start();
header('Content-Type: text/html; charset=ISO-8859-1');
require 'connect/database.php';
require 'classes/DbHandler.php';
require 'classes/general.php';

$dbHandler		= new DbHandler($db);
$general  		= new General();
$errors			= array();
?>