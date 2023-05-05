<?php
include('partials/_dbconnect.php');


if($_SERVER['REQUEST_METHOD']=="POST")
{ 
	// Variable Declaration
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];


	if($email !=''|| $password !='')
	{
		$sql = "insert into sign_up(fullname, username, email, password) values ('$fullname', '$username', '$email','$password')";
		$result = mysqli_query($conn, $sql);
		$_SESSION['success']  = "New user successfully created!!";
		echo "New user created";
		header('location: /NEXUS_test/index.html');
	}
}
$conn->close();
?>