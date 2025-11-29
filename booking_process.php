<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
        header("Location: layout.php?page=login&error=not_logged_in");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $carId = $_POST['car_id'] ?? null;
    $pickup = trim($_POST['pickup'] ?? '');
    $dropoff = trim($_POST['dropoff'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $startHour = $_POST['start_hour'] ?? '';
    $startMinute = $_POST['start_minute'] ?? '';
    $endHour = $_POST['end_hour'] ?? '';
    $endMinute = $_POST['end_minute'] ?? '';
    $voucherCode = trim($_POST['voucher_code'] ?? '');
    $status = 'pending';

    // Convert to datetime
    $startTime = $startDate . ' ' . str_pad($startHour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($startMinute, 2, '0', STR_PAD_LEFT);
    $endTime = $endDate . ' ' . str_pad($endHour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($endMinute, 2, '0', STR_PAD_LEFT);

    $start = DateTime::createFromFormat('Y-m-d H:i', $startTime);
    $end = DateTime::createFromFormat('Y-m-d H:i', $endTime);

    $conn = new mysqli("localhost", "root", "", "car_rental");
    if ($conn->connect_error) {
        die("Database connection failed.");
    }

    // Check overlapping bookings
    $checkOverlap = $conn->prepare("
        SELECT COUNT(*) FROM bookings 
        WHERE car_id = ? AND status != 'cancelled' AND (
            (start_date < ? AND end_date > ?) OR
            (start_date < ? AND end_date > ?) OR
            (start_date >= ? AND end_date <= ?)
        )
    ");
    $startStr = $start->format('Y-m-d H:i:s');
    $endStr = $end->format('Y-m-d H:i:s');
    $checkOverlap->bind_param("issssss", $carId, $endStr, $endStr, $startStr, $startStr, $startStr, $endStr);
    $checkOverlap->execute();
    $checkOverlap->bind_result($conflictCount);
    $checkOverlap->fetch();
    $checkOverlap->close();

    if ($conflictCount > 0) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'The time you want to book this car is already exists.'
        ]);
        exit;
    }

    // Get price per hour
    $stmt = $conn->prepare("SELECT price_per_hour FROM cars WHERE id = ?");
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    $stmt->bind_result($pricePerHour);
    if (!$stmt->fetch()) {
        header("Location: layout.php?page=home&car_id=$carId&error=car_not_found");
        exit;
    }
    $stmt->close();

    $interval = $start->diff($end);
    $hours = ($interval->days * 24) + $interval->h + ($interval->i > 0 ? 1 : 0);
    $hours = max($hours, 1);
    $totalPrice = $originalPrice = $hours * $pricePerHour;

    // Voucher
    $discountPercent = 0;
    if ($voucherCode !== '') {
        $voucherStmt = $conn->prepare("SELECT discount_percent, expiry_date, usage_limit, used_count FROM vouchers WHERE code = ?");
        $voucherStmt->bind_param("s", $voucherCode);
        $voucherStmt->execute();
        $voucherStmt->bind_result($percent, $expiryDate, $usageLimit, $usedCount);
        if ($voucherStmt->fetch()) {
            if (date('Y-m-d') <= $expiryDate && $usedCount < $usageLimit) {
                $discountPercent = $percent;
                $discount = ($totalPrice * $discountPercent) / 100;
                $totalPrice -= $discount;
                $updateVoucher = $conn->prepare("UPDATE vouchers SET used_count = used_count + 1 WHERE code = ?");
                $updateVoucher->bind_param("s", $voucherCode);
                $updateVoucher->execute();
                $updateVoucher->close();
            }
        }
        $voucherStmt->close();
    }

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings 
        (car_id, user_id, pickup_location, dropoff_location, start_date, end_date, original_price, voucher_code, total_price, status, booking_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iissssdsds", 
        $carId, $userId, $pickup, $dropoff, $startStr, $endStr, 
        $originalPrice, $voucherCode, $totalPrice, $status);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'An error occurred while saving the reservation.'
        ]);
    }
    exit;
?>
