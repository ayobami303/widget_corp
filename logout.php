<?php require_once("includes/session.php") ?>
<?php require_once("includes/functions.php") ?>
<?php 
	//four steps to closing a session

	//step 1 find the session
	
	//step 2 unset all session variables
	$_SESSION  = array();	

	//step 3 destroy session cookie
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name().''.time()-42000, '/');

	}

	//step 4 destroy the session
	session_destroy();

	redirect('login.php?logout=1');
	
?>