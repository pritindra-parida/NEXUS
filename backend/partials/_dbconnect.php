<?php  
	$dbusername = "root";
	$dbpassword="";
	$dbname = "user_db";
	$dbserver = "localhost";

	try{
		$conn = new mysqli($dbserver, $dbusername, $dbpassword, $dbname);
	}
	catch(Exception $e){
		echo e;
	}
?>