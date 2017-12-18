<?php
function mysql_prep($value){
	$magic_quote_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string");
//checks if php version supports
	if ($new_enough_php){
		//removes slashes added by magic quote
		if ($magic_quote_active){
			$value= stripslashes($value);
		}
		$value = mysql_real_escape_string($value);	
	}else{
		//add aslashes again
		if (!$magic_quote_active){
			$value = addslashes($value);
		}
	}
	return $value;
}

function redirect($Location= NULL){
	if ($Location!= NULL) {
		header('Location:'.$Location);
		exit;
	}
}
function confirm_query($result_set){
	if (!$result_set){
		die("database query failed".mysql_error());
	}
}

function get_all_subject($public = true){
	$query = "SELECT * FROM subjects";
	if ($public == true) {
		$query .= " WHERE visible = 1 ";
		
	}
	
	$query .= " ORDER BY position ASC";  
					$subject_set= mysql_query($query);
					confirm_query($subject_set);
					return $subject_set;
}

function get_all_pages($subject_id, $public = true){
	$query = "SELECT * FROM pages";
	$query .= " where subject_id = {$subject_id}";
	if ($public == true){
		$query .= " AND visible = 1 ";
	}
	
	$query .= " ORDER BY position ASC" ;

	$page_set= mysql_query($query);
	confirm_query($page_set);
	return $page_set;
}
function get_subject_by_id($subject_id){
	$query = "SELECT * ";
	$query.= " FROM subjects ";
	$query.= " WHERE id = ". $subject_id;
	$query.= " LIMIT 1 ";
	$result_set= mysql_query($query);
	confirm_query($result_set);

	if ($subject=mysql_fetch_array($result_set)){
		return $subject;
	}else{
		return null;
	} 
}

function get_page_by_id( $page_id){
	$query = "SELECT * ";
	$query.= " FROM pages ";
	$query.= " WHERE id = ". $page_id;
	$query.= " LIMIT 1 ";
	$result_set= mysql_query($query);
	confirm_query($result_set);

	if ($page=mysql_fetch_array($result_set)){
		return $page;
	}else{
		return null;
	}
}
function get_default_page($subject){
	$page = get_all_pages($subject, true);
	if ($first_page = mysql_fetch_array($page)) {
		return $first_page;
	}else{
		return null;
	}
	 
}

function find_selected_page(){
	global $sel_subject;
	global $select_page;
	if (isset($_GET['subj'])){
		$sel_subject= get_subject_by_id($_GET['subj']);
		$select_page= get_default_page($sel_subject['id']);
	}elseif (isset($_GET['page'])) {
		$sel_subject= NULL;
		$select_page= get_page_by_id( $_GET['page']);
	}else{
		$sel_subject= NULL;
		$select_page= NULL;
	}
}

function navigation($sel_subject, $select_page, $public = false){
	$output = "<ul class=\"subjects\">";
			$subject_set= get_all_subject($public );
				while ($subject = mysql_fetch_array($subject_set)) {

					$output .= "<li ";
					if($sel_subject["id"]== $subject["id"]){
						$output .= "class= \"selected\"";
						}
						$output .= "><a href=\"edit_subject.php?subj=".urlencode($subject["id"]).	
						"\" >{$subject["menu_name"]} </a></li>";
						
						$output .= "<ul class=\"pages\">";
							$page_set= get_all_pages($subject["id"], $public);
							while ($page = mysql_fetch_array($page_set)) {
								$output .= "<li ";
								if($select_page["id"]== $page["id"]){
									$output .= "class= \"selected\"";
								}
								$output .= "><a href=\"content.php?page=".urlencode($page["id"]).
									"\">{$page["menu_name"]}</a></li>";
							}	
						$output .= "</ul>";
					}
					$output .= "</ul><br>";
	return $output;
}

function public_navigation($sel_subject, $select_page, $public = true){
	$output = "<ul class=\"subjects\">";
			$subject_set= get_all_subject($public);
				while ($subject = mysql_fetch_array($subject_set)) {

					$output .= "<li ";
					if($sel_subject["id"]== $subject["id"]){
						$output .= "class= \"selected\"";
						}
						$output .= "><a href=\"index.php?subj=".urlencode($subject["id"]).	
						"\" >{$subject["menu_name"]} </a></li>";

						
							$output .= "<ul class=\"pages\">";
							$page_set= get_all_pages($subject["id"], $public);
							while ($page = mysql_fetch_array($page_set) ) {
								if(($sel_subject["id"] == $subject["id"])){
									$output .= "<li ";
									if($select_page["id"]== $page["id"]){
										$output .= "class= \"selected\"";
									}
									$output .= "><a href=\"index.php?page=".urlencode($page["id"]).
										"\">{$page["menu_name"]}</a></li>";
								}		
							}	
						$output .= "</ul>";	
						
						
					}
					$output .= "</ul><br>";
	return $output;
}
?>