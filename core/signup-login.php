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

	$nickname   = $_POST['nickname'];
	$email   	= $_POST['email'];
	$password   = $_POST['password'];

	if(empty($nickname) || empty($email) || empty($password)){

		$errors[] = 'Alle felter må fylles ut';
	}else{
		if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			$errors[] = 'Epostadressen er ikke gyldig';
		}else if($dbHandler->email_exists($email) === true){
			$errors[] = 'Epostadressen er allerede registrert';
		}else if($dbHandler->name_exists($nickname) === true){
			$errors[] = 'Kallenavnet er allerede registrert, vennligst bruk et annet';
		}
	}

	if(empty($errors) === true){
		
		
		$dbHandler->register($nickname, $email, $password);
		
		$return[1] = true; $return[2] = "Du er nå registrert";
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
			$errors[] = 'Vennligst fyll inn brukernavn og passord';
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