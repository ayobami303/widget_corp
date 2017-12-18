<?php
require("constant.php");

$query_connect= mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if(!$query_connect){
	die();
}
$mysql_select_db= mysql_select_db(DB_NAME);
if(!$mysql_select_db){
	echo "ereg";
	die("database selection faild:".mysql_error());
}
?>