<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>
<?php
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

		$insert_query = "INSERT INTO users (username,hashed_password) 
					VALUES ('{$username}','{$hash_pass}')";
		$mysql_insert = mysql_query($insert_query);				
		if ($mysql_insert)				{
			//redirect('content.php');
			$message = "successful";
		}else{
			$message = "unsuccessful".mysql_error();
		}
	}

	
}else{
	$username = "";
	$password = "";
	
}

?>
<?php find_selected_page(); ?>
<?php include("includes/header.php") ?>
<div class="links"> 
				
					<p><a href="staff.php">Return to menu</a></p>
			</div>

			<div class="nav">
				<h2>Create new user </h2>
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
				<form action="new_user.php" method="post">
					<p><label>Username:</label>
					<input type="text" name="username" value="<?php echo htmlentities($username); ?>" maxlenght="30"></p>
					
					<p><label>Password:</label>
					<input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>"></p>
			
					<input type="submit" name ="submit" value="Create User">
					&nbsp;
					&nbsp;
					
				</form>
				<p><a href="content.php">cancel</a></p>

			</div>

<?php require("includes/footer.php") ?>