<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset(
    $_POST['confirm_password'],
    $_POST['new_password'],
    $_POST['password'],
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['email'],
    $_POST['user_name']
) && $_SESSION['role'] == 'employee') {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	
	$password = validate_input($_POST['password']);
	$first_name = validate_input($_POST['first_name']);
	$last_name = validate_input($_POST['last_name']);
	$email = validate_input($_POST['email']);
	$user_name = validate_input($_POST['user_name']);
	$new_password = validate_input($_POST['new_password']);
	$confirm_password = validate_input($_POST['confirm_password']);
   $id = $_SESSION['id'];

	$full_name = $first_name . ' ' . $last_name;

	if (empty($password) || empty($new_password) || empty($confirm_password)) {
		$em = "Password is required";
	    header("Location: ../edit_profile.php?error=$em");
	    exit();
	}else if (empty($first_name) || empty($last_name)) {
		$em = "First name and last name are required";
	    header("Location: ../edit_profile.php?error=$em");
	    exit();
	}else if (empty($email)) {
		$em = "Email is required";
	    header("Location: ../edit_profile.php?error=$em");
	    exit();
	}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$em = "Invalid email format";
	    header("Location: ../edit_profile.php?error=$em");
	    exit();
	}else if (empty($user_name)) {
		$em = "Username is required";
	    header("Location: ../edit_profile.php?error=$em");
	    exit();
	}else if ($confirm_password != $new_password) {
		$em = "New password and confirm password do not match";
	    header("Location: ../edit_profile.php?error=$em");
	    exit();
	}else {
    
       include "Model/User.php";

       $user = get_user_by_id($conn, $id);
       if ($user) {
       	 if (password_verify($password, $user['password'])) {

			       $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);



			       $data = array($full_name, $email, $user_name, $new_password_hashed, $id);
			       update_profile($conn, $data);

			       $em = "Profile updated successfully";
				    header("Location: ../edit_profile.php?success=$em");
				    exit();
			    }else {
			    	$em = "Incorrect password";
				   header("Location: ../edit_profile.php?error=$em");
				   exit();
			    }
		   }else {
            $em = "Unknown error occurred";
			   header("Location: ../edit_profile.php?error=$em");
			   exit();
		   }

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit_profile.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}