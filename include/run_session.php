<?php
session_start(); //Start the session
if(empty($_SESSION['user_id'])){ //If session not registered
	session_write_close();
	header("location:../login/login.php"); // Redirect to login.php page
}
else {//Continue to current page
	define("USERID", $_SESSION['user_id']);
	session_write_close();
	header( 'Content-Type: text/html; charset=utf-8' );
}
?>