<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>

<?php 

if (intval($_GET['subj']) == 0) {
	redirect("content.php");
}

if (isset($_POST['submit'])){
	
	$error= array();
	$required  = array('menu_name','position','visible' );
	foreach ($required as $required_value ) {
		if (!isset($_POST[$required_value]) || (empty($_POST[$required_value]) && $_POST[$required_value] != 0)){
			$error[]=$required_value;
			
		}
	}
	if (empty($_POST['menu_name'])) {
		$error[] = 'menu_name';
	}
	$field_with_length = array('menu_name' => 30 );
	foreach ($field_with_length as $fieldname => $maxlength) {
		if (strlen(trim(mysql_prep($_POST[$fieldname])))> $maxlength) {
			$error[] = $fieldname;
		}
	}
	

	if (empty($error)){
		$id = mysql_prep($_GET['subj']); 
		
		$menu_name = mysql_prep($_POST['menu_name']);
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);

		$query_up = "UPDATE subjects SET 
							menu_name = '{$menu_name}', 
							position = {$position}, 
							visible = {$visible} 
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
				<h2>Edit Subject: <?php echo $sel_subject['menu_name'];?></h2>
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
				<form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" method="post">
					<p><label>Subject Name:</label>
					<input type="text" name="menu_name" value="<?php echo $sel_subject['menu_name']; ?>"></p>
					
					<p><label>position:</label>
					<select name="position">
						<optgroup>
						<?php 
							$result_set= get_all_subject();
							$subject_count = mysql_num_rows($result_set);
							for ($count=1; $count <= $subject_count+1; $count++) { 
								echo "<option value=\"".$count."\""; 
								if ($sel_subject['position']==$count){
									echo " selected ";
								}
								echo ">".$count."</option>";
							}
						?>
							
						</optgroup>
					</select></p>
					
					<p><label>visible:</label>
					<?php 
					if($sel_subject['visible']==1){
						echo '<input type="radio" name="visible" value="1" checked="yes"><label>yes</label>';
						echo '<input type="radio" name="visible" value="0"><label>No</label>';
					}else{
						echo '<input type="radio" name="visible" value="1" ><label>yes</label>';
						echo '<input type="radio" name="visible" value="0" checked="yes"><label>No</label>';
					}

					?>
					</p>
					<input type="submit" name ="submit" value="Edit Subject">
					&nbsp
					&nbsp
					<a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']) ?>" onCLick="return confirm('Are you sure?')"> Delete </a>
				</form>
				<p><a href="content.php">cancel</a></p>

				<hr>
				<p>Pages in this subject:</p>
				<ul>
				<?php 
				$pages_array = get_all_pages($sel_subject['id']);
				while ($page=  mysql_fetch_array($pages_array)) {
				 	echo "<li> <a href=\"content.php?page=".urlencode($page["id"]). " \">{$page['menu_name']} </a></li>";
				 } 
				?>
					
				</ul>

				<p><a href="new_page.php?subj=<?php echo urlencode($sel_subject['id']) ?> "> + add new page </a> </p>
			</div>
			
		<?php require("includes/footer.php") ?>	
		