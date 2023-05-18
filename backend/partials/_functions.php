<?php
include('_dbconnect.php');
$dbConn = mysqli_connect ($dbserver, $dbusername, $dbpassword, $dbname);

function random_string($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return strtoupper($randomString);
}

/*
	Check if a session user id exist or not. If not set redirect
	to login page. If the user session id exist and there's found
	$_GET['logout'] in the query string logout the user
*/
function checkFDUser()
{
	// if the session id is not set, redirect to login page
	if (!isset($_SESSION['username'])) {
		header('Location: login.php');
		exit;
	}
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();
	}
}

function doLogin()
{
	$username 	= $_POST['username'];
	$password	= $_POST['password'];
	
	$errorMessage = '';
	
	$sql 	= "SELECT * FROM `sign_up` WHERE username = '$username' AND password = '$password'";
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 1) {
		$row = dbFetchAssoc($result);
		$_SESSION['username'] = $username;
		$_SESSION['calendar_fd_user_name'] = $row['username'];
		header('Location: dashboard/index.php');
		exit();
	}
	else {
		$errorMessage = 'Invalid username / passsword. Please try again or contact to support.';
	}
	return $errorMessage;
}


/*
	Logout a user
*/
function doLogout()
{
	if (isset($_SESSION['calendar_fd_user'])) {
		unset($_SESSION['calendar_fd_user']);
		//session_unregister('hlbank_user');
	}
	header('Location: login.php');
	exit();
}

function getBookingRecords(){
	$per_page = 10;
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	$sql 	= "SELECT u.id AS uid, u.name, u.phone, u.email,
			   r.ucount, r.rdate, r.status, r.comments   
			   FROM tbl_users u, tbl_reservations r 
			   WHERE u.id = r.uid  
			   ORDER BY r.id DESC LIMIT $start, $per_page";
	//echo $sql;
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("user_id" => $uid,
							"user_name" => $name,
							"user_phone" => $phone,
							"user_email" => $email,
							"count" => $ucount,
							"res_date" => $rdate,
							"status" => $status,
							"comments" => $comments);	
	}//while
	return $records;
}


function getUserRecords(){
	$per_page = 20;
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'student') {
		$id = $_SESSION['calendar_fd_user']['id'];
		$sql = "SELECT  * FROM tbl_users u WHERE type != 'admin' AND id = $id ORDER BY u.id DESC";
	}
	else {
		$sql = "SELECT  * FROM tbl_users u WHERE type != 'admin' ORDER BY u.id DESC LIMIT $start, $per_page";
	}
	
	//echo $sql;
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("user_id" => $id,
			"user_name" => $name,
			"user_phone" => $phone,
			"user_email" => $email,
			"type" => $type,
			"status" => $status,
			"bdate" => $bdate
		);	
	}
	return $records;
}





/*  ===============
    Database Functions
    ===============*/
function dbQuery($sql)
{
	global $dbConn;
	$result = mysqli_query($dbConn,$sql); //or die(mysql_error());
	return $result;
}

function dbAffectedRows()
{
	global $dbConn;
	return mysql_affected_rows($dbConn);
}

function dbFetchArray($result, $resultType = MYSQL_NUM) {
	return mysql_fetch_array($result, $resultType);
}

function dbFetchAssoc($result)
{
	return mysqli_fetch_assoc($result);
}

function dbFetchRow($result) 
{
	return mysqli_fetch_row($result);
}

function dbFreeResult($result)
{
	return mysqli_free_result($result);
}

function dbNumRows($result)
{
	return mysqli_num_rows($result);
	
}

function dbSelect($dbName)
{
	return mysqli_select_db($dbName);
}

function dbInsertId()
{
	return mysqli_insert_id();
}



// Functions for Users

function getEventList($username){

}

function getEventAttendeeList($username, $eventid){

}






// Dashboard Functions

function fetchUserId($username){
	global $dbusername;
	global $dbserver;
	global $dbpassword;
	global $dbname;
	$conn = new mysqli($dbserver, $dbusername, $dbpassword, $dbname);
	$query = "select id from sign_up where username = '" .  $username . "'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	return $row['id'];
}




// Event Creation Functions
function addToEventList($conn_user_db, $event_name, $event_start_date, $event_venue, $event_participants_number){

	$query = "INSERT INTO `event_list` (`event_name`, `event_date`, `event_venue`, `participants_number`) VALUES ('$event_name', '$event_start_date', '$event_venue', '$event_participants_number');";
	if(!mysqli_query($conn_user_db, $query)){
		die("error in inserting" . mysqli_error());
	}	
}



function createEventTables($conn_user_db, $event_name, $event_description, $event_venue, $event_participants_number, $event_start_date, $event_end_date, $event_start_time, $event_end_time, $speaker_number, $organizer_number, $contact_email, $contact_phone){

	$fetchEventId = "SELECT MAX(event_id) FROM `event_list`";
	$row = mysqli_fetch_assoc(mysqli_query($conn_user_db, $fetchEventId));
	$event_id = $row['MAX(event_id)'];
	$event_table_name = $event_id . "_details";
	$attendes_table_name = $event_id . "_attendees";

	$query = "CREATE TABLE " . $event_table_name . " (`event_id` INT(3) NOT NULL, `event_name` VARCHAR(250) NOT NULL , `event_description` VARCHAR(250) NOT NULL , `event_venue` VARCHAR(250) NOT NULL , `participants_number` INT(250) NOT NULL , `event_start_date` DATE NOT NULL , `event_end_date` DATE NOT NULL , `event_start_time` TIME NOT NULL , `event_end_time` TIME NOT NULL , `speaker_count` INT(10) NOT NULL , `organizer_count` INT(10) NOT NULL , `contact_email` VARCHAR(250) NOT NULL , `contact_phone` INT(20) NOT NULL, PRIMARY KEY (`event_id`)) ENGINE = InnoDB;";
	if(!mysqli_query($conn_user_db, $query)){
		die("error in creating table" . mysqli_error());
	}
	$query2 = "CREATE TABLE " . $attendes_table_name . " (`attendee_id` INT(10) NOT NULL AUTO_INCREMENT , `attendee_name` VARCHAR(250) NOT NULL , `attendee_email` VARCHAR(250) NOT NULL , `attendee_designation` VARCHAR(150) NOT NULL , `attendee_organization` VARCHAR(250) NOT NULL , PRIMARY KEY (`attendee_id`), UNIQUE (`attendee_email`)) ENGINE = InnoDB;";
	if(!mysqli_query($conn_user_db, $query2)){
		die("error in creating table" . mysqli_error());
	}

}

function addSpeakers($conn_user_db, $column_name, $speaker_name){
	$fetchEventId = "SELECT MAX(event_id) FROM `event_list`";
	$row = mysqli_fetch_assoc(mysqli_query($conn_user_db, $fetchEventId));
	$event_id = $row['MAX(event_id)'];
	$event_table_name = $event_id . "_details";
	$attendes_table_name = $event_id . "_attendees";

	$query = "ALTER TABLE " . $event_table_name . " ADD " . $column_name . " VARCHAR(250) NOT NULL;";

	if(!mysqli_query($conn_user_db, $query)){
		die("error in adding column" . mysqli_error());
	}
	
}

function addOrganizers(){

}


?>