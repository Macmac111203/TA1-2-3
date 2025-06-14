<?php
require_once '../DB_connection.php';
require_once 'csrf.php';

class FileUpload {
    private $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    private $maxFileSize = 5242880; // 5MB
    private $uploadDir = '../uploads/';

    public function __construct() {
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function handleUpload($file, $userId) {
        // Validate CSRF token
        if (!isset($_POST['csrf_token'])) {
            throw new Exception('CSRF token missing');
        }
        CSRF::validateToken($_POST['csrf_token']);

        // Validate file
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new Exception('Invalid file parameters');
        }

        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            throw new Exception('File too large');
        }

        // Check file type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileType = $finfo->file($file['tmp_name']);
        if (!in_array($fileType, $this->allowedTypes)) {
            throw new Exception('Invalid file type');
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFilename = uniqid() . '_' . $userId . '.' . $extension;
        $uploadPath = $this->uploadDir . $newFilename;

        // Move file to upload directory
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Failed to move uploaded file');
        }

        // Store file information in database
        $stmt = $conn->prepare("INSERT INTO file_uploads (user_id, filename, original_name, file_type, upload_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$userId, $newFilename, $file['name'], $fileType]);

        return [
            'success' => true,
            'filename' => $newFilename,
            'original_name' => $file['name']
        ];
    }
} 