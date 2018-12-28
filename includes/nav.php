<header>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php" title="SnagThat Home" target="_self"><img src="images/iMagellanLogo.png" alt="iMagellan Logo" width="150" align="middle"/></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<div class="navspacer hidden-xs"></div>
				<ul class="nav navbar-nav">
					<li><a href="gallery.php" title="My Gallery">Gallery</a></li>
					<li><a href="upload.php" title="Upload Images">Upload</a></li>
					<!--| GENERATE ADMIN PANEL LINK IF USER IS AN ADMINISTRATOR |-->
					<?php if (isset($_SESSION['username'])) : ?>
						<?php if ((isset($_SESSION['user_type'])) && $_SESSION['user_type'] == 2) : ?>
							<li><a href="admin.php">Admin Panel</a></li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<!-- Check if a user is logged in -->
					<?php  if (isset($_SESSION['username'])) : ?>

					<!-- If user logged in, display Username and Logout button -->
					<li><a href="profile.php" title="Profile"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username']; ?></a></li>
					<li><a href="index.php?logout='1'" title="Logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a> </li>

					<!-- Otherwise, display Sign Up and Login buttons -->
					<?php else : ?>
					<li><a href="register.php" title="Sign Up" target="_self"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
					<li><a href="login.php" title="Login" target="_self"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

					<?php endif ?>  

				</ul>
			</div>
		</div>
	</nav>
	<!---------------| MOBILE/TABLET NAVIGATION |-------------->
	
	
</header>