<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php") ?>



			<div class="links"> 
				<?php echo navigation($sel_subject, $select_page); ?>
					
			</div>

			<div class="nav">
				<h2>Add new Subject</h2>
				<form action="create_subject.php" method="get">
					<p><label>Subject Name:</label>
					<input type="text" name="menu_name"></p>
					
					<p><label>position:</label>
					<select name="position">
						<optgroup>
						<?php 
							$result_set= get_all_subject();
							$subject_count = mysql_num_rows($result_set);
							for ($count=1; $count <= $subject_count+1; $count++) { 
								echo "<option value=\"".$count."\">".$count."</option>";
							}
						?>
							
						</optgroup>
					</select></p>
					
					<p><label>visible:</label>
					<input type="radio" name="visible" value="1"><label>yes</label>
					<input type="radio" name="visible" value="0"><label>No</label></p>
					<input type="submit" value="Add Subject">
				</form>
				<p><a href="content.php">cancel</a></p>
			</div>
			
		<?php require("includes/footer.php") ?>	
		