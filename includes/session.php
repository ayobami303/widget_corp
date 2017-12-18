<?php require_once("includes/functions.php") ?>
<?php
	session_start();
	function confirm_login(){
		if (!isset($_SESSION['user_id'])){
			redirect('login.php');
		}
	}
 ?>