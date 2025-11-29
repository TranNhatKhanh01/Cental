<?php
    header("Content-Type: application/json");

    $carId = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;

    if (!$carId) {
        echo json_encode([]);
        exit;
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=car_rental;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->prepare("
            SELECT start_date, end_date
            FROM bookings
            WHERE car_id = ? AND status != 'cancelled'
            ORDER BY start_date ASC
        ");
        $stmt->execute([$carId]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($bookings);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
?>