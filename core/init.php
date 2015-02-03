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

function add_editor($editor_id, $editor_name, $value){
	$create_editor  = '
	<textarea rows="20" id="'.$editor_id.'" name="'.$editor_id.'">'.htmlentities($value).'	</textarea>
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
	$post_content	= stripcslashes($_POST['nw_post_editor']);
	$post_author	= get_user($user_ID);
	$post_status 	= 'published';
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

if(isset($_POST['update_post'])){
	global $dbHandler;
	global $user_ID;
	//Gather all the variables and sanatize them. 
	$post_title 	= trim($_POST['nw_title_post_edit']);
	$post_content	= stripcslashes($_POST['nw_post_editor_edit']);
	$post_author	= get_user($user_ID);
	$post_name		= str_replace(' ', '-', $post_title);
	$post_ID 		= $_GET['post'];


	if($post_title != "" && $post_content != ""){

		$add_post = $dbHandler->update_post($post_author, $post_content, $post_title, $post_name, $post_ID);

			/*
			if($_POST['nw_brand_new_post_cat'] != "") {
				$category_name = trim($_POST['nw_brand_new_post_cat']);
			}else{
				$category_name 	= trim($_POST['nw_category_get_post_page']);
			}
			add_new_post_category($add_post, $category_name);
			*/
			header('Location: edit-post.php?post='.$post_ID  );
	}
	else{

	}
}

/**
* Get post content
*/

//Get the title
function get_the_title($post_ID){
	global $dbHandler;

	$get_post_data = $dbHandler->get_post_by_id($post_ID);

	echo $get_post_data['post_title'];
}

//Get post content
function get_the_content($post_ID){
	global $dbHandler;
	$get_post_data = $dbHandler->get_post_by_id($post_ID);

	return $get_post_data['post_content'];
}

function get_post_status($post_ID){
	global $dbHandler;
	$get_post_data = $dbHandler->get_post_by_id($post_ID);

	echo $get_post_data['post_status'];
}

/**
* Get the all the posts
*/
function get_all_posts(){
	global $dbHandler;
	$get_all_posts = $dbHandler->get_all_posts();
	echo'
	<div class="box-body table-responsive">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
	            <tr>
	                <th>Title</th>
	                <th>Author</th>
	                <th>date</th>
	                <th>Edit</th>
	            </tr>
            </thead>
        <tbody>';
	foreach ($get_all_posts as $posts) {
		if($posts['post_modified'] == "0000-00-00"){
			$post_date = $posts['post_date'];
		}else{
			$post_date = $posts['post_modified'];
		}
		echo '<tr>
			<td>'.$posts['post_title'].'</td>
			<td>'.$posts['post_author'].'</td>
			<td>'.$post_date.' '.$posts['post_status'].'</td>
			<td><a href="edit-post.php?post='.$posts['ID'].'"<button class="btn btn-primary">Edit</button></td>
		</tr>
		';
	}

	echo '</tbody>
			<tfoot>
				<tr>
				<th>Title</th>
				<th>Author</th>
				<th>date</th>
				<th>Edit</th>
				</tr>
			</tfoot>
		</table>
	</div>
		';
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
		