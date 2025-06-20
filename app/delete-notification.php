<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    if (isset($_GET['id'])) {
        include "../DB_connection.php";
        $notif_id = intval($_GET['id']);
        if ($_SESSION['role'] === 'admin') {
            // Admin can delete any notification
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id=?");
            $stmt->execute([$notif_id]);
        } else {
            // Employee can only delete their own notification
            $recipient = $_SESSION['id'];
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id=? AND recipient=?");
            $stmt->execute([$notif_id, $recipient]);
        }
        $sm = "Notification deleted successfully.";
        header("Location: ../notifications.php?success=$sm");
        exit();
    } else {
        header("Location: ../notifications.php?error=Invalid notification ID");
        exit();
    }
} else {
    $em = "First login";
    header("Location: ../login.php?error=$em");
    exit();
} 