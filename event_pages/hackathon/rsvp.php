<?php
	include('../../backend/partials/_dbconnect.php');
	include('../../backend/partials/_functions.php');
	session_start();
	$event_id = 7;
	$attendees_table_name = $event_id . "_attendees";
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$attendee_name = $_POST['attendee-name'];
		$attendee_email = $_POST['attendee-email'];
		$attendee_designation = $_POST['attendee-designation'];
		$attendee_organization = $_POST['attendee-organization'];
	}

	$query = "SELECT user_db_name FROM global_event_list WHERE event_id=$event_id";
	$result = mysqli_query($conn, $query);
	if(!$result){
		die("error in fetching" . mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	$user_db_name = $row['user_db_name'];
	$conn_user_db = mysqli_connect($dbserver, $dbusername, $dbpassword, $user_db_name);


	// inserting attendee data
	try{
	$insertdata = "INSERT INTO $attendees_table_name (`attendee_name`, `attendee_email`, `attendee_designation`, `attendee_organization`) VALUES('$attendee_name', '$attendee_email', '$attendee_designation', '$attendee_organization')";
	if(!mysqli_query($conn_user_db, $insertdata)){
		die("error in inserting data" . mysqli_error);
	}}
	catch(Exception $e){
		header('location: hackathon.html/#buy-tickets'); 
	}

	header('location: hackathon.html');
?>