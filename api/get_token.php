<?php
session_start();
require_once 'csrf.php';

// Generate a new token if one doesn't exist
$token = CSRF::generateToken();

// Output the token
header('Content-Type: application/json');
echo json_encode(['csrf_token' => $token]); 