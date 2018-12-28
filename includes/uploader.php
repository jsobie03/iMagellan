<?php

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";
	$privacy = "";


// database connection variables
	$db_host = "www.jonsobier.com";
	$db_user = "jsobieze_jsobier";
	$db_pass = "Bak3rFina1";
	$db_name = "jsobieze_imagellan";

	// connect to database
	$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

	// UPLOAD IMAGE
	if(isset($_POST['submitform'])){

		// Get User ID
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
		
		// Set other variables
		$dir='uploads/';
		$title = $_POST['title'];
		$cat = $_POST['selectCategory'];
		$image = $_FILES['chooseFile']['name'];
		$imageFileType = pathinfo($image,PATHINFO_EXTENSION);
		$temp_name = $_FILES['chooseFile']['tmp_name'];
		$privacy = $_POST['privacy']; 
		
		// Check to make sure something is selected
		if($image == "") { array_push($errors, "Please select a file"); }

		// Check to make sure description is not empty
		if (empty($title)) { array_push($errors, "Please enter a description");	}
		
		// Check to make sure a category is selected
		if (empty($cat)) { array_push($errors, "Please select a category");	}
		
		// Make sure privacy is correct
		if ($privacy != 1) {
			$privacy = NULL;
		}
		
		// Check to see if image is a real or fake image
		$check = getimagesize($_FILES["chooseFile"]["tmp_name"]);
		if($check != false) {
			$image_upload_message = "File is an image - " . $check["mime"] . ".";
		} else { array_push($errors, "Only images are allowed."); }

		// Only allow certain file formats
		$imageFileType = strtolower($imageFileType);

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			array_push($errors, "Only JPG, JPEG, PNG & GIF files are allowed.");
		}
		
		// Make sure filename is not already in use
		$sql_photo = "SELECT * FROM photos WHERE image_path='$image'";
		$res_photo = mysqli_query($db, $sql_photo);
		if (mysqli_num_rows($res_photo) > 0) { array_push($errors, "Filename already exists, please rename your file"); }
		
		
		// Upload picture if no errors
		if (count($errors) == 0) {
			$target_image = $dir.$image;
			
			move_uploaded_file($temp_name, $target_image);
			$query="INSERT INTO photos (title,image_path,uid,cid,privacy) values ('$title', '$image', '$uID', '$cat', '$privacy')";
			mysqli_query($db,$query);


			// Set session variables
			$private = "";
			if (!empty($privacy)) {
				$private = "?private=1";
			} 

			$_SESSION['uploadMsg'] = basename( $_FILES["chooseFile"]["name"]) . ' was uploaded successfully.<br><a href="gallery.php' . $private . '">Check it out in the  gallery!</a>';		
		}
	} // END UPLOAD IMAGE

	// EDIT IMAGE
	if(isset($_POST['edit_photo'])){
		
		// Get User ID
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
		
		// Make sure user is able to edit picture
		$userid = $_POST['userid'];
		if ($uID != $userid) {
			array_push($errors, "You don't have permission to edit this photo.");
		}
		
		// Set other variables
		$title = $_POST['title'];
		$cat = $_POST['selectCategory'];
		$privacy = $_POST['privacy'];
		$pid = $_POST['pid'];

		// Check to make sure description is not empty
		if (empty($title)) { array_push($errors, "Please enter a description");	}

		// Check to make sure a category is selected
		if (empty($cat)) { array_push($errors, "Please select a category");	}

		// Make sure privacy is correct
		if ($privacy != 1) {
			$privacy = NULL;
		}
		
		if (count($errors) == 0) {

			$query="UPDATE photos SET title='$title', cid='$cat', privacy='$privacy' WHERE pid='$pid'";
			mysqli_query($db,$query);


			// Set session variables
			$private = "";
			if (!empty($privacy)) {
				$private = "?private=1";
			} 

			$_SESSION['editMsg'] = 'Your image was updated.<br><a href="gallery.php' . $private . '">Check it out in the  gallery!</a>';		
		}
		
	} // END EDIT IMAGE

	// DELETE IMAGE

	if(isset($_POST['delete_photo'])) {
		$query = "DELETE FROM photos WHERE pid='".$_REQUEST['pid']."'";
		$results = mysqli_query($db, $query) or die("database error:". mysqli_error($db));
		if($results) {
				$_SESSION['editMsg'] = 'The image was deleted.';
		}
	}
?>
