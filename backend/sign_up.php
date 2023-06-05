<?php
include('partials/_dbconnect.php');
include('partials/_functions.php');


if($_SERVER['REQUEST_METHOD']=="POST")
{ 
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];


	if($email !=''|| $password !='')
	{
		// Adding New User To Main Database
		$sql = "insert into sign_up(fullname, username, email, password) values ('$fullname', '$username', '$email','$password')";
		$result = mysqli_query($conn, $sql);
		$_SESSION['success']  = "New user successfully created!!";
		echo "New user created";
		
		// Connection to MySQL
		$mysql_conn = mysqli_connect($dbserver, $dbusername, $dbpassword);
		if(!$conn){
			die("Connection Failed" . mysqli_connect_error());
		}

		// Database Creation
		$user_db_name= "user_" . fetchUserId($username) . "_" . $username;  //User Database Name Format is "user_userid_username"

		$create_database = "CREATE DATABASE $user_db_name";
		if(!mysqli_query($conn,$create_database)){
			die("Error in Creating Database" . mysqli_error());
		}

		// Events List Table Creation

		$db_conn = mysqli_connect($dbserver, $dbusername, $dbpassword, $user_db_name);
		$create_event_list_table = "CREATE TABLE `event_list` (`event_id` INT(10) NOT NULL, `event_name` VARCHAR(250) NOT NULL , `event_date` DATE NOT NULL , `event_venue` VARCHAR(250) NOT NULL , `participants_number` INT(250) NOT NULL , PRIMARY KEY (`event_id`)) ENGINE = InnoDB;";
		

		// $create_event_details_table = "CREATE TABLE `event_details` (`event_id` INT(3) NOT NULL AUTO_INCREMENT , `event_name` VARCHAR(250) NOT NULL , `event_description` VARCHAR(250) NOT NULL , `event_venue` VARCHAR(250) NOT NULL , `participants_number` INT(250) NOT NULL , `event_start_date` DATE NOT NULL , `event_end_date` DATE NOT NULL , `event_start_time` TIME NOT NULL , `event_end_time` TIME NOT NULL , `speaker_count` INT(10) NOT NULL , `organizer_count` INT(10) NOT NULL , `contact_email` VARCHAR(250) NOT NULL , `contact_number` INT(20) NOT NULL, PRIMARY KEY (`event_id`)) ENGINE = InnoDB;";

		if(!mysqli_query($db_conn,$create_event_list_table)){
			die("Error in Creating Event Table" . mysqli_error());
		}



		header('location: login.php');
	}
}
$conn->close();
?>