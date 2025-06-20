<?php
session_start();
require_once '../api/csrf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify CSRF token
    if (!CSRF::validateToken($_POST['csrf_token'])) {
        header("Location: ../register.php?error=Invalid request");
        exit();
    }

    include "../DB_connection.php";

    // Get form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Combine first_name and last_name into full_name
    $full_name = $first_name . ' ' . $last_name;

    // Validation
    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: ../register.php?error=All fields are required");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=Invalid email format");
        exit();
    }

    if (strlen($password) < 8) {
        header("Location: ../register.php?error=Password must be at least 8 characters long");
        exit();
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        header("Location: ../register.php?error=Password must contain at least one uppercase letter, one lowercase letter, one number and one special character");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: ../register.php?error=Passwords do not match");
        exit();
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->rowCount() > 0) {
        header("Location: ../register.php?error=Username or email already exists");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    try {
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $username, $email, $hashed_password, 'employee']);

        header("Location: ../login.php?success=Registration successful. Please login.");
        exit();
    } catch (PDOException $e) {
        header("Location: ../register.php?error=Registration failed. Please try again.");
        exit();
    }
} else {
    header("Location: ../register.php");
    exit();
} 