<?php
require('init.php');


$check_table = $dbHandler->check_db_tables();

echo $check_table;
if($check_table === true){
	
}else if($check_table === false){
	$create_tables = $dbHandler->instal_db_tables();
}
?>