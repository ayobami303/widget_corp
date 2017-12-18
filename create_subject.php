<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>

<?php
$menu_name = mysql_prep($_GET['menu_name']);
$position = mysql_prep($_GET['position']);
$visible = mysql_prep($_GET['visible']);

$required  = array('menu_name','position','visible' );
foreach ($required as $required_value ) {
	if (!isset($_GET[$required_value]) || empty($_GET[$required_value])){
		$error[]=$required_value;
	}
}

if (!empty($error)){
	redirect('new_subject.php');
}

$insert_query = "INSERT INTO subjects (menu_name,position,visible) 
				VALUES ('{$menu_name}','{$position}','{$visible}')";
$mysql_insert = mysql_query($insert_query);				
if ($mysql_insert)				{
	redirect('content.php');
}else{
	echo "unsuccessful".mysql_error();
}
?>

<?php
if (isset($query_connect)){
	mysql_close($query_connect);
}
?>