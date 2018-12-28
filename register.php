<?php
	$title = "iMagellan Registration";
	include("includes/header.php");
	include("includes/nav.php");
?>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<!--| IF USER LOGGED IN |-->
			<?php if(isset($_SESSION['username'])) : ?>
				<?php
					$username = $_SESSION['username'];
			
					nothingToSeeHere("Ahoy, $username!", "It's time to go exploring!", "Check out the gallery now!", "gallery.php");
				?>
			 <!--| END IF USER LOGGED IN |-->

			<!--| IF USER NOT LOGGED IN |-->			
			<?php else : ?>
				<div class="header">
					<h2>Register</h2>
				</div>

				<form method="post" action="register.php">

					<?php include('includes/errors.php'); // This is for error reporting. ?>

					<div class="input-group">
						<label>Username</label>
						<input type="text" name="username" value="<?php echo $username; ?>">
					</div>
					<div class="input-group">
						<label>Email</label>
						<input type="email" name="email" value="<?php echo $email; ?>">
					</div>
					<div class="input-group">
						<label>Password</label>
						<input type="password" name="password_1">
					</div>
					<div class="input-group">
						<label>Confirm password</label>
						<input type="password" name="password_2">
					</div>
					<div class="input-group">
						<button type="submit" class="btn" name="register_user">Register</button>
					</div>
					<p>
						Already a member? <a href="login.php">Sign in</a>
					</p>
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include("includes/footer.php");?>