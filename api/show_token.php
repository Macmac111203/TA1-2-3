<?php
session_start();
require_once 'csrf.php';

// Generate a new token if one doesn't exist
$token = CSRF::generateToken();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your CSRF Token</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .token-box { 
            border: 1px solid #ccc; 
            padding: 20px; 
            margin: 10px 0;
            background: #f9f9f9;
        }
        .token {
            background: #eee;
            padding: 10px;
            border-radius: 4px;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <h2>Your Current CSRF Token</h2>
    <div class="token-box">
        <p>Copy this token to use in your API requests:</p>
        <div class="token"><?php echo $token; ?></div>
    </div>
    <p><strong>Note:</strong> This token is valid for your current session only.</p>
</body>
</html> 