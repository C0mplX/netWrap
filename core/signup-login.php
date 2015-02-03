<?php
//get global variable
$function_to_run = $_POST['function_to_run'];
/*************
*Initiate a switch to select the right function
*************/
switch($function_to_run){
	case "setup_admin_user_first":
	setup_admin_user_first();
	break;
	case "login":
	loginUser();
	break;
}


/************
*function for registrer user
************/
function setup_admin_user_first(){
	require '../core/init.php';
	$return = array();

	$display_name   = $_POST['display_name'];
	$user_login   	= $_POST['user_login'];
	$user_email   	= $_POST['user_email'];
	$user_pass 		= $_POST['user_pass'];

	if(empty($display_name) || empty($user_login) || empty($user_email) || empty($user_pass)){

		$errors[] = 'Fill out all the fields';
	}else{
		if(filter_var($user_email, FILTER_VALIDATE_EMAIL) === false){
			$errors[] = 'Email is not a valid email adress';
		}
	}

	if(empty($errors) === true){
		//create all NetWrap Tables
		$dbHandler->instal_nw_users_table();
		$dbHandler->instal_nw_usermeta_table();
		$dbHandler->instal_nw_posts_table();
		$dbHandler->instal_nw_postmeta_table();
		$dbHandler->instal_nw_options();
		$dbHandler->instal_nw_taxonomy();

		//registrer det first admin user
		$dbHandler->register($display_name, $user_login, $user_email, $user_pass);
		//Get the userid, for inserting nw_usermeta
		$user_id = $dbHandler->get_userdata_first();
		//Insert nw_usermeta
		$dbHandler->insert_usermeta($user_id, 'nw_user_level', '3');
		
		$return[1] = true; $return[2] = "You are now registered";
		echo json_encode($return);
		
		exit();
		
		
	}else{

		
		$return = array(); $return[1] = false;
		
		$return[2] = $errors;
		
		echo json_encode($return);
		
		exit();
	}


}

/************
*function for login in the user
************/
function loginUser(){
	require '../core/init.php';
	$return = array();

	$username = trim($_POST['input_user_login']);
	$password = trim($_POST['input_user_password']);

	if(empty($username) === true || empty($password) === true){
			$errors[] = 'Fill out username and password';
	}else{
		$login = $dbHandler->login($username, $password);
		if($login === false){ 
		
			$return = false;
			
			echo json_encode($return);
		}else{
		
			$id = $_SESSION['id'] = $login;
			
			$success = true;
			
			echo json_encode($success);
			exit();
		}
	}
}
?>