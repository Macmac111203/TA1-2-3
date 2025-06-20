<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['user_name']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['role']) && isset($_POST['department']) && $_SESSION['role'] == 'admin') {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$user_name = validate_input($_POST['user_name']);
	$first_name = validate_input($_POST['first_name']);
	$last_name = validate_input($_POST['last_name']);
	$email = validate_input($_POST['email']);
	$role = validate_input($_POST['role']);
	$department = validate_input($_POST['department']);
	$id = validate_input($_POST['id']);

	$full_name = $first_name . ' ' . $last_name;

	if (empty($user_name)) {
		$em = "Username is required";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else if (empty($first_name) || empty($last_name)) {
		$em = "First name and last name are required";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else if (empty($email)) {
		$em = "Email is required";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$em = "Invalid email format";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else if (empty($role)) {
		$em = "Role is required";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else if (empty($department)) {
		$em = "Department is required";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else {
    
       include "Model/User.php";
       $data = array($full_name, $user_name, $email, $role, $department, $id);
       update_user($conn, $data);

       $em = "User updated successfully!";
	    header("Location: ../edit-user.php?success=$em&id=$id");
	    exit();
    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit-user.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../edit-user.php?error=$em");
   exit();
}