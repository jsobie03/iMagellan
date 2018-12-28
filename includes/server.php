<?php 
	ob_start();

	ini_set('display_errors', 1); 
	error_reporting(E_ALL);

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array();
	$successes = array(); 
	$_SESSION['success'] = "";
	
	// database connection variables
	$db_host = "www.jonsobier.com";
	$db_user = "jsobieze_jsobier";
	$db_pass = "Bak3rFina1";
	$db_name = "jsobieze_imagellan";

	// connect to database
	$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

	// REGISTER USER
	if (isset($_POST['register_user'])) {
		
		// set form variables from post data
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// check to make sure no fields are empty
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }
		if (empty($password_2)) { array_push($errors, "Password confirmation is required"); }

		
		// check to see if email and username are already in use
		$sql_email = "SELECT * FROM users WHERE email='$email'";
		$res_email = mysqli_query($db, $sql_email);
		$sql_username = "SELECT * FROM users WHERE user='$username'";
		$res_username = mysqli_query($db, $sql_username);
		
		if (mysqli_num_rows($res_username) > 0) { array_push($errors, "Username taken"); }
		if (mysqli_num_rows($res_email) > 0) { array_push($errors, "E-mail in use"); }
		
		// check to make sure passwords match
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// if there are no errors in the form, proceed with registration
		if (count($errors) == 0) {
			$password = md5($password_1); // encrypt the password before saving in the database
			$query = "INSERT INTO users (user, email, pass) 
					  VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);

			// set session variables and redirect to index.php
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['success'] = "You are now logged in";
			header('Location: index.php');
		}
		
	} // END REGISTER USER

	// UPDATE USER
	if (isset($_POST['update_user'])) {
		// set variables from session variables
		$user = $_SESSION['username'];
		$email = $_SESSION['email'];
		$new_user = $user;
		$new_email = $email;
		
		$query = "SELECT * FROM users WHERE user='$user'";
		$results = mysqli_query($db, $query);
		$user_row = mysqli_fetch_assoc($results);
		
		// get user id if it's not set
		if (!isset($_SESSION['user_id'])) {
			if (mysqli_num_rows($results) == 1) {

				// find the user ID to set it for the session
				$uid = $user_row['uid'];
				$_SESSION['user_id'] = $uid;
			}
		} else {
			$uid = $_SESSION['user_id'];
		} 
		
		// set form variables from post data
		$new_user = mysqli_real_escape_string($db, $_POST['new_user']);
		$new_email = mysqli_real_escape_string($db, $_POST['new_email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
		$new_password_1 = mysqli_real_escape_string($db, $_POST['new_password_1']);
		$new_password_2 = mysqli_real_escape_string($db, $_POST['new_password_2']);
		
		// check to make sure no fields except new passwords are empty
		if (empty($new_user)) { array_push($errors, "Username is required"); }
		if (empty($new_email)) { array_push($errors, "Email is required"); }
		if (empty($password)) { array_push($errors, "Current Password is required"); }
		
		// if new password is not empty, make sure passwords match and are filled in
		$passwordOK = 0;
		if (!empty($new_password_1) || !empty($new_password_2)) {
			// make sure new passwords are both there
			if (empty($new_password_1)) { array_push($errors, "New password confirmation is required"); }
			elseif (empty($new_password_1)) { array_push($errors, "New password confirmation is required"); }
			
			// check to make sure passwords match
			if ($new_password_1 != $new_password_2) {
				array_push($errors, "The two new passwords do not match");
			} else {
				$passwordOK = 1;
			}
		}
		
		// check to see if email and username are already in use
		if ($new_email != $email) {
			$sql_email = "SELECT * FROM users WHERE email='$new_email'";
			$res_email = mysqli_query($db, $sql_email);
			
			if (mysqli_num_rows($res_email) > 0) { array_push($errors, "E-mail in use"); }
		}
		
		if ($new_user != $user) {
			$sql_username = "SELECT * FROM users WHERE user='$new_user'";
			$res_username = mysqli_query($db, $sql_username);

			if (mysqli_num_rows($res_username) > 0) { array_push($errors, "Username taken"); }
		}
			
		
		// if there are no errors in the form, proceed with update
		if (count($errors) == 0) {
			$password = md5($password); // encrypt the current password before comparing to the encrypted password in the database
			
			// check to make sure current password and password in database match
			if ($password == $user_row['pass']) {
				
				if ($passwordOK == 1) {
					$new_password = md5($new_password_1); // encrypt the new password before entering it into the database
					$query = "UPDATE users SET user='$new_user', email='$new_email', pass='$new_password' WHERE `uid`='$uid'";
				} else {
					$query = "UPDATE users SET user='$new_user', email='$new_email' WHERE `uid`='$uid'";
				}
				
				mysqli_query($db, $query);

				// set new session variables
				$_SESSION['username'] = $new_user;
				$_SESSION['email'] = $new_email;
				array_push($successes, "Your information has been updated");				
			} else {
				array_push($errors, "Incorrect Password");
			}		
		}	
		
	} // END UPDATE USER

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		//check to make sure the fields are not empty
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// proceed with login if there are no errors
		if (count($errors) == 0) {
			
			$password = md5($password); // encrypt the password before comparing to the encrypted password in the database
			
			// query the database to see if there is a user with the matching usernam/encrypted password combination
			$query = "SELECT * FROM users WHERE email='$email' AND pass='$password'";
			$results = mysqli_query($db, $query);

			// log in if the row is found
			if (mysqli_num_rows($results) == 1) {
				
				// find the username to set it for the session
				$user_row = mysqli_fetch_assoc($results);
				$username = $user_row['user'];
				$uid = $user_row['uid'];
				$type = $user_row['type'];
				
				$_SESSION['user_id'] = $uid;
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
				$_SESSION['user_type'] = $type;
				$_SESSION['success'] = "You are now logged in";
				header('Location: index.php');
			} else {
				// otherwise, give the following error
				array_push($errors, "Wrong email/password combination");
			}
		}
	} // END LOGIN USER

?>
