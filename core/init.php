<?php
session_start();
header('Content-Type: text/html; charset=ISO-8859-1');
require 'connect/database.php';
require 'classes/general.php';
require 'classes/DbHandler.php';

$dbHandler		= new DbHandler($db);
$general  		= new General();
$errors			= array();


/***********************
*
* This document has all the functions for NetWrap. 
*
***********************/



/**
* Functions for retriving data from the nw_users table
*/

//get_user() - Gets the username of the logged in user in admin panel. 
function get_user($user_ID){
	global $dbHandler;

    $get_display_name = $dbHandler->get_userdata_admin($user_ID);
    
    $display_name = $get_display_name['display_name'];

    return $display_name;
}

/**
* Functions for retriving data from the nw_usermeta table
*/

//get_usermeta($user_id, $meta_key) - Takes the user_ID and meta-key value to display
function get_usermeta($user_ID, $meta_key){
	global $dbHandler;

	$get_usermeta = $dbHandler->get_usermeta_admin($user_ID, $meta_key);

	$display_usermeta = $get_usermeta['meta_value'];

	switch($display_usermeta){
		case "1":
			$display_usermeta = 'Poster';
		break;
		case "2":
			$display_usermeta = 'Editor';
		break;
		case "3":
			$display_usermeta = 'Administrator';
		break;
	}
	return $display_usermeta;
}



?>