<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "car_rental";

    $conn = new mysqli($host, $username, $password, $database);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = date('Y-m-d H:i:s');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Vehicle Categories</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="layout.php">Home</a></li>
            <li class="breadcrumb-item active text-primary">Categories</li>
        </ol>    
    </div>
</div>
<!-- Header End -->

<!-- Car categories Start -->
<div class="container-fluid categories" id="car-section">
    <div class="container py-4">
        <div class="row g-4 wow fadeInUp" data-wow-delay="0.1s">
            <?php
                $updateSql = "
                    UPDATE cars
                    SET status = 'available'
                    WHERE id NOT IN (
                        SELECT car_id FROM bookings 
                        WHERE status != 'cancelled' 
                        AND start_date <= '$now' 
                        AND end_date >= '$now'
                    )
                ";
                $conn->query($updateSql);
                $sql = "SELECT * FROM cars ORDER BY brand ASC, model ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                $carId = $row['id'];
                $endDate = null;
                $todayStart = (new DateTime())->format('Y-m-d 00:00:00');
                $todayEnd   = (new DateTime())->format('Y-m-d 23:59:59');

                $bookingSql = "SELECT end_date FROM bookings 
                            WHERE car_id = ? 
                            AND status != 'cancelled'
                            AND start_date <= ? 
                            AND end_date >= ? 
                            ORDER BY end_date DESC LIMIT 1";

                $bookingStmt = $conn->prepare($bookingSql);
                $bookingStmt->bind_param("iss", $carId, $todayEnd, $todayStart);
                $bookingStmt->execute();
                $bookingStmt->bind_result($endDate);
                $hasActiveBooking = $bookingStmt->fetch();
                $bookingStmt->close();

                $isAvailable = !$hasActiveBooking && $row['status'] === 'available';
                $statusText = $isAvailable ? 'Available' : 'Unavailable';
                $statusColor = $isAvailable ? 'text-success' : 'text-danger';
                $statusIcon  = $isAvailable ? 'fa-check-circle' : 'fa-times-circle';
            ?>
            <div class="col-md-4">
                <div class="categories-item h-100 p-4">
                    <div class="categories-item-inner h-100 d-flex flex-column">
                        <div class="car-img-wrapper mb-3">
                            <img src="img/<?php echo $row['image']; ?>" class="img-fluid w-100 rounded-top" alt="Car Image" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="categories-content rounded-bottom p-4 flex-grow-1 d-flex flex-column">
                            <h4><?php echo $row['brand'] . ' ' . $row['model']; ?></h4>
                            <div class="categories-review mb-3">
                                <div class="me-3">4.5 Review</div>
                                <div class="d-flex justify-content-center text-secondary">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-body"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">
                                    $<?php echo number_format($row['price_per_hour'], 2); ?>/Hour
                                </h4>
                            </div>
                            <div class="row gy-2 gx-0 text-center mb-3">
                                <div class="col-4 border-end border-white">
                                    <i class="fa fa-users text-dark"></i>
                                    <span class="text-body"><?php echo $row['seats']; ?> Seat</span>
                                </div>
                                <div class="col-4">
                                    <i class="fa fa-gas-pump text-dark"></i>
                                    <span class="text-body">Petrol</span>
                                </div>
                                <div class="col-4 border-end border-white">
                                    <i class="fa fa-car text-dark"></i>
                                    <span class="text-body"><?php echo $row['year'] ?: 'N/A'; ?></span>
                                </div>
                                <div class="col-4 border-end border-white">
                                    <i class="fa fa-cogs text-dark"></i>
                                    <span class="text-body ms-1">AUTO</span>
                                </div>
                                <div class="col-4 border-end border-white">
                                    <i class="fa <?php echo $statusIcon . ' ' . $statusColor; ?>"></i>
                                    <span class="fw-bold <?php echo $statusColor; ?>">
                                        <?php echo $statusText; ?>
                                    </span>
                                </div>
                                <div class="col-4 border-end border-white">
                                    <?php if (!$isAvailable && $endDate): ?>
                                        <i class="fa fa-clock text-dark"></i>
                                        <span class="text-body">Soonest <?= (new DateTime($endDate))->format('H:i F j, Y') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <?php if ($isAvailable): ?>
                                    <a href="layout.php?page=home&car_id=<?php echo $row['id']; ?>" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Book Now</a>
                                <?php else: ?>
                                    <a href="layout.php?page=home&car_id=<?php echo $row['id']; ?>" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">Book Now</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile;?>
            <?php else:?>
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary">No Cars found.</h5>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
<!-- Car categories End -->