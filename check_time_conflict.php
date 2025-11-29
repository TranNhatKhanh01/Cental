<?php
    header("Content-Type: application/json");

    $carId     = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
    $startTime = $_GET['start'] ?? '';
    $endTime   = $_GET['end'] ?? '';

    if (!$carId || !$startTime || !$endTime) {
        echo json_encode(['conflict' => false]);
        exit;
    }

    $pdo = new PDO("mysql:host=localhost;dbname=car_rental;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM bookings 
        WHERE car_id = ? AND status != 'cancelled'
        AND (
            (start_date <= ? AND end_date > ?) OR
            (start_date < ? AND end_date >= ?) OR
            (start_date >= ? AND end_date <= ?)
        )
    ");
    $stmt->execute([$carId, $startTime, $startTime, $endTime, $endTime, $startTime, $endTime]);

    $conflict = $stmt->fetchColumn() > 0;

    echo json_encode(['conflict' => $conflict]);
?>