<?php 
	include("includes/db.php");
	// Gallery specific header

	// Determine whether the title is for the public or private gallery
	
	if ($_GET) {
		
		if (isset($_GET['category'])) {
			$cID = $_GET['category'];
			$query = "SELECT * FROM categories WHERE cid='$cID'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {

				// find the category name
				$category_row = mysqli_fetch_assoc($results);
				$category_name = $category_row['name'];
				$title = "iMagellan: " . $category_name;
			
			
				if (isset($_GET['private'])) {
					$private = $_GET['private'];

					if ($private == 1) {
						$title = "My Private Gallery: " . $category_name;
					} 
				} elseif (isset($_GET['public'])) {
					$public = $_GET['public'];

					if ($public == 1) {
						$title = "My Public Gallery: " . $category_name;
					} 
				} 

				if (isset($_GET['userimages'])) {
					$title = "My Gallery: " . $category_name;
				} 
			}

		} elseif (isset($_GET['private'])) {
			$private = $_GET['private'];
			
			if ($private == 1) {
				$title = "My Private Gallery";
			}
		} elseif (isset($_GET['public'])) {
			$public = $_GET['public'];

			if ($public == 1) {
				$title = "My Public Gallery";
			}
		} elseif (isset($_GET['userimages'])) {
			$title = "My Gallery";
		}
	} else {
		$title = "iMagellan Gallery";
	}
?>
<?php include("includes/header.php"); ?>
<?php include 'includes/nav.php';?>


