<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Cental - Car Rent Website</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>
    
    <body>
        <?php
            include 'connection.php'; // kết nối PDO

            if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
                echo "<p>Please <a href='layout.php?page=login'>log in</a> to view booking history.</p>";
                return;
            }

            $user_id = $_SESSION['user']['id'];

            $stmt = $conn->prepare("
                SELECT 
                    b.id, b.booking_date, b.start_date, b.end_date, b.pickup_location, b.dropoff_location, b.original_price, b.total_price, b.status, 
                    v.discount_percent, 
                    c.brand, c.model, c.year, c.image 
                FROM bookings b
                JOIN cars c ON b.car_id = c.id
                LEFT JOIN vouchers v ON b.voucher_code = v.code
                WHERE b.user_id = :user_id
                ORDER BY b.id DESC
            ");
            $stmt->execute(['user_id' => $user_id]);
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5 wow fadeInDown" data-wow-delay="0.1s">
                <h4 class="text-white display-4 mb-4">History</h4>
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="layout.php">Home</a></li>
                    <li class="breadcrumb-item active text-primary">Booking List</li>
                </ol>
            </div>
        </div>

        <h2 class="text-primary mb-4 my-4 text-center"id="history-content"><strong>Your Booking List</strong></h2>

        <div class="table-responsive text-center">
            <table class="table table-striped table-bordered table-hover align-middle text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th><strong>Booking ID</strong></th>
                        <th><strong>Booking Date</strong></th>
                        <th><strong>Type of Car</strong></th>
                        <th><strong>Car Image</strong></th>
                        <th><strong>Original Price</strong></th>
                        <th><strong>Voucher</strong></th>
                        <th><strong>Total Price</strong></th>
                        <th><strong>Details</strong></th>
                        <th><strong>Status</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($bookings) === 0): ?>
                        <tr>
                            <td colspan="9" class="text-primary text-center fs-5">No booking history found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $row): ?>
                        <tr>
                            <td><strong>#<?= $row['id'] ?></strong></td>
                            <td><strong><?= (new DateTime($row['booking_date']))->format('H:i, F j, Y') ?></strong></td>
                            <td><strong><?= $row['brand'] . ' ' . $row['model'] . ' (' . $row['year'] . ')' ?></strong></td>
                            <td>
                                <img src="img/<?= htmlspecialchars($row['image']) ?>" class="img-fluid rounded" style="width: 150px; height: 80px; object-fit: cover;">
                            </td>
                            <td><strong>$<?= number_format($row['original_price'], 2) ?></strong></td>
                            <td><strong><?= $row['discount_percent'] ? $row['discount_percent'] . '% Off' : 'No Voucher' ?></strong></td>
                            <td><strong>$<?= number_format($row['total_price'], 2) ?></strong></td>
                            <td>
                                <a href="layout.php?page=booking_details&id=<?= $row['id'] ?>" class="btn btn-outline-primary rounded-pill btn-sm">View</a>
                            </td>
                            <td>
                                <span class="badge bg-<?= 
                                    $row['status'] === 'confirmed' ? 'success' : 
                                    ($row['status'] === 'cancelled' ? 'danger' : 'warning' 
                                ) ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="text-center pb-3">
                <a href="layout.php?page=layout" class="btn btn-outline-primary rounded-pill px-4">← Back to Home</a>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="js/history.js"></script>
    </body>
</html>