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
		     post_author varchar( 250 ) NOT NULL, 
		     post_date DATETIME NOT NULL,
		     post_content LONGTEXT NOT NULL,
		     post_title varchar( 250 ) NOT NULL,
		     post_status varchar( 250 ) NOT NULL,
		     post_name varchar( 250 ) NOT NULL,
		     post_modified DATETIME NOT NULL,
		     post_url varchar ( 250 ) NOT NULL,
		     post_type varchar ( 100 ),
		     menu_order INT( 11 ) NOT NULL);" ;

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

	public function instal_nw_taxonomy(){
		$table = "nw_taxonomy";
		try {
		     $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
		     $sql ="CREATE table $table(
		     taxonomy_id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
		     term_id int( 11 ) NOT NULL, 
		     taxonomy varchar( 250 ) NOT NULL,
		     taxonomy_value TINYTEXT NOT NULL);" ;
		     
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

	/**
	* Insert new posts
	*/

	public function insert_post($post_author, $post_content, $post_title, $post_status, $post_name, $post_url, $post_type){
		//constand variables
		$post_date = date('y.m.d h:m:s');

		$query = $this->db->prepare("INSERT INTO `nw_posts` (post_author,post_date,post_content,post_title,post_status,post_name,post_url,post_type) VALUES (?,?,?,?,?,?,?,?)");
		$query->bindValue(1, $post_author);
		$query->bindValue(2, $post_date);
		$query->bindValue(3, $post_content);
		$query->bindValue(4, $post_title);
		$query->bindValue(5, $post_status);
		$query->bindValue(6, $post_name);
		$query->bindValue(7, $post_url);
		$query->bindValue(8, $post_type);

		try{
			$query->execute();

			$post_id = $this->get_post_id_from_category($post_url);
			return $post_id;

		}catch(PDOException $e){
				die($e->getMessage());
		}
	}

	/**
	* Update post
	*/
	public function update_post($post_author, $post_content, $post_title, $post_name, $post_id, $post_status){
		//constand variables
		$post_date = date('y.m.d h:m:s');

		$query = $this->db->prepare("UPDATE `nw_posts` SET `post_author` = ?, `post_content` = ?, `post_title` = ?, `post_status` = ?, `post_modified` = ?, `post_name` = ? WHERE `ID` = ?");
		$query->bindValue(1, $post_author);
		$query->bindValue(2, $post_content);
		$query->bindValue(3, $post_title);
		$query->bindValue(4, $post_status);
		$query->bindValue(5, $post_date);
		$query->bindValue(6, $post_name);
		$query->bindValue(7, $post_id);

		try{
			$query->execute();

			$post_id = $this->get_post_id_from_category($post_url);
			return $post_id;

		}catch(PDOException $e){
				die($e->getMessage());
		}
	}

	/**
	* DELETE POST
	*/
	public function delete_post($post_id){
		//constand variables
		$query = $this->db->prepare("DELETE FROM `nw_posts` WHERE `ID` = ?");
		$query->bindValue(1, $post_id);

		try{
			$query->execute();

		}catch(PDOException $e){
				die($e->getMessage());
		}
	}

	public function get_post_by_id($post_id){
		$query = $this->db->prepare("SELECT * FROM `nw_posts` where `ID` = ?");
		$query->bindValue(1, $post_id);

		try{
			$query->execute();
			$data = $query->fetch();

			return $data;

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function get_all_posts($post_type){
		$query = $this->db->prepare("SELECT * FROM `nw_posts` WHERE `post_type` = ? ORDER BY `post_date` DESC");
		$query->bindValue(1, $post_type);

		try{
			$query->execute();
			$data = $query->fetchAll();

			return $data;

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	private function get_post_id_from_category($post_url){
		$query = $this->db->prepare("SELECT * FROM `nw_posts` WHERE `post_url` = ?");
		$query->bindValue(1, $post_url);

		try{
			$query->execute();
			$data = $query->fetch();
			$post_id = $data['ID'];

			return $post_id;

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	*Check post number
	*/

	public function check_post_number(){
		$query = $this->db->prepare("SELECT count(`ID`) FROM `nw_posts`");

		try{
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 0){
				return 0;
			}else{
				return $rows;
			}
			

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	*Check page count
	*/
	public function check_post_page_number($post_type){
		
		$query = $this->db->prepare("SELECT count(`ID`) FROM `nw_posts` WHERE `post_type` = ?");
		$query->bindValue(1, $post_type);

		try{
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 0){
				return 0;
			}else{
				return $rows;
			}
			

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	/**
	* Get all categories
	*/
	public function get_all_cat(){

		$value = 'category';	

		$query = $this->db->prepare("SELECT * FROM `nw_taxonomy` WHERE `taxonomy` = ?");
		$query-> bindValue(1, $value);

		try{
			$query->execute();
			$data = $query->fetchAll();

			return $data;
		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	/**
	* Get post category
	*/
	public function get_post_cat($post_id){
		$value = 'post_category';

		$query = $this->db->prepare("SELECT * FROM `nw_postmeta` WHERE `post_id` = ? AND `meta_key`= ? ");
		$query-> bindValue(1, $post_id);
		$query-> bindValue(2, $value);

		try{
			$query->execute();
			$data = $query->fetch();

			return $data;
		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	/**
	* Get post templates
	*/
	public function get_all_templates(){
		$value = 'template';	

		$query = $this->db->prepare("SELECT * FROM `nw_taxonomy` WHERE `taxonomy` = ?");
		$query-> bindValue(1, $value);

		try{
			$query->execute();
			$data = $query->fetchAll();

			return $data;
		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	//get templates for edit mode
	public function get_page_template($post_id){
		$value = 'page_template';

		$query = $this->db->prepare("SELECT * FROM `nw_postmeta` WHERE `post_id` = ? AND `meta_key`= ? ");
		$query-> bindValue(1, $post_id);
		$query-> bindValue(2, $value);

		try{
			$query->execute();
			$data = $query->fetch();

			return $data;
		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	/**
	* Insert tamplate in post_meta
	*/
	public function insert_page_template($postID, $category_name){

		$meta_key = 'page_template';

		$query = $this->db->prepare("INSERT INTO `nw_postmeta` (post_id,meta_key,meta_value) VALUES (?,?,?)");
		$query-> bindValue(1, $postID);
		$query-> bindValue(2, $meta_key);
		$query-> bindValue(3, $category_name);

		try{
			$query->execute();
			$check = $this->check_category_taxonomy($category_name);
			if($check === true){
				$this->insert_taxonomy_template($postID, $category_name);
			}else if($check === false){
				
			}

			return true;
		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	/**
	* Insert page template taxonomy
	*/
	private function insert_taxonomy_template($postID, $category_name){
		$query = $this->db->prepare("INSERT INTO `nw_taxonomy` (term_id, taxonomy, taxonomy_value) VALUES (?,?,?)");
		$query->bindValue(1, $postID);
		$query->bindValue(2, 'template');
		$query->bindValue(3, $category_name);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}


	/**
	* Check if category allready is inserted into taxonomy value, if not insert it. 
	*/
	private function check_category_taxonomy($category_name){
		$query = $this->db->prepare("SELECT count(`taxonomy_id`) FROM `nw_taxonomy` WHERE `taxonomy_value` = ?");
		$query->bindValue(1, $category_name);

		try{
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 0){
				return true;
			}else if($rows >= 1){
				
				return false;
			}

		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	/**
	* Insert new post category
	*/
	public function insert_post_category($postID, $category_name){

		$meta_key = 'post_category';

		$query = $this->db->prepare("INSERT INTO `nw_postmeta` (post_id,meta_key,meta_value) VALUES (?,?,?)");
		$query-> bindValue(1, $postID);
		$query-> bindValue(2, $meta_key);
		$query-> bindValue(3, $category_name);

		try{
			$query->execute();
			$check = $this->check_category_taxonomy($category_name);
			if($check === true){
				$this->insert_taxonomy_category($postID, $category_name);
			}else if($check === false){
				
			}

			return true;
		}catch(PDOException $e){
			die($e ->getMessage());
		}
	}

	/**
	* Update existing post category
	*/
	public function update_post_category($postID, $meta_key, $meta_value){
		$query = $this->db->prepare("UPDATE `nw_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = ?");
		$query->bindValue(1, $meta_value);
		$query->bindValue(2, $postID);
		$query->bindValue(3, $meta_key);

		try{
			$query->execute();

		}catch(PDOException $e){
				die($e->getMessage());
		}
	}


	private function insert_taxonomy_category($postID, $category_name){
		$query = $this->db->prepare("INSERT INTO `nw_taxonomy` (term_id, taxonomy, taxonomy_value) VALUES (?,?,?)");
		$query->bindValue(1, $postID);
		$query->bindValue(2, 'category');
		$query->bindValue(3, $category_name);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e ->getMessage());
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