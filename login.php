<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>

<?php
if (isset($_SESSION['user_id'])){
			redirect('staff.php');
		}



if(isset($_POST['submit'])){
	$username = mysql_prep($_POST['username']);
	$password = mysql_prep($_POST['password']);

	$required  = array('username','password' );
	foreach ($required as $required_value ) {
		if (!isset($_POST[$required_value]) || empty($_POST[$required_value]) ){
			$error[]=$required_value;
		}
	}
	

	if (empty($error)){
		$hash_pass = sha1($password);

		$insert_query = "SELECT id,username FROM users  
					WHERE username = '{$username}' AND hashed_password = '{$hash_pass}'";
		$mysql_insert = mysql_query($insert_query);				
		if (mysql_num_rows($mysql_insert) == 1 ){
			//redirect('content.php');
			//$message = "successful";
			$found_record = mysql_fetch_array($mysql_insert);
			$_SESSION['user_id'] = $found_record['id'];
			$_SESSION['username'] = $found_record['username'];
			redirect("staff.php");
		}else{
			$message = "Incorrect username or password".mysql_error();
		}
	}

	
}else{
	if (isset($_GET['logout']) && $_GET['logout'] == 1 ) {
		# code...
		$message = "You are now logged out";
	}
	$username = "";
	$password = "";
	
}

?>

<?php find_selected_page(); ?>
<?php include("includes/header.php") ?>
<div class="links"> 
				<p><a href="index.php">Go to public site</a></p>
					
			</div>

			<div class="nav">
				<h2>Login here </h2>
				<?php
				if (!empty($message)){
					echo "<p>{$message}</p>";
				}
				?>

				<?php
				//output a list
				if (!empty($error)) {
					echo "<p> Please review the following field:</p> </br>";
					foreach ($error as $fieldname => $name) {
						echo "-" . $name . "</br>";
					}

				}
				?>
				<form action="login.php" method="post">
					<p><label>Username:</label>
					<input type="text" name="username" ></p>
					
					<p><label>Password:</label>
					<input type="password" name="password"></p>
					
					<input type="submit" name ="submit" value="Login">
					&nbsp
					&nbsp
					
				</form>
				

			</div>

<?php require("includes/footer.php") ?>