<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>
<?php 

if (intval($_GET['page']) == 0) {
	redirect("content.php");
}

if (isset($_POST['submit'])){
	
	$error= array();
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

	$field_with_length = array('menu_name' => 30 );
	foreach ($field_with_length as $fieldname => $maxlength) {
		if (strlen(trim(mysql_prep($_POST[$fieldname])))> $maxlength) {
			$error[] = $fieldname;
		}
	}
	

	if (empty($error)){
		$id = mysql_prep($_GET['page']); 
		
		$menu_name = mysql_prep($_POST['menu_name']);
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		$content = mysql_prep($_POST['content']);

		$query_up = "UPDATE pages SET 
							menu_name = '{$menu_name}', 
							position = {$position}, 
							visible = {$visible},
							content = '{$content}' 
						WHERE id = {$id}";
		$update_query = mysql_query($query_up);
		if($update_query){
			
		}else{
			 mysql_error();
		}
		
		if (mysql_affected_rows()==1){
			//successful
			$message = "successful updated";	
		}else{
			//failed
			$message = "update failed";
			$message .= "</br>" . mysql_error();
		}
	}else{
		$message= "There were " . count($error) . " error(s) in the form" ;	
	}
}//end: if (isset($_GET['submit']))

?>


<?php find_selected_page(); ?>
<?php include("includes/header.php") ?>
<div class="links"> 
				<?php echo navigation($sel_subject, $select_page); ?>
					
			</div>

			<div class="nav">
				<h2>Edit Page: <?php echo $select_page['menu_name'];?></h2>
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
				<form action="edit_page.php?page=<?php echo urlencode($select_page['id']);?>" method="post">
					<p><label>Page Name:</label>
					<input type="text" name="menu_name" value="<?php echo $select_page['menu_name']; ?>"></p>
					
					<p><label>position:</label>
					<select name="position">
						<optgroup>
						<?php 
							$result_set= get_all_pages($select_page["subject_id"]);
							$page_count = mysql_num_rows($result_set);
							for ($count=1; $count <= $page_count+1; $count++) { 
								echo "<option value=\"".$count."\""; 
								if ($select_page['position']==$count){
									echo " selected ";
								}
								echo ">".$count."</option>";
							}
						?>
							
						</optgroup>
					</select></p>
					
					<p><label>visible:</label>
					<?php 
					if($select_page['visible']==1){
						echo '<input type="radio" name="visible" value="1" checked="yes"><label>yes</label>';
						echo '<input type="radio" name="visible" value="0"><label>No</label>';
					}else{
						echo '<input type="radio" name="visible" value="1" ><label>yes</label>';
						echo '<input type="radio" name="visible" value="0" checked="yes"><label>No</label>';
					}

					?>
					</p>

					<p><label>Content:</label> <textarea name="content" rows="15" cols="80"><?php echo $select_page["content"] ?> </textarea>  </p>
					<input type="submit" name ="submit" value="update page">
					&nbsp
					&nbsp
					<a href="delete_page.php?page=<?php echo urlencode($select_page['id']) ?>" onCLick="return confirm('Are you sure?')"> Delete </a>
				</form>
				<p><a href="content.php">cancel</a></p>

			</div>

<?php require("includes/footer.php") ?>