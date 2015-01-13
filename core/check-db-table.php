<?php
require('init.php');

$return = array();

$check_table = $dbHandler->check_db_tables();

if($check_table === true){
	$return[1] = true;

	echo json_encode($return);
}else if($check_table === false){
	$return[1] = false;

	echo json_encode($return);
	//$create_tables = $dbHandler->instal_db_tables();
}
?>