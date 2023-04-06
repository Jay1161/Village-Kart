<?php

error_reporting(0);
session_start();

include('connection.php');

if(isset($_SESSION['admin'])){
	
	session_unset($_SESSION['admin']);
    header("location:login.php");

}


if(isset($_SESSION['user'])){

	//$sess=$_SESSION['sid'];

	//$updateque="update time set timeout=NOW() where session_id='$sess'";
    //$d=mysqli_query($conn,$updateque);
	session_unset($_SESSION['user']);
	//session_unset($_SESSION['sid']);
    header('location:login.php');
}

?>

    




 