<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php") ?>

<?php
if (isset($_POST['submit'])) {
	$subject_id = mysql_prep($_GET['subj']);
	$menu_name = mysql_prep($_POST['menu_name']);
	$position = mysql_prep($_POST['position']);
	$visible = mysql_prep($_POST['visible']);
	$content = mysql_prep($_POST['content']);

	$required  = array('menu_name','position','visible','content' );
	foreach ($required as $required_value ) {
		if (!isset($_POST[$required_value]) || (empty($_POST[$required_value]) && $_POST[$required_value] != 0)){
			$error[]=$required_value;
		}
	}
	if (empty($_POST['menu_name'])) {
			$error[] = 'menu_name';
		}
		if (empty($_POST['content'])) {
			$error[] = 'content';
		}

	if (empty($error)){
		$insert_query = "INSERT INTO pages (subject_id,menu_name,position,visible,content) 
					VALUES ({$subject_id},'{$menu_name}','{$position}','{$visible}', '{$content}')";
		$mysql_insert = mysql_query($insert_query);				
		if ($mysql_insert)				{
			redirect('content.php');
		}else{
			$messge = "unsuccessful".mysql_error();
		}
		
	}else{
		$message = "There were errors in the form";
	}
}



?>


<div class="links"> 
	<?php echo navigation($sel_subject, $select_page); ?>
					
</div>

<div class="nav">
<h2>Add Page</h2>
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
	<form action="new_page.php?subj=<?php echo urlencode($_GET['subj']);?>" method="post">
	<p><label>Page Name:</label>
	<input type="text" name="menu_name" ></p>

	<p><label>position:</label>
	<select name="position">
		<optgroup>
		
		<?php 
			$result_set= get_all_pages($_GET['subj']);
			$page_count = mysql_num_rows($result_set);
			for ($count=1; $count <= $page_count+1; $count++) { 
				echo "<option value=\"".$count."\""; 
				
				echo " >".$count."</option>";
			}
		?>
			
		</optgroup>
	</select></p>

	<p><label>visible:</label>
	<input type="radio" name="visible" value="1" checked="yes"><label>yes</label>
	<input type="radio" name="visible" value="0" ><label>No</label>
	
	</p>

	<p><label>Content:</label> <textarea name="content" rows="15" cols="80"></textarea>  </p>
	<input type="submit" name ="submit" value="Add page">
	<p><a href="content.php">cancel</a></p>
	
	</form>
</div>
			
<?php require("includes/footer.php") ?>	