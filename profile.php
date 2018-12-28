<?php
	$title = "My Profile";
	include "includes/header.php";
	
	if (isset($_SESSION['username'])) {
		$new_user = $_SESSION['username'];
		$new_email = $_SESSION['email'];
	}
?>

<?php include "includes/nav.php"; ?>

<div class="container">

	<!--| IF USER LOGGED IN |-->
	<?php if (isset($_SESSION['username'])) : ?>
	<div class="header">
		<h1><?php echo $title; ?></h1>
		<h2>Ahoy, <?php echo $_SESSION["username"]; ?>!</h2>
	</div>
	<div class="content">
	<hr>
		<!--| Left Side Column |-->
		<div class="col-sm-6 col-xs-12 profile-container">
			<h2 class="profile-bold-blue">My Details</h2>
			
			<!--| User Details |-->
			<div class="align-left" style="margin-bottom: 40px;">
				<h4 class="profile-bold">Username:</h4>
				<?php echo $_SESSION["username"]; ?>
				<br><br>
				<h4 class="profile-bold">E-mail address:</h4>
				<?php echo $_SESSION["email"]; ?>
			</div>
			<hr>
			<!--| Update Form |-->
			<div class="profile-container">
				<h2 class="profile-bold-blue">Update My Info</h2>
				<div class="update-form">
					<form method="post" action="profile.php">

						<?php include('includes/errors.php'); // This is for error reporting. ?>

						<div class="input-group">
							<label>Username</label>
							<input type="text" name="new_user" value="<?php echo $new_user; ?>">
						</div>
						<div class="input-group">
							<label>Email</label>
							<input type="email" name="new_email" value="<?php echo $new_email; ?>">
						</div>
						<div class="input-group">
							<label>New password</label>
							<input type="password" name="new_password_1">
						</div>
						<div class="input-group">
							<label>Confirm new password</label>
							<input type="password" name="new_password_2">
						</div>
						<div class="input-group">
							<label>Current Password</label>
							<input type="password" name="password">
						</div>
						<div class="input-group">
							<button type="submit" class="btn" name="update_user">Update</button>
						</div>
					</form>
				</div>
			</div>
			<hr class="visible-xs">
	
		</div> <!--| End Left Side Column |-->
		
		<!--| Right Side Column |-->
		<div class="col-sm-6 col-xs-12 profile-container">
		
			<!--| User Details |-->
			<div class="galleries" style="margin-bottom: 40px;">
				<h2 class="profile-bold-blue">My Galleries</h2>
				<div class="col-sm-offset-0 col-xs-6 col-xs-offset-3">
					<button class="btn"><a href="gallery.php?public=1">Public</a></button>
				</div>
				<div class="col-sm-offset-0 col-xs-6 col-xs-offset-3">
					<button class="btn"><a href="gallery.php?private=1">Private</a></button>
				</div>
				<div class="col-sm-12 col-sm-offset-0 col-xs-6 col-xs-offset-3">
					<button class="btn"><a href="gallery.php?userimages=1">All</a></button>
				</div>
				<div class="clearfix"></div>
			</div>
			<hr>
			<div class="profile-container">
				<h2 class="profile-bold-blue"> My Most Recent Uploads</h2>
				
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
					
					// db query to find last 3 images uploaded
					$query = "SELECT * FROM photos WHERE uid='$uID' ORDER BY pid DESC LIMIT 3";
					$image_list = mysqli_query($db, $query) or die(mysqli_error());
					$row_image_list = mysqli_fetch_assoc($image_list);
				?>
				
				<!--| SHOW IMAGES |-->
				<?php if (mysqli_num_rows($image_list) >= 1) : ?>
				<div class="row" style="text-align: center; padding: 20px; margin-top: 30px;">
					<?php do { ?>

					<?php 
						$imageURL = "uploads/".$row_image_list['image_path'];
						$imageDesc = $row_image_list['title'];
						$image_id = $row_image_list['pid'];
						$image_user = $row_image_list['uid'];
					?>

					<div style="display:inline-block;" data-mh="gallery-pic">
						<a href="<?php echo 'image.php?pid='.$image_id; ?>" data-fancybox="group" data-caption="<?php echo $imageDesc; ?>">
							<img style="border:8px rgba(0,153,255,1) outset; min-width: 270px; max-width: 70%;"  src="<?php echo $imageURL; ?>" height="auto" alt=""/>
							<p><?php echo $imageDesc; ?></p>
						</a>
					</div> 
					<?php } while ($row_image_list = mysqli_fetch_assoc($image_list)); ?> 
				</div> <!--| END IF PICTURES ON PAGE |-->

				<!--| IF THERE ARE NO PICTURES ON THE PAGE |-->
				<?php else : ?>
					<?php 
						nothingToSeeHere("Oops! Looks like there's nothing here!", "There are no images on this page.", "Kick it off by uploading something!", "upload.php", "nobg"); 
					?>
				<?php endif; ?> <!--| END QUERY RESULTS |-->
			</div>
		
		</div>
		
		<!--| Fix for float |-->
		<div class="clearfix"></div>
		
	</div> <!--| END IF USER LOGGED IN |-->
	
	<!--| IF USER NOT LOGGED IN |-->
	<?php else : ?>
	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<?php 
			nothingToSeeHere("Please Login", "You cannot use this site feature unless you login.", "Click here to login.", "login.php"); 
		?>
		
	</div>

	<?php endif; ?>
</div>
<?php include "includes/footer.php"; ?>
