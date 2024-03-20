<?php 
	session_start();
	session_destroy();
	
	include 'database.php';
	
	database::disconnect();
	
	unset( $_SESSION['usuario'] );
	//include 'config.php';	
	Config::destroy();
	header(Config::$webLogin);
	
?>