<?php
session_start();
header('Content-Type: text/html; charset=ISO-8859-1');
require 'connect/database.php';
require 'classes/general.php';
require 'classes/DbHandler.php';

$dbHandler		= new DbHandler($db);
$general  		= new General();
$errors			= array();
$user_ID 		= $_SESSION['id']; 


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
		    <input name="image" type="file" style="display: none;" onchange="$("#'.$editor_name.'").submit();this.value="";">
		';

	return $create_editor;
}

function add_form_start($editor_id, $editor_name){
	echo '<form id="'.$editor_name.'" action="" target="'.$editor_id.'" method="post" enctype="multipart/form-data">';
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

//PUBLISH: Take the data from all the form fields and pass it to add_post.  

if(isset($_POST['save_post'])){

	global $dbHandler;
	global $user_ID;
	//Gather all the variables and sanatize them. 
	$post_title 	= trim($_POST['nw_title_post']);
	$post_content	= trim($_POST['nw_post_editor']);
	$post_author	= get_user($user_ID);
	$post_status 	= 'publish';
	$post_type		= 'post';
	$post_name		= str_replace(' ', '-', $post_title);
	$post_url		= $post_name . $dbHandler->check_post_number($post_title);


	if($post_title != "" && $post_content != ""){

		$add_post = $dbHandler->insert_post($post_author, $post_content, $post_title, $post_status, $post_name, $post_url, $post_type);

			if($_POST['nw_brand_new_post_cat'] != "") {
				$category_name = trim($_POST['nw_brand_new_post_cat']);
			}else{
				$category_name 	= trim($_POST['nw_category_get_post_page']);
			}
			add_new_post_category($add_post, $category_name);

			header('Location: edit-post.php?post='.$add_post  );
	}
	else{

	}
}

/**
* Get post by id
*/
function get_post_info($post_ID){

}

/**********************
*
* Functions to add and retrive categories
*
***********************/
function get_post_category(){
	global $dbHandler;

	$get_cat = $dbHandler->get_all_cat();

	if($get_cat != ""){
		echo '<select id="nw_category_get_post_page" name="nw_category_get_post_page" class="form-control">';
		echo '<option name="blank_cat" value="Uncategorized" >Uncategorized</option>';
		foreach ($get_cat as $category) {
		echo '<option name="'.$category['taxonomy'].'" value="'.$category['taxonomy_value'].'">'.$category['taxonomy_value'].'</option>';	
		}
		echo '</select></br>';
		echo '<input type="text" id="nw_brand_new_post_cat" class="form-control" name="nw_brand_new_post_cat" placeholder="Add new category" />';
	}
}

function add_new_post_category($postID, $category_name){
	global $dbHandler;

	$insert_new_cat = $dbHandler->insert_post_category($postID, $category_name);

	if($insert_new_cat === true){
		return true;
	}else{
		return false;
	}
}


?>
		