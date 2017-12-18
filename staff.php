<?php require_once("includes/session.php") ?>

<?php confirm_login() ?>
<?php
$host="localhost";
$user="root";
$pass="";

$query= mysql_connect("$host","$user","$pass");
if($query){
	//echo "ok";
}
else{
	die();
}
?>


<?php include("includes/header.php") ?>
	<div class="links">
		
	</div>

	<div class="nav">
		<h2>Staff Menu</h2>
		<p>Welcome To Staff Area, <?php echo $_SESSION['username']?></p>
			<ul>
				<li><a href="content.php">Manage Website</a> </li>
				<li><a href="new_user.php">Add Staff User</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
	</div>
<?php include("includes/footer.php") ?>	
		