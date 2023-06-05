<?php
  include('../partials/_dbconnect.php');
  include('../partials/_functions.php');
  session_start();

  if($_SERVER['REQUEST_METHOD']=="POST"){
  	$event_search_id = $_POST['event_search_id'];
  }
  $table_name = $event_search_id . "_attendees";

  $query = "SELECT * FROM $table_name"




  header('location: index.php#event_attendees');
?>