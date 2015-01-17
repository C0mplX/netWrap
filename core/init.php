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

/**********************
*
* Functions to check user_level clerence 
*
***********************/

/**********************
*
* Functions that creates elements on the admin page and front end page. 
*
***********************/

//Creates an copy of tinyMCEditor

function add_editor($editor_id, $editor_name){


	$create_editor  = '
	<textarea rows="20" id="'.$editor_id.'" name="'.$editor_id.'"></textarea>
		<iframe id="'.$editor_id.'" name="form_target" style="display:none"></iframe>
		<form id="'.$editor_name.'" action="/upload/" target="'.$editor_id.'" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
		    <input name="image" type="file" onchange="$("#'.$editor_name.'").submit();this.value="";">
		</form>';

	return $create_editor;
}
?>
		