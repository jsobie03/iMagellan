<?php $title = "iMagellan Image Upload"; ?>
<?php include 'includes/header.php';?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/uploader.php'; ?>

<div class="container">
	<div class="row">
		<?php if (isset($_SESSION['username'])) : ?>
		<!---------------| BEGIN PAGE CONTENT |--------------->
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="header">
				<h2>Upload Image</h2>
			</div>

			<form action="upload.php" method="post" enctype="multipart/form-data">
				
				<?php include('includes/errors.php'); // This is for error reporting. ?>
				
				<?php if (isset($_SESSION['uploadMsg'])) : ?>
				<div class="error success" >
						<?php 
						echo $_SESSION['uploadMsg']; 
						unset($_SESSION['uploadMsg']);
						?>
				</div>
				<?php endif ?>

				<div class="input-group file-upload">
					<label>Choose Your Image</label>
					<div class="file-select">
						<div class="file-select-button" id="fileName">Choose File</div>
						<div class="file-select-name" id="noFile">No file chosen...</div>
						<input type="file" name="chooseFile" id="chooseFile">
					</div>
				</div>

				<div class="input-group">
					<label>Description</label>
					<textarea name="title" placeholder="Enter Description" rows="3"></textarea>
				</div>

				<div class="input-group">
					<label>Select A Category</label>
					<select name="selectCategory">
						<option value="">Select Category</option>
						<option value="1">Abstract</option>
						<option value="2">Architecture</option>
						<option value="3">Art</option>
						<option value="4">Backgrounds</option>
						<option value="5">Black & White</option>
						<option value="6">Christmas</option>
						<option value="7">Cities</option>
						<option value="8">Colors</option>
						<option value="9">Cultures</option>
						<option value="10">Entertainment & Celebrity</option>
						<option value="11">Fashion & Style</option>
						<option value="12">Food</option>
						<option value="13">Historical</option>
						<option value="14">Lifestyle</option>
						<option value="15">News</option>
						<option value="16">Love</option>
                        <option value="17">Music</option>
						<option value="18">Pets</option>
						<option value="19">Science</option>
						<option value="20">Sports</option>
						<option value="21">Fitness</option>
						<option value="22">Still Life</option>
						<option value="23">Transportation</option>
						<option value="24">Travel</option>
						<option value="25">Wildlife</option>
						<option value="26">Men</option>
                        <option value="27">Women</option>
						<option value="28">Wonders of the World</option>
						<option value="29">Weather to the Extreme</option>
						<option value="30">Uncategorized</option>
					</select>
				</div>
				<div class="input-group">
					<label>Privacy</label>
				</div>
					
					<input type="radio" name="privacy" value="" checked><label class="radio-label">Public</label>
					
					<input type="radio" name="privacy" value="1">
					<label class="radio-label">Private</label>
					<div class="clearfix"></div>
					

				<button class="btn" type="submit" name="submitform">Upload</button>
			</form>
		</div> <!--| END PAGE CONTENT |-->
		
		<!--| IF USER NOT LOGGED IN |-->
		<?php else : ?>
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<?php 
				nothingToSeeHere("Please Login", "You cannot use this site feature unless you login.", "Click here to login.", "login.php"); 
			?>
		</div>
		
		<?php endif; ?>
	</div>
</div>
<?php include 'includes/footer.php';?>
