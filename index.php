<?php require_once("includes/connect.php") ?>
<?php require_once("includes/functions.php") ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php") ?>



			<div class="links"> 
				<?php echo public_navigation($sel_subject, $select_page); ?>
				
			</div>

			<div class="nav">
			
		
			<?php 
			if(!is_null($select_page)){
				echo "<h2>".htmlentities($select_page['menu_name'])."</h2>"; 
				echo "<p>".$select_page['content']."</p>" ;
				
				?>

			<?php
			}else{
				echo "<h2>Welcome to Widget Corp </h2>";
			}	?>
			</div>
		<?php require("includes/footer.php") ?>	
		