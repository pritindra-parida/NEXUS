<?php  
	$dbusername = "root";
	$password="";
	$dbname = "user_db";
	$server = "localhost";

	try{
		$conn = new mysqli($server, $dbusername, $password, $dbname);
	}
	catch(Exception $e){
		echo e;
	}
?>