<?php
    session_start();
    include 'connection.php';

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
        header("Location: layout.php?page=login");
        exit;
    }

    $user_id = $_SESSION['user']['id'] ?? null;

    if (!$user_id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: layout.php?page=login");
        exit;
    }

    $booking_id = $_POST['booking_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $vehicle_feedback = trim($_POST['vehicle_feedback'] ?? '');
    $staff_feedback = trim($_POST['staff_feedback'] ?? '');
    $policy_feedback = trim($_POST['policy_feedback'] ?? '');
    $price_feedback = trim($_POST['price_feedback'] ?? '');
    $comments = trim($_POST['comments'] ?? '');

    if (
        !$booking_id || !$rating || !$vehicle_feedback || !$staff_feedback ||
        !$policy_feedback || !$price_feedback || !$comments
    ) {
        header("Location: layout.php?page=booking_details&id=$booking_id&feedback=error");
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO feedback (
            user_id, booking_id, rating, vehicle_feedback,
            staff_feedback, policy_feedback, price_feedback, comments, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $success = $stmt->execute([
        $user_id,
        $booking_id,
        $rating,
        $vehicle_feedback,
        $staff_feedback,
        $policy_feedback,
        $price_feedback,
        $comments
    ]);

    if ($success) {
        header("Location: layout.php?page=booking_details&id=$booking_id&feedback=success");
        exit;
    } else {
        header("Location: layout.php?page=booking_details&id=$booking_id&feedback=error");
        exit;
    }
?>