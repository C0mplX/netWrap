<?php
include('PassHass.php');

class DbHandler{
	
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
		$query = $this->db->prepare("SELECT * FROM `nw_users`");

		try{
			$query->execute();
			$check = $query->fetch();
			if($check == ""){
				return false;
			}
			else{
				return true;	
			}
			

		}catch(PDOException $e){
			return false;
		}
	}



	/******************
	*
	* Create the tables on firsttime install 
	*
	******************/

	public function instal_nw_users_table(){

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
		    die($e->getMessage());//Remove or change message in production code
		}
	}


	public function instal_nw_usermeta_table(){
		$table = "nw_usermeta";
		try {
		     $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		     $sql ="CREATE table $table(
		     umeta_id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
		     user_id INT( 11 ) NOT NULL, 
		     meta_key VARCHAR( 250 ) NOT NULL,
		     meta_value LONGTEXT NOT NULL);" ;
		     $this->db->exec($sql);

		} catch(PDOException $e) {
		    die($e->getMessage());//Remove or change message in production code
		}
	}

	public function instal_nw_posts_table(){

		$table = "nw_posts";
		try {
		     $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		     $sql ="CREATE table $table(
		     ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
		     post_author INT( 11 ) NOT NULL, 
		     post_date DATETIME NOT NULL,
		     post_content LONGTEXT NOT NULL,
		     post_title varchar( 250 ) NOT NULL,
		     post_status varchar( 250 ) NOT NULL,
		     post_name varchar( 250 ) NOT NULL,
		     post_modified date NOT NULL,
		     post_url varchar ( 250 ) NOT NULL,
		     post_type varchar ( 100 ));" ;

		     $this->db->exec($sql);

		} catch(PDOException $e) {
		    die($e->getMessage());//Remove or change message in production code
		}
	}

	public function instal_nw_postmeta_table(){

		$table = "nw_postmeta";
		try {
		     $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		     $sql ="CREATE table $table(
		     meta_id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
		     post_id INT( 11 ) NOT NULL, 
		     meta_key varchar( 250 ) NOT NULL,
		     meta_value LONGTEXT NOT NULL);" ;
		     
		     $this->db->exec($sql);

		} catch(PDOException $e) {
		    die($e->getMessage());//Remove or change message in production code
		}
	}

	public function instal_nw_options(){

		$table = "nw_options";
		try {
		     $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		     $sql ="CREATE table $table(
		     option_id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
		     option_name varchar( 250 ) NOT NULL, 
		     option_value varchar( 250 ) NOT NULL);" ;
		     
		     $this->db->exec($sql);

		} catch(PDOException $e) {
		    die($e->getMessage());//Remove or change message in production code
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
		$query = $this->db->prepare("SELECT count(`user_email`) FROM `nw_users` WHERE `user_email`= ?");
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
		$query = $this->db->prepare("SELECT count(`user_login`) FROM `nw_users` WHERE `user_login` = ?");
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
	public function register($display_name, $user_login, $user_email, $user_pass){
		
		$date				= date('Y.m.d h:m:s');
		$user_pass 			= PassHash::hash($user_pass);

		$query = $this->db->prepare("INSERT INTO `nw_users` (user_login, user_pass, user_email, user_registred, display_name) VALUES (?,?,?,?,?)");

		$query->bindValue(1, $user_login);
		$query->bindValue(2, $user_pass);
		$query->bindValue(3, $user_email);
		$query->bindValue(4, $date);
		$query->bindValue(5, $display_name);


		try{
			$query->execute();

			return true;

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	* Get nw__user data
	*/
	public function get_userdata_first(){
		$query = $this->db->prepare("SELECT * FROM `nw_users` ");

		try{
			$query->execute();
			$data 				= $query->fetch();
			$id 				= $data['ID']; 

			return $id;

		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	/**
	*Insert meta data about the first admin user
	*/
	public function insert_usermeta($user_id, $meta_key, $meta_value){
		
		$query = $this->db->prepare("INSERT INTO `nw_usermeta` (user_id,meta_key,meta_value) VALUES (?,?,?)");

		$query->bindValue(1, $user_id);
		$query->bindValue(2, $meta_key);
		$query->bindValue(3, $meta_value);

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
		$query = $this->db->prepare("SELECT `user_pass`, `id` FROM `nw_users` WHERE `user_login` = ?");
		$query->bindValue(1, $email);

		try{
			$query->execute();
			$data 				= $query->fetch();
			$stored_password	= $data['user_pass'];
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


	/***************
	*
	* Methods to retrive data from the nw_user table 
	*
	***************/
	public function get_userdata_admin($id){
		$query = $this->db->prepare("SELECT * FROM `nw_users` WHERE `ID`= ?");
		$query->bindValue(1, $id);

		try{
			$query->execute();
			$data 				= $query->fetch();

			return $data;

		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}




	/***************
	*
	* Methods to retrive data from the nw_usermeta table 
	*
	***************/
	public function get_usermeta_admin($id, $meta_key){
		$query = $this->db->prepare("SELECT * FROM `nw_usermeta` WHERE `user_id`= ? AND `meta_key` = ?");
		$query->bindValue(1, $id);
		$query->bindValue(2, $meta_key);

		try{
			$query->execute();
			$data 				= $query->fetch();

			return $data;

		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}



}
?>