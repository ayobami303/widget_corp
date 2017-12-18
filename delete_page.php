<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>

<?php
if (intval($_GET['page']) == 0) {
	redirect("content.php");
}

$id = mysql_prep($_GET['page']); 

if ($Subject = get_page_by_id($id)) {
	$query = " DELETE FROM pages WHERE id = {$id} LIMIT 1 ";
	$result = mysql_query($query);
	if (mysql_affected_rows()==1){
		//successful
		redirect("content.php");
	}else{
		//deletion failed
		echo  "<p>Subject deletion failed </p>";
		echo  "<p>" . mysql_error() . "</p>";
		echo "<a href=\"content.php\" Return to Main page </a>";
	}
}else{
	redirect("content.php");
}

?>


<?php
mysql_close($query_connect);
?>