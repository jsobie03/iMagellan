<?php $title = "iMagellan Admin Panel"; ?>

<?php include('includes/header.php'); ?>
<?php include("includes/nav.php");?>
<div class="container">	

		<!--| IF USER LOGGED IN |-->
		<?php if (isset($_SESSION['username'])) : ?>

			<!--| IF USER IS AN ADMIN |-->
			<?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) :?>
			
				<div class="header">
					<h1>iMagellan Admin Panel</h1>
					<hr class="padding-margin-0">
				</div>
				<div class="content">
					<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
					<br>
					<p>We've determined that you're an administrator and can view this page. Good for you!</p>
				</div>
			<!--| END IF USER IS AN ADMIN |-->
			
			<!--| IF NOT AN ADMIN |-->
			<?php else : ?>
				<?php 
					nothingToSeeHere("You're not in the club!", "You cannot use this site feature unless you are logged in as an admin."); 
				?>
			<?php endif; ?> <!--| END IF USER LOGGED IN |-->
		
		<!--| IF USER NOT LOGGED IN |-->	
		<?php else : ?>
			<?php 
				nothingToSeeHere("Please Login", "You cannot use this site feature unless you login.", "Click here to login.", "login.php"); 
			?>
		<?php endif; ?>

</div><!--| END CONTAINER DIV |-->
	
<?php include('includes/footer.php');?>