<?php
session_start();
require_once 'csrf.php';
require_once '../DB_connection.php';

header('Content-Type: application/json');

// Test 1: Valid Request with Token
$validToken = CSRF::generateToken();
$test1 = [
    'test' => 'Valid Request with Token',
    'token' => $validToken,
    'expected' => 'Should succeed',
    'result' => 'Not tested yet'
];

// Test 2: Invalid Request without Token
$test2 = [
    'test' => 'Invalid Request without Token',
    'token' => null,
    'expected' => 'Should fail with 403',
    'result' => 'Not tested yet'
];

// Test 3: Invalid Request with Wrong Token
$test3 = [
    'test' => 'Invalid Request with Wrong Token',
    'token' => 'invalid_token',
    'expected' => 'Should fail with 403',
    'result' => 'Not tested yet'
];

// Run the tests
$tests = [$test1, $test2, $test3];

foreach ($tests as &$test) {
    try {
        if ($test['token'] === null) {
            // Test without token
            CSRF::validateToken('');
        } else {
            // Test with token
            CSRF::validateToken($test['token']);
        }
        $test['result'] = 'Success';
    } catch (Exception $e) {
        $test['result'] = 'Failed: ' . $e->getMessage();
    }
}

echo json_encode([
    'csrf_protection_tests' => $tests,
    'explanation' => [
        'Test 1' => 'Demonstrates that requests with valid CSRF tokens are accepted',
        'Test 2' => 'Demonstrates that requests without CSRF tokens are rejected',
        'Test 3' => 'Demonstrates that requests with invalid CSRF tokens are rejected'
    ]
], JSON_PRETTY_PRINT); 