<?php $title = "iMagellan Login"; ?>
<?php include('includes/header.php');?>
<?php include('includes/nav.php');?>

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
					<h2>Login</h2>
				</div>
				
				<form method="post" action="login.php">

					<?php include('includes/errors.php'); // This is for error reporting. ?>

					<div class="input-group">
						<label>Email</label>
						<input type="email" name="email" >
					</div>
					<div class="input-group">
						<label>Password</label>
						<input type="password" name="password">
					</div>
					<div class="input-group">
						<button type="submit" class="btn" name="login_user">Login</button>
					</div>
					<span>
						New User? <a href="register.php">Sign up!</a>
					</span>
				</form>
				
			<?php endif; ?>

		</div>
	</div>
</div>

<?php include('includes/footer.php');?>
