<?php
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
        header("Location: layout.php?page=login");
        exit;
    }

    include 'connection.php';
    $customer_id = $_SESSION['user']['id'];
    $booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $feedbackSuccess = isset($_GET['feedback']) && $_GET['feedback'] === 'success';

    $stmt = $conn->prepare("
        SELECT b.*, c.brand, c.model, c.year, c.image, v.discount_percent
        FROM bookings b
        JOIN cars c ON b.car_id = c.id
        LEFT JOIN vouchers v ON b.voucher_code = v.code
        WHERE b.id = :booking_id AND b.user_id = :customer_id
        LIMIT 1
    ");
    $stmt->execute([
        'booking_id' => $booking_id,
        'customer_id' => $customer_id
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "<div class='alert alert-warning text-center my-5'>No booking found.</div>";
        exit;
    }

    $stmt2 = $conn->prepare("SELECT COUNT(*) FROM feedback WHERE booking_id = :booking_id AND user_id = :customer_id");
    $stmt2->execute([
        'booking_id' => $booking_id,
        'customer_id' => $customer_id
    ]);
    $hasFeedback = $stmt2->fetchColumn() > 0;

    $imagePath = (!empty($row['image']) && file_exists('img/' . basename($row['image']))) 
        ? 'img/' . basename($row['image']) 
        : 'img/default-car.jpg';

    $now = new DateTime();
    $endDate = new DateTime($row['end_date']);
    $bookingDate = new DateTime($row['booking_date']);
    $startDate = new DateTime($row['start_date']);

    $showContact = (
        $row['status'] === 'confirmed' &&
        $bookingDate < $startDate &&
        ($startDate->getTimestamp() - $bookingDate->getTimestamp()) >= 3600
    );
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Cental - Car Rent Website</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5 wow fadeInDown" data-wow-delay="0.1s">
                <h4 class="text-white display-4 mb-4">History</h4>
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="layout.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="layout.php?page=history">Booking List</a></li>
                    <li class="breadcrumb-item active text-primary">Details</li>
                </ol>
            </div>
        </div>

        <h2 class="text-primary my-4 text-center"  id="booking-details-section"><strong>Your Booking Details</strong></h2>

        <div class="container my-1">
            <div class="card shadow">
                <div class="card-header bg-dark text-white text-center">
                    <h5 class="mb-0 text-white"><strong>#<?= $row['id'] ?></strong></h5>
                </div>
                <div class="card-body py-1">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Booking Date:</strong> <?= $bookingDate->format('H:i, F j, Y') ?></li>
                                <li class="list-group-item"><strong>Pick Up:</strong> <?= htmlspecialchars($row['pickup_location']) ?></li>
                                <li class="list-group-item"><strong>Time:</strong> <?= $startDate->format('H:i, F j, Y') ?></li>
                                <li class="list-group-item"><strong>Drop Off:</strong> <?= htmlspecialchars($row['dropoff_location']) ?></li>
                                <li class="list-group-item"><strong>Time:</strong> <?= (new DateTime($row['end_date']))->format('H:i, F j, Y') ?></li>
                                <li class="list-group-item"><strong>Original Price:</strong> $<?= number_format($row['original_price'], 2) ?></li>
                                <li class="list-group-item"><strong>Voucher:</strong> <?= $row['voucher_code'] ? number_format($row['discount_percent'], 0) . '% Off' : 'No voucher applied' ?></li>
                                <li class="list-group-item"><strong>Final Price:</strong> $<?= number_format($row['total_price'], 2) ?></li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-center">
                            <span class="badge status-badge bg-<?= 
                                $row['status'] === 'confirmed' ? 'success' : 
                                ($row['status'] === 'cancelled' ? 'danger' : 'warning') ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                            <p class="mt-3"><strong><?= $row['brand'] . ' ' . $row['model'] . ' (' . $row['year'] . ')' ?></strong></p>
                            <img src="<?= htmlspecialchars($imagePath) ?>" class="img-fluid shadow" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <a href="layout.php?page=history" class="btn btn-outline-primary rounded-pill px-4">← Back to History</a>
                    </div>

                    <?php if ($feedbackSuccess): ?>
                        <div class="col-12 text-center" id="feedback-alert">
                            <div class="alert alert-success d-inline-block">
                                <i class="fas fa-check-circle me-2"></i> Thank you for your feedback!
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($row['status'] !== 'cancelled'): ?>
                        <div class="col-auto">                                
                            <?php if ($row['status'] === 'pending'): ?>
                                <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel Booking</button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Cancel Modal -->
            <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-center">
                        <div class="modal-body text-dark">Are you sure you want to cancel this booking?</div>
                        <div class="modal-footer justify-content-center">
                            <form action="booking_cancel.php" method="POST">
                                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-outline-primary rounded-pill px-4">Yes, Cancel</button>
                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">No</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Form -->
            <?php if ($row['status'] === 'confirmed' && $endDate < $now && !$hasFeedback): ?>
                <div class="container my-5 p-4 shadow rounded bg-light wow fadeInUp" id="feedback-form" data-wow-delay="0.2s">
                    <h4 class="text-center text-primary mb-4"><i class="fas fa-comment-dots me-2"></i>Leave Your Feedback</h4>
                    <form method="POST" action="feedback.php" class="px-3 px-md-5">
                        <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">

                        <div class="star-rating d-flex gap-2 fs-3 text-warning justify-content-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label class="rating-star" style="cursor: pointer;">
                                    <input type="radio" name="rating" value="<?= $i ?>" hidden required>
                                    <i class="far fa-star"></i>
                                </label>
                            <?php endfor; ?>
                        </div>

                        <!-- Vehicle Feedback -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Vehicle Quality</label>
                            <select name="vehicle_feedback" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Terrible">Terrible</option>
                                <option value="Below Average">Below Average</option>
                                <option value="Acceptable">Acceptable</option>
                                <option value="Comfortable">Comfortable</option>
                                <option value="Excellent">Excellent</option>
                            </select>
                        </div>

                        <!-- Staff Feedback -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Staff Performance</label>
                            <select name="staff_feedback" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Unhelpful">Unhelpful</option>
                                <option value="Inattentive">Inattentive</option>
                                <option value="Average">Average</option>
                                <option value="Friendly">Friendly</option>
                                <option value="Outstanding">Outstanding</option>
                            </select>
                        </div>

                        <!-- Policy Feedback -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Policy & Process Clarity</label>
                            <select name="policy_feedback" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Unclear">Unclear</option>
                                <option value="Confusing">Confusing</option>
                                <option value="Average">Average</option>
                                <option value="Clear">Clear</option>
                                <option value="Very Clear">Very Clear</option>
                            </select>
                        </div>

                        <!-- Price Feedback -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Price Satisfaction</label>
                            <select name="price_feedback" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Too Expensive">Too Expensive</option>
                                <option value="Expensive">Expensive</option>
                                <option value="Fair">Fair</option>
                                <option value="Affordable">Affordable</option>
                                <option value="Great Deal">Great Deal</option>
                            </select>
                        </div>

                        <!-- Comments -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Additional Comments</label>
                            <textarea name="comments" class="form-control" rows="3" required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-primary px-5 py-2 rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="js/booking_details.js"></script>
    </body>
</html>
