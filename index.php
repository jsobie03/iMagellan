<?php $title = "iMagellan"; ?>

<?php include('includes/header.php'); ?>
    <?php include("includes/nav.php");?>
<div class="container">	
	
	<div class="header">
		<h1>Welcome to <img src="images/iMagellanLogo.png" alt="logo" width="400" height="auto"/></h1>
		<h3 class="subtitle">Explore a whole new world of images.</h3>
	</div>
	<div class="content">
		<hr>
		<!--| IF USER LOGGED IN |-->
		<?php if (isset($_SESSION['username'])) : ?>
			
			<h2>Most Recent Uploads</h2>

			<?php // db query to find list of images
				$query = "SELECT * FROM photos WHERE privacy<1 ORDER BY pid DESC LIMIT 6";
				$image_list = mysqli_query($db, $query) or die(mysqli_error());
				$row_image_list = mysqli_fetch_assoc($image_list);
				$totalrows_image_list = mysqli_num_rows($image_list);
			?>
			<!--| LIST THE QUERY RESULTS |-->
			<?php if (mysqli_num_rows($image_list) >= 1) : ?>
				<div class="row profile-container" style="text-align: center; padding: 20px;">
					<?php do { ?>

					<?php 
						$imageURL = "uploads/".$row_image_list['image_path'];
						$imageDesc = $row_image_list['title'];
						$image_id = $row_image_list['pid'];
						$image_user = $row_image_list['uid'];
					?>

					<div class="col-lg 3 col-md-4 col-sm-6" style="display:inline-block;" data-mh="gallery-pic">
						<a href="<?php echo 'image.php?pid='.$image_id; ?>" data-fancybox="group" data-caption="<?php echo $imageDesc; ?>">
							<img style="border:8px rgba(0,153,255,1) outset; min-width: 270px; max-width: 90%;"  src="<?php echo $imageURL; ?>" height="auto" alt=""/>
							<p><?php echo $imageDesc; ?></p>
						</a>
					</div> 
					<?php } while ($row_image_list = mysqli_fetch_assoc($image_list)); ?> 
					
					<div class="galleries col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
						<button class="btn"><a href="gallery.php">Discover More!</a></button>
					</div>
				</div> <!--| END IF PICTURES ON PAGE |-->

			<!--| IF THERE ARE NO PICTURES ON THE PAGE |-->
			<?php else : ?>
				<h2>Oops! Looks like there's nothing here!</h2>
				<p>There are no images on this page.</p>
				<p><a href="upload.php">Kick it off by uploading something!</a></p>

			<?php endif; ?> <!--| END ALL IMAGES QUERY RESULTS |-->
			
		<!--| END IF USER LOGGED IN |-->
		
		<!--| IF USER NOT LOGGED IN |-->
		<?php else : ?>
				<?php 
					nothingToSeeHere("Please Login", "You cannot use this site feature unless you login.", "Click here to login.", "login.php", "nobg"); 
				?>

		<?php endif; ?>
		
	</div><!--| END CONTENT DIV |-->
	
</div>	
<?php include('includes/footer.php');?>