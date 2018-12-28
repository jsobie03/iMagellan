<?php $title = "Edit Image"; ?>

<?php include('includes/header.php'); ?>
<?php include('includes/nav.php');?>
<?php include('includes/uploader.php'); ?>
<div class="container">	

	<!--| IF USER LOGGED IN |-->
	<?php if (isset($_SESSION['username'])) : ?>
	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="header">
			<h2><?php echo $title; ?></h2>
		</div>

		<form action="edit.php" method="post" enctype="multipart/form-data">

			<?php include('includes/errors.php'); // This is for error reporting. ?>

			<?php if (isset($_SESSION['editMsg'])) : ?>
			<div class="error success" >
				<?php 
				echo $_SESSION['editMsg']; 
				unset($_SESSION['editMsg']);
				?>
			</div>
			<?php endif ?>
			
			<!--| GET IMAGE DATA |-->
			<?php if (isset($_POST['pid'])) : ?>
				<?php
					// Get picture ID
					if (isset($_POST['pid'])) {
						$pid = $_POST['pid'];

						// query db for image with pid
						$query = "SELECT * FROM photos WHERE pid='$pid'";
						$photo_list = mysqli_query($db, $query);

						if (mysqli_num_rows($photo_list) == 1) {
							$photo_row = mysqli_fetch_assoc($photo_list);
							// Set other variables
							$imageURL = "uploads/".$photo_row['image_path'];
							$description = $photo_row['title'];
							$category = $photo_row['cid'];
							$userid = $photo_row['uid'];
							$privacy = $photo_row['privacy'];
						}
					} else {
						array_push($errors, "Could not find image.");
					}
				?>
				
					<div class="input-group file-upload">
						<img style="border:8px rgba(0,153,255,1) outset; min-width: 270px; max-width: 90%;"  src="<?php echo $imageURL; ?>" height="auto" alt=""/>
					</div>

					<div class="input-group">
						<label>Description</label>
						<textarea name="title" rows="3"><?php if (isset($description)) { echo $description; } ?></textarea>
					</div>

					<div class="input-group">
						<label>Select A Category</label>
						<select name="selectCategory" value="<?php echo $category; ?>">
							<option value="">Select Category</option>
							<option <?php if($category==1) echo 'selected="selected"'; ?> value="1">Abstract</option>
							<option <?php if($category==2) echo 'selected="selected"'; ?> value="2">Animal</option>
							<option <?php if($category==3) echo 'selected="selected"'; ?> value="3">Architecture</option>
							<option <?php if($category==4) echo 'selected="selected"'; ?>value="4">Black and White</option>
							<option <?php if($category==5) echo 'selected="selected"'; ?> value="5">Cityscape</option>
							<option <?php if($category==6) echo 'selected="selected"'; ?> value="6">Family</option>
							<option <?php if($category==7) echo 'selected="selected"'; ?> value="7">Fashion</option>
							<option <?php if($category==8) echo 'selected="selected"'; ?> value="8">Film</option>
							<option <?php if($category==9) echo 'selected="selected"'; ?> value="9">Fine Art</option>
							<option <?php if($category==10) echo 'selected="selected"'; ?> value="10">Food</option>
							<option <?php if($category==11) echo 'selected="selected"'; ?> value="11">Glamour</option>
							<option <?php if($category==12) echo 'selected="selected"'; ?> value="12">Humorous</option>
							<option <?php if($category==13) echo 'selected="selected"'; ?> value="13">Journalism</option>
							<option <?php if($category==14) echo 'selected="selected"'; ?> value="14">Landscape</option>
							<option <?php if($category==15) echo 'selected="selected"'; ?> value="15">Nature</option>
							<option <?php if($category==16) echo 'selected="selected"'; ?> value="16">Space</option>
						</select>
					</div>
					<div class="input-group">
						<label>Privacy</label>
					</div>

					<input type="radio" name="privacy" value="" 
					<?php if ($privacy < 1) {
							echo "checked";
						} else {
							  echo ""; }
					?>><label class="radio-label">Public</label>

					<input type="radio" name="privacy" value="1"
					<?php if ($privacy > 0) {
						echo "checked";
					} else {
						echo ""; }
					?>>
					<label class="radio-label">Private</label>
					
					<input type="hidden" name="userid" value="<?php echo $userid; ?>">
					<input type="hidden" name="pid" value="<?php echo $pid; ?>">
					<div class="clearfix"></div>
					
					<!--| UPDATE BUTTON |-->
					<div class="col-sm-6"><button class="btn update-btn" type="submit" name="edit_photo">Update</button></div>
					
					<!--| DELETE BUTTON |-->
					<div class="col-sm-6"><button class="btn delete-btn" name="delete_photo" type="submit">Delete</button></div>
					<div class="clearfix"></div>
					
				
			<?php else : ?>
				<p>Oops! Looks like something went wrong!</p>
			<?php endif; ?>
		</form>
	</div> <!--| END EDIT FORM |-->
	<!--| END IF USER LOGGED IN |-->

	<!--| IF USER NOT LOGGED IN |-->	
	<?php else : ?>
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<?php 
				nothingToSeeHere("Please Login", "You cannot use this site feature unless you login.", "Click here to login.", "login.php"); 
			?>
		</div>
	<?php endif; ?>

</div><!--| END CONTENT DIV |-->

<?php include('includes/footer.php');?>