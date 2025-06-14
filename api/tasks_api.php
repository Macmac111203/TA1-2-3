<?php
require_once '../DB_connection.php';
require_once 'csrf.php';

header('Content-Type: application/json');

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = explode('/', trim(str_replace('/TMS/api/tasks_api.php', '', $request_uri), '/'));

// Validate CSRF token for non-GET requests
if ($method !== 'GET') {
    if (!isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
        http_response_code(403);
        echo json_encode(['error' => 'CSRF token missing']);
        exit;
    }
    CSRF::validateToken($_SERVER['HTTP_X_CSRF_TOKEN']);
}

// API endpoints
switch ($method) {
    case 'GET':
        if (isset($request[0]) && is_numeric($request[0])) {
            // Get single task
            $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
            $stmt->execute([$request[0]]);
            $task = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($task);
        } else {
            // Get all tasks
            $stmt = $conn->query("SELECT * FROM tasks");
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($tasks);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO tasks (title, description, due_date, status, assigned_to) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['due_date'],
            $data['status'],
            $data['assigned_to']
        ]);
        echo json_encode(['id' => $conn->lastInsertId()]);
        break;

    case 'PUT':
        if (!isset($request[0]) || !is_numeric($request[0])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid task ID']);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, status = ?, assigned_to = ? WHERE id = ?");
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['due_date'],
            $data['status'],
            $data['assigned_to'],
            $request[0]
        ]);
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        if (!isset($request[0]) || !is_numeric($request[0])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid task ID']);
            exit;
        }
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$request[0]]);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
} 