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

function add_metabox_top($header, $meta_with){

	switch($meta_with){
		case "tiny":
			$set_meta_width = '3';
		break;
		case "small":
			$set_meta_width = '4';
		break;
		case "medium":
			$set_meta_width = '6';
		break;
		case "medium+":
			$set_meta_width = '8';
		break;
		case "medium++":
			$set_meta_width = '9';
		break;
		case "large":
			$set_meta_width = '12';
		break;
	}

	echo '<!-- row -->
		
			<div class="col-md-'.$set_meta_width.'">
				<!-- jQuery Knob -->
				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">'.$header.'</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row">';
}

function add_metabox_bottom(){

	echo				'</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- /.col -->';
}


/**********************
*
* Functions to add and retrive posts
*
***********************/

function add_post($post_author, $post_content, $post_title, $post_status, $post_name, $post_url, $post_type){
	global $dbHandler;
}

?>
		