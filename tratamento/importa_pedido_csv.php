<?php	
	session_start();		
	
    include '../database.php';
	
	//error_reporting(0); 
	
    global $pdo;	
	
	$pdo = database::connect();
	
	$sql = '';
	
	echo $_POST['id_reg'];
	
		
?>		