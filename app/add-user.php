<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['role']) && isset($_POST['department']) && $_SESSION['role'] == 'admin') {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$user_name = validate_input($_POST['user_name']);
	$password = validate_input($_POST['password']);
	$first_name = validate_input($_POST['first_name']);
	$last_name = validate_input($_POST['last_name']);
	$full_name = $first_name . ' ' . $last_name;
	$email = validate_input($_POST['email']);
	$role = validate_input($_POST['role']);
	$department = validate_input($_POST['department']);

	if (empty($user_name)) {
		$em = "Username is required";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else if (empty($password)) {
		$em = "Password is required";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else if (empty($first_name)) {
		$em = "First name is required";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else if (empty($last_name)) {
		$em = "Last name is required";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else if (empty($email)) {
		$em = "Email is required";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$em = "Invalid email format";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else if (empty($role)) {
		$em = "Role is required";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else if (empty($department)) {
		$em = "Department is required";
	    header("Location: ../add-user.php?error=$em");
	    exit();
	}else {
    
       include "Model/User.php";
       $password = password_hash($password, PASSWORD_DEFAULT);

       $data = array($full_name, $user_name, $email, $password, $role, $department);
       insert_user($conn, $data);

       $em = "User created successfully";
	    header("Location: ../add-user.php?success=$em");
	    exit();

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../add-user.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../add-user.php?error=$em");
   exit();
}