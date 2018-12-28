<?php session_start();
	include('includes/server.php');
	include('includes/nothing.php');?>

<?php
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
}?>
    <!-- +---------------------------------------------+
     |                                             |
     |        WEB 2310 FINAL GROUP PROJECT         |
     |                                             |
     |        COLLEEN BERNUM, HALEY LEWIS,         |
     |              JONATHAN SOBIER                |
     |                                             |
     |                 IMAGELLAN                   |
     |                                             |
     +---------------------------------------------+ -->


<!---------------| PHP Includes |--------------->

<!DOCTYPE html>
<html lang="en">

<head>

	<!---------------| Title of Page |--------------->
	<!--| Set variable above header include on page |-->
	<title>
		<?php echo $title; ?>
	</title>
	
	<link rel="shortcut icon" href="images/iMagellanLens.png" />
	
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />

	<!---------------| CSS Includes |--------------->
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />

	<!---------------| Font Includes |--------------->
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!---------------| JavaScript Includes |--------------->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
