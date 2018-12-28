<?php $title = "Image Details"; ?>

<?php include('includes/header.php'); ?>
<?php include("includes/nav.php");?>
<div class="container">	

	<!--| IF USER LOGGED IN |-->
	<?php if (isset($_SESSION['username'])) : ?>
	
		<?php
			// db query to find user id
			$user = $_SESSION['username'];

			if (!isset($_SESSION['user_id'])) {
				$query = "SELECT * FROM users WHERE user='$user'";
				$results = mysqli_query($db, $query);

				if (mysqli_num_rows($results) == 1) {

					// find the user ID to set it for the session
					$user_row = mysqli_fetch_assoc($results);
					$uID = $user_row['uid'];
					$_SESSION['user_id'] = $uID;
				}
			} else {
				$uID = $_SESSION['user_id'];
			} 
		?>
		
		<div class="header">
			<h2>Image Details</h2>
		</div>
		<div class="content">
			<hr>
			
			<!--| FIND IMAGE BY GET PID VARIABLE |-->
			<?php if (isset($_GET['pid'])) : ?>
				<?php
					// Set variables
					$pid = $_GET['pid'];
					$display = 1;

					// db query to find list of images			
					$query = "SELECT * FROM photos WHERE pid='$pid'";
					$image_list = mysqli_query($db, $query) or die(mysqli_error());
				?>
				<?php if (mysqli_num_rows($image_list) == 1) : ?>
					<?php
						$row_image_list = mysqli_fetch_assoc($image_list);

						// Set other image variables
						$imageURL = "uploads/".$row_image_list['image_path'];
						$imageDesc = $row_image_list['title'];
						$image_user = $row_image_list['uid'];
						$cat_id = $row_image_list['cid'];
						$privacy = $row_image_list['privacy'];
					?>
					
				    <!--| Make sure only user can see private images |-->
				    <?php if ($privacy == 1 && $image_user != $uID) {
						$errMessage = "You do not have permission to view this image.";
						$display = 0;
					} ?>
			    
			    	<!--| IF NO ERRORS, SHOW IMAGE |-->
			    	<?php if ($display == 1) : ?>
						<div style="text-align: center;">
							<p><b>Uploaded into <a href="gallery.php?category=<?php echo $cat_id; ?>">
								<?php
									// Get the name of the category by cid
									$cat_query = "SELECT name FROM categories WHERE cid='$cat_id'";
									$cat_list = mysqli_query($db, $cat_query) or die(mysqli_error());
									$row_cat_list = mysqli_fetch_assoc($cat_list);
									$cat_name = $row_cat_list['name'];
									
									echo $cat_name;
								?>
							</a> by <span>
								<?php 
									// Find the username of the person who uploaded this image
									$user_query = "SELECT user FROM users WHERE uid='$image_user'";
									$image_user_list = mysqli_query($db, $user_query) or die(mysqli_error());
									$row_image_user = mysqli_fetch_assoc($image_user_list);
									$image_username = $row_image_user['user'];
								
									echo $image_username;
								?>
								</span></b></p>
								<!--| EDIT/DELETE BUTTONS |-->
								<?php if ($image_user == $uID) : ?>
									<form class="nobg padding-margin-0" action="edit.php" method="POST">
										<input type="hidden" name="pid" value="<?php echo $pid; ?>"/>
										<button type="submit" class="btn btn-sm edit-btn">Edit</button> 
									</form>
								<?php endif; ?>
									
							<img style="border:8px rgba(0,153,255,1) outset; min-width: 270px; max-width: 90%; margin-bottom: 20px;"  src="<?php echo $imageURL; ?>" height="auto" alt=""/>
							<p><?php echo $imageDesc; ?></p>
							
		    		
						</div>
			    	<?php else : ?>
			    		<p><?php echo $errMessage; ?></p>	
			    	<?php endif; ?> <!--| END SHOW IMAGE |-->
				    

				<!--| ELSE SAY THERE'S NO IMAGE |-->
				<?php else : ?>
					<?php
						nothingToSeeHere("Image Not Found", "<br>Either this image crumbled to dust or it never existed in the first place.", "Take me back to the gallery.", "gallery.php", "nobg padding-margin-0"); 
					?>
				<?php endif; ?>
			<?php endif; ?>
			
		
		</div>

		<!--| END IF USER LOGGED IN |-->

		<!--| IF USER NOT LOGGED IN |-->
		<?php else : ?>
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<?php 
				nothingToSeeHere("Please Login", "You cannot use this site feature unless you login.", "Click here to login.", "login.php"); 
				?>

			</div>

		<?php endif; ?>

	</div>
	
<?php include('includes/footer.php');?>