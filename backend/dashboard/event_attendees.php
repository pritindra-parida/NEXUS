<?php
  include('../partials/_dbconnect.php');
  include('../partials/_functions.php');
  session_start();
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$event_id = $_POST['id_search'];
		$attendees_table_name = $event_id . "_attendees";
	}
	

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>xd</title>
</head>
<body>

</body>
</html>