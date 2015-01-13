<?php
//get global variable
$function_to_run = $_POST['function_to_run'];
/*************
*Initiate a switch to select the right function
*************/
switch($function_to_run){
	case "registration":
	registrerUser();
	break;
	case "login":
	loginUser();
	break;
}


/************
*function for registrer user
************/
function registrerUser(){
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
		}else if($users->email_exists($email) === true){
			$errors[] = 'Epostadressen er allerede registrert';
		}else if($users->name_exists($nickname) === true){
			$errors[] = 'Kallenavnet er allerede registrert, vennligst bruk et annet';
		}
	}

	if(empty($errors) === true){
		
		
		$users->register($nickname, $email, $password);
		
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

	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if(empty($email) === true || empty($password) === true){
			$errors[] = 'Vennligst fyll inn brukernavn og passord';
	}else{
		$login = $users->login($email, $password);
		if($login === false){ 
		
			$return = false;
			
			echo json_encode($return);
		}else{
		
			$id = $_SESSION['id'] = $login;

			if($check_bank = $bank->check_bank($login) === true){

			}else{
				$insert_gold = $bank->insert_gold_login($login);
			}

			if($check_army = $army->check_army($login) === true){

			}else{

				//Set 3 heros for 

				//Hero 1
				$hero1Name 		= "Nathil";
				$hero1special 	= "Nature";
				$hero1picture	= "img/heros/hero-Nathil.jpg";
				$drag1ID		= "hero-1-drag";

				$Hero1 = $army->insert_army_login($login, $hero1Name, $hero1special, $hero1picture, $drag1ID);

				//Hero 2
				$hero2Name 		= "Brasko";
				$hero2special 	= "Stone";
				$hero2picture	= "img/heros/hero-Brasko.jpg";
				$drag2ID		= "hero-2-drag";

				$Hero2 = $army->insert_army_login($login, $hero2Name, $hero2special, $hero2picture, $drag2ID);

				//Hero 3
				$hero3Name 		= "Thalin";
				$hero3special 	= "Light";
				$hero3picture	= "img/heros/hero-Thalin.jpg";
				$drag3ID		= "hero-3-drag";

				$Hero3 = $army->insert_army_login($login, $hero3Name, $hero3special, $hero3picture, $drag3ID);
			}

			
			$success = true;
			
			echo json_encode($success);
			exit();
		}
	}
}
?>