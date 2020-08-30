<?php
   include('config.php');
   // Start the session
   session_start();
   // Verifying if the login_user session variable is empty
   if(!empty($_SESSION['login_user'])){
	   
	   //We assign the session value to the $user_check variable
	   $user_check = $_SESSION['login_user'];

	   //Ask if the user is already in our database.
	   $ses_sql = mysqli_query($db,"select username from login where username = '$user_check' ");
	   
	   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
	   //We assign the result to the $login_session variable
	   $login_session = $row['username'];
	   
	   //If the $login_session is not set then the user does not exist
	   if(!isset($_SESSION['login_user'])){
	      header("location:login.php");
	   }
	}else{
		//If login_user variable session is empty, we redirect the user to the login page
		header("location:login.php");
	}
?>