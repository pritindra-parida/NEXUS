<?php
  include('../partials/_dbconnect.php');
  include('../partials/_functions.php');
  session_start();

  $username = $_SESSION['username'];
  $user_db_name= "user_" . fetchUserId($username) . "_" . $username;
  $conn_user_db = mysqli_connect($dbserver, $dbusername, $dbpassword, $user_db_name);

  if(!$conn_user_db){
  	die("Connection Failed" . mysqli_connect_error());
  }

  if($_SERVER['REQUEST_METHOD']=="POST"){
  	$event_name = $_POST['event-name'];
  	$event_description = $_POST['event-description'];
  	$event_venue = $_POST['event-venue'];
  	$event_participants_number = $_POST['event-participants-number'];
  	$event_start_date = $_POST['event-start-date'];
  	$event_end_date = $_POST['event-end-date'];
  	$event_start_time = $_POST['event-start-time'];
  	$event_end_time = $_POST['event-end-time'];
  	$speaker_number = $_POST['speaker-number'];
  	$organizer_number = $_POST['organizer-number'];
  	$contact_email = $_POST['contact-email'];
  	$contact_phone = $_POST['contact-phone'];
  	
  	// Dynamic Speaker name and about
  	for($i = 1; $i<=$speaker_number; $i++){
  		${'speaker_name_' . $i} = $_POST['speaker-name-' . $i];
  		${'speaker_about_'. $i} = $_POST['speaker-about-' . $i];	
  	}
  	// Dynamic Organizer name
  	for($i = 1; $i<=$organizer_number; $i++){
  		${'organizer_name_' . $i} = $_POST['organizer-name-' . $i];
  	}
  }
  
  addToGlobalEventList($event_name, $event_start_date, $event_venue, $user_db_name);
  addToEventList($conn_user_db, $event_name, $event_start_date, $event_venue, $event_participants_number);
  createEventTables($conn_user_db, $event_name, $event_description, $event_venue, $event_participants_number, $event_start_date, $event_end_date, $event_start_time, $event_end_time, $speaker_number, $organizer_number, $contact_email, $contact_phone);
  
  for ($i=1; $i<=$speaker_number ; $i++) { 
  	$column_name = "speaker_" . $i;
  	$column_name2 = "speaker_about_" . $i;
  	$speaker_name = ${'speaker_name_' . $i};
  	$speaker_about = ${'speaker_about_' . $i};
  	addSpeakers($conn_user_db ,$column_name, $column_name2, $speaker_name, $speaker_about);
  }
  for ($i=1; $i<=$organizer_number ; $i++) { 
  	$column_name = "organizer_" . $i;
  	$organizer_name = ${'organizer_name_' . $i};
  	addOrganizers($conn_user_db ,$column_name, $organizer_name);
  }
  

  header('location: index.php');
?>