<div class="container">

	<!--| IF USER IS LOGGED IN |-->
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
			<h1><?php echo $title; ?></h1>
			<h2><img src="images/iMagellanLogo.png" alt="logo" width="400" height="auto"/> Categories</h2>
			<!--| CATEGORY LISTING |-->
			<?php
				// db query to find category list
				$query = "SELECT * FROM categories ORDER BY name ASC";
				$category_list = mysqli_query($db, $query) or die(mysqli_error());

				// find the category name
				$row_category_list = mysqli_fetch_assoc($category_list);

			?>

			<?php if (mysqli_num_rows($category_list) >= 1) : ?>			
				<div class="row" style="text-align: center; padding: 20px;">
					<?php do { ?>

					<?php 
						$category_name = $row_category_list['name'];
						$cID = $row_category_list['cID'];	

						// Add category id to url
						$cat_url = "gallery.php";	
						
						if (isset($_GET['private'])) {
							$cat_url .= '?private=1&category=' . $cID;
						} elseif (isset($_GET['public'])) {
							$cat_url .= '?public=1&category=' . $cID;
						} elseif (isset($_GET['userimages'])) {
							$cat_url .= '?userimages=1&category=' . $cID;
						} else {
							$cat_url .= '?category=' . $cID;
						} 
					?>

					<div class="category" style="display:inline-block;">
						<a href="<?php echo $cat_url; ?>">
							<?php echo $category_name; ?>
						</a>
					</div> 
					<?php } while ($row_category_list = mysqli_fetch_assoc($category_list)); ?> 
				</div>
                <a href="gallery.php">ALL IMAGES</a> <br/>
			<?php endif; ?> <!--| END CATEGORY LISTING |-->
		</div>
		<hr style="padding: 0; margin:0;">
		<div class="content" style="padding-top: 40px;">

			<!--| IF USER IS VIEWING OWN GALLERY OR CATEGORIES |-->
			<?php if (isset($_GET)) : ?>

				<!--| CATEGORIES |-->
				<?php if (isset($_GET['category'])) : ?>
					<?php 
						$category = $_GET['category'];
						
						if (isset($_GET['public'])) {
							// db query for public user gallery
							$query = "SELECT * FROM photos WHERE cid='$category' AND uid='$uID' AND privacy<1 ORDER BY pid DESC";	
						} elseif (isset($_GET['private'])) {
							// db query for private gallery
							$query = "SELECT * FROM photos WHERE cid='$category' AND privacy>0 ORDER BY pid DESC";
						} elseif (isset($_GET['userimages'])) {
							// db query for category in user images
							$query = "SELECT * FROM photos WHERE cid='$category' AND uid='$uID' ORDER BY pid DESC";
						} else {
							// db query for public category
							$query = "SELECT * FROM photos WHERE cid='$category' AND privacy<1 ORDER BY pid DESC";
						}
						
						// run the query
						$image_list = mysqli_query($db, $query) or die(mysqli_error());
						$row_image_list = mysqli_fetch_assoc($image_list);	
					?>

					<!--| LIST THE QUERY RESULTS |-->
					<?php if (mysqli_num_rows($image_list) >= 1) : ?>
						<div class="row" style="text-align: center; padding: 20px;">
							<?php do { ?>

							<?php 
								// set some image variables
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
						</div> <!--| END IF PICTURES ON PAGE |-->

					<!--| IF THERE ARE NO PICTURES ON THE PAGE |-->
					<?php else : ?>
						<?php 
							nothingToSeeHere("Oops! Looks like there's nothing here!", "There are no images on this page.", "Kick it off by uploading something!", "upload.php", "nobg padding-margin-0");
						?>
					<?php endif; ?> <!--| END CATEGORIES QUERY RESULTS |-->

				<!--| PRIVATE IMAGES |-->
				<?php elseif (isset($_GET['private'])) : ?>
					<?php 
						// db query
						$query = "SELECT * FROM photos WHERE uid='$uID' AND privacy>0 ORDER BY pid DESC";
						$image_list = mysqli_query($db, $query) or die(mysqli_error());
						$row_image_list = mysqli_fetch_assoc($image_list);
					?>

					<!--| LIST THE QUERY RESULTS |-->
					<?php if (mysqli_num_rows($image_list) >= 1) : ?>
						<div class="row" style="text-align: center; padding: 20px;">
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
						</div> <!--| END IF PICTURES ON PAGE |-->

					<!--| IF THERE ARE NO PICTURES ON THE PAGE |-->
					<?php else : ?>
						<?php 
							nothingToSeeHere("Oops! Looks like there's nothing here!", "There are no images on this page.", "Kick it off by uploading something!", "upload.php", "nobg padding-margin-0");
						?>
					<?php endif; ?> <!--| END PRIVATE IMAGES QUERY RESULTS |-->
					
				<!--| PUBLIC IMAGES |-->
				<?php elseif (isset($_GET['public'])) : ?>
				<?php 
				// db query
				$query = "SELECT * FROM photos WHERE uid='$uID' AND privacy<1 ORDER BY pid DESC";
				$image_list = mysqli_query($db, $query) or die(mysqli_error());
				$row_image_list = mysqli_fetch_assoc($image_list);
				?>

				<!--| LIST THE QUERY RESULTS |-->
				<?php if (mysqli_num_rows($image_list) >= 1) : ?>
				<div class="row" style="text-align: center; padding: 20px;">
					<?php do { ?>

					<?php 
						$imageURL = "uploads/".$row_image_list['image_path'];
						$imageDesc = $row_image_list['title'];
						$image_id = $row_image_list['pid'];
						$image_user = $row_image_list['uid'];
					?>

					<div class="col-lg 3 col-md-4 col-sm-6" style="display:inline-block;" data-mh="gallery-pic">
						<a href="<?php 'image.php?pid='.$image_id; ?>" data-fancybox="group" data-caption="<?php echo $imageDesc; ?>">
							<img style="border:8px rgba(0,153,255,1) outset; min-width: 270px; max-width: 90%;"  src="<?php echo $imageURL; ?>" height="auto" alt=""/>
							<p><?php echo $imageDesc; ?></p>
						</a>
					</div> 
					<?php } while ($row_image_list = mysqli_fetch_assoc($image_list)); ?> 
				</div> <!--| END IF PICTURES ON PAGE |-->

				<!--| IF THERE ARE NO PICTURES ON THE PAGE |-->
				<?php else : ?>
					<?php 
						nothingToSeeHere("Oops! Looks like there's nothing here!", "There are no images on this page.", "Kick it off by uploading something!", "upload.php", "nobg padding-margin-0");
					?>
				<?php endif; ?> <!--| END PRIVATE IMAGES QUERY RESULTS |-->

				<!--| PUBLIC AND PRIVATE IMAGES |-->
				<?php elseif (isset($_GET['userimages'])) :?>
					<?php
						$query = "SELECT * FROM photos WHERE uid='$uID' ORDER BY pid DESC";
						$image_list = mysqli_query($db, $query) or die(mysqli_error());
						$row_image_list = mysqli_fetch_assoc($image_list);
						$totalrows_image_list = mysqli_num_rows($image_list);
					?>

					<!--| LIST THE QUERY RESULTS |-->
					<?php if (mysqli_num_rows($image_list) >= 1) : ?>			
						<div class="row" style="text-align: center; padding: 20px;">
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
						</div> <!--| END IF PICTURES ON PAGE |-->

					<!--| IF THERE ARE NO PICTURES ON THE PAGE |-->
					<?php else : ?>
						<?php 
							nothingToSeeHere("Oops! Looks like there's nothing here!", "There are no images on this page.", "Kick it off by uploading something!", "upload.php", "nobg padding-margin-0");
						?>
					<?php endif; ?> <!-- END PUBLIC AND PRIVATE IMAGES |--> 				

				<!--| ALL PUBLIC IMAGES ON THE SITE |-->
				<?php else : ?> 
					<?php // db query to find list of images
						$query = "SELECT * FROM photos WHERE privacy<1 ORDER BY pid DESC";
						$image_list = mysqli_query($db, $query) or die(mysqli_error());
						$row_image_list = mysqli_fetch_assoc($image_list);
						$totalrows_image_list = mysqli_num_rows($image_list);
					?>
					<!--| LIST THE QUERY RESULTS |-->
					<?php if (mysqli_num_rows($image_list) >= 1) : ?>
						<div class="row" style="text-align: center; padding: 20px;">
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
						</div> <!--| END IF PICTURES ON PAGE |-->

					<!--| IF THERE ARE NO PICTURES ON THE PAGE |-->
					<?php else : ?>
						<?php 
							nothingToSeeHere("Oops! Looks like there's nothing here!", "There are no images on this page.", "Kick it off by uploading something!", "upload.php", "nobg padding-margin-0");
						?>

					<?php endif; ?> <!--| END ALL IMAGES QUERY RESULTS |-->

				<?php endif; ?> <!--| END ALL PUBLIC IMAGES |-->
			
			<?php endif; ?>

		</div>

		<!--| IF USER NOT LOGGED IN |-->
		<?php else : ?>
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<?php 
					nothingToSeeHere("Please Login", "You cannot use this site feature unless you login.", "Click here to login.", "login.php"); 
				?>
			</div>

		<?php endif; ?>

	</div>

<?php include("includes/footer.php"); ?>
