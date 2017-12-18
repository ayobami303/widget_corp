<?php require_once("includes/session.php") ?>
<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_login() ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php") ?>



			<div class="links"> 
				<?php echo navigation($sel_subject, $select_page); ?>
				<p><a href="new_subject.php">+ add a new subject</a></p>
			</div>

			<div class="nav">
			
			<?php
			if (!is_null($sel_subject)){
				 echo "<h2>".$sel_subject['menu_name']."</h2>";
				 ?><br>
			<?php 
			}elseif (!is_null($select_page)){
				echo "<h2>".$select_page['menu_name']."</h2>"; 
				echo "<p>".$select_page['content']."</p>" ;
				echo "<p><a href=\"edit_page.php?page=".urlencode($select_page["id"]).
									"\">Edit page</a> </p>"
				?>

			<?php
			}else{
				echo "<h2> Select a subject or page to edit </h2>";
			}	?>
			</div>
		<?php require("includes/footer.php") ?>	
		