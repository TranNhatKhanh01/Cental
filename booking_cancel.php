<?php
    session_start();
    require 'connection.php'; // $conn is PDO

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Not logged in']);
        exit;
    }

    $bookingId = $_POST['booking_id'] ?? null;
    $userId = $_SESSION['user']['id'];

    if (!$bookingId) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid booking']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = :id AND user_id = :user_id");
    $success = $stmt->execute(['id' => $bookingId, 'user_id' => $userId]);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to cancel booking']);
    }
?>
