<?php
include('PassHass.php');

class Users{
	
	/*********
	*Connect to the database and make that object __contruct and avialable for the hole class
	***********/
	private $db;
		
	public function __construct($database){
		$this->db = $database;
	}

	
	/***************
	*
	*Check if there are tables in the DB. 
	*
	***************/

	public function check_db_tables(){
		$query = $this->db->prepare("SELECT 1 FROM `nw_users` LIMIT 1");

		try{
			$query->execute();

			return true;

		}catch(PDOException $e){
			return false;
		}
	}



	/******************
	*
	* Create the tables on firsttime install 
	*
	******************/

	public function instal_db_tables(){

		$table = "nw_users";
		try {
		     $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		     $sql ="CREATE table $table(
		     ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
		     user_login VARCHAR( 50 ) NOT NULL, 
		     user_pass VARCHAR( 250 ) NOT NULL,
		     user_nickname VARCHAR( 150 ) NOT NULL, 
		     user_email VARCHAR( 150 ) NOT NULL,
		     user_registred date NOT NULL, 
		     user_status INT( 11 ) NOT NULL,
		     display_name VARCHAR( 50 ) NOT NULL);" ;
		     $this->db->exec($sql);

		} catch(PDOException $e) {
		    echo $e->getMessage();//Remove or change message in production code
		}

		$table = "nw_users";
		try {
		     $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		     $sql ="CREATE table $table(
		     ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
		     user_login VARCHAR( 50 ) NOT NULL, 
		     user_pass VARCHAR( 250 ) NOT NULL,
		     user_nickname VARCHAR( 150 ) NOT NULL, 
		     user_email VARCHAR( 150 ) NOT NULL,
		     user_registred date NOT NULL, 
		     user_status INT( 11 ) NOT NULL,
		     display_name VARCHAR( 50 ) NOT NULL);" ;
		     $this->db->exec($sql);

		} catch(PDOException $e) {
		    echo $e->getMessage();//Remove or change message in production code
		}
	}





	/***************
	*
	*registration and validation of input from user
	*
	***************/

	/***********
	*Validation of inputs upon registration
	***********/

	//Check if email existst in the database
	public function email_exists($email){
		$query = $this->db->prepare("SELECT count(`email`) FROM `members` WHERE `email`= ?");
		$query->bindValue(1, $email);

		try{
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){

				return true;

			}else{

				return false;
			}

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	//Check if nickname existst in the database
	public function name_exists($name){
		$query = $this->db->prepare("SELECT count(`nickname`) FROM `members` WHERE `nickname` = ?");
		$query->bindValue(1, $name);

		try{
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){

				return true;
			}else{
				
				return false;
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	//register the new user 
	public function register($nickname, $email, $password){
		
		$date				= date("Y.m.d");
		$password 			= PassHash::hash($password);

		$query = $this->db->prepare("INSERT INTO `members` (nickname,email,password,joindate) VALUES (?,?,?,?)");

		$query->bindValue(1, $nickname);
		$query->bindValue(2, $email);
		$query->bindValue(3, $password);
		$query->bindValue(4, $date);


		try{
			$query->execute();

			return true;

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/***************
	*
	* Login user
	*
	***************/
	
	//loging in the user
	//Loggin User
	public function login($email, $password){
		$query = $this->db->prepare("SELECT `password`, `id` FROM `members` WHERE `email` = ?");
		$query->bindValue(1, $email);

		try{
			$query->execute();
			$data 				= $query->fetch();
			$stored_password	= $data['password'];
			$id 				= $data['id']; 

			if(PassHash::check_password($stored_password, $password)){

				return $id;

			}else{

				return false;
			}
		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

}
?>