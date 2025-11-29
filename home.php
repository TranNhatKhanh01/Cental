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

        <!-- Flatpickr -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    </head>        
        
    <body>
        <?php include 'connection.php';?>

        <!-- Carousel Start -->
            <div class="header-carousel">
                <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="First slide"></li>
                        <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Second slide"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="img/carousel-2.jpg" class="img-fluid w-100" alt="First slide"/>
                            <div class="carousel-caption" id="continue-reservation">
                                <div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-labelledby="bookingSuccessLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-center">
                                            <div class="modal-body text-dark">
                                                Booking successful! We will contact you soon.
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-primary" id="bookingSuccessOk">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container py-4">
                                    <div class="row g-5">
                                        <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                            <div class="bg-secondary rounded p-5" style="max-height: 85vh; overflow-y: auto;">
                                                <h4 class="text-white mb-4">CONTINUE CAR RESERVATION</h4>
                                                <form class="booking-form" id="reservationForm">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <?php
                                                                $host = "localhost";
                                                                $username = "root";
                                                                $password = "";
                                                                $database = "car_rental";

                                                                $conn = new mysqli($host, $username, $password, $database);
                                                                if ($conn->connect_error) {
                                                                    die("Connection failed: " . $conn->connect_error);
                                                                }
                                                                $selectedCarId = isset($_GET['car_id']) ? $_GET['car_id'] : null;
                                                                $carName = 'Please select your car from below or from product !';

                                                                if ($selectedCarId && is_numeric($selectedCarId)) {
                                                                    $stmt = $conn->prepare("SELECT brand, model FROM cars WHERE id = ?");
                                                                    $stmt->bind_param("i", $selectedCarId);
                                                                    $stmt->execute();
                                                                    $stmt->bind_result($brand, $model);
                                                                    if ($stmt->fetch()) {
                                                                        $carName = $brand . ' ' . $model;
                                                                    }
                                                                    $stmt->close();
                                                                }
                                                            ?>
                                                            <div class="selected-car bg-light border rounded d-flex justify-content-between align-items-center px-3 py-2 <?php echo (isset($_GET['error']) && $_GET['error'] === 'car') ? 'border-danger border-2' : ''; ?>">
                                                                <span class="selected-car-name text-body"><?php echo htmlspecialchars($carName); ?></span>
                                                                <button type="button" class="clear-car btn btn-sm btn-close" style="display: <?php echo $selectedCarId ? 'inline-block' : 'none'; ?>"></button>
                                                                <input type="hidden" name="car_id" id="car_id" class="car-type-input" value="<?php echo $selectedCarId ?? ''; ?>">
                                                            </div>
                                                            <div class="invalid-feedback d-none">Please select your car from below or from product!</div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group border rounded bg-white">
                                                                <h6 class="text-dark">
                                                                    <i class="fas fa-clock"></i>
                                                                    Existing Bookings for This Car:
                                                                </h6>
                                                                <ul id="car-schedule-list" class="list-unstyled mb-0 text-primary small">
                                                                    <?php
                                                                    if ($selectedCarId && is_numeric($selectedCarId)) {
                                                                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                        $now = date('Y-m-d H:i:s');

                                                                        $stmt = $conn->prepare("
                                                                            SELECT b.start_date, b.end_date 
                                                                            FROM bookings b 
                                                                            LEFT JOIN feedback f ON f.booking_id = b.id
                                                                            WHERE b.car_id = ? 
                                                                            AND b.status != 'cancelled'
                                                                            AND (
                                                                                b.start_date > ? AND f.id IS NULL
                                                                            )
                                                                            ORDER BY b.start_date ASC
                                                                        ");
                                                                        $now = date('Y-m-d H:i:s');
                                                                        $stmt->bind_param("is", $selectedCarId, $now);
                                                                        $stmt->execute();
                                                                        $result = $stmt->get_result();

                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                $start = date('H:i d-m-Y', strtotime($row['start_date']));
                                                                                $end = date('H:i d-m-Y', strtotime($row['end_date']));
                                                                                echo "<li>From <strong>$start</strong> to <strong>$end</strong></li>";
                                                                            }
                                                                        }
                                                                        $stmt->close();
                                                                    } else {
                                                                        echo "<li>Please select a car first</li>";
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="input-group">
                                                                <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                    <span class="fas fa-map-marker-alt"></span> <span class="ms-1">Pick Up</span>
                                                                </div>
                                                                <input class="form-control" type="text" name="pickup" id="pickup" placeholder="Enter a location" required>
                                                                <div class="text-danger small" id="error-pickup"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="input-group">
                                                                <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                    <span class="fas fa-map-marker-alt"></span><span class="ms-1">Drop Off</span>
                                                                </div>
                                                                <input class="form-control" type="text" name="dropoff" id="dropoff" placeholder="Enter a location" required>
                                                                <div class="text-danger small" id="error-dropoff"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="input-group d-flex">
                                                                <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                    <span class="fas fa-calendar-alt"></span><span class="ms-1">Start Date</span>
                                                                </div>
                                                                <input class="form-control flex-grow-1" type="text" name="start_date" id="start_date" required>
                                                                <div class="text-danger small" id="error-start_date"></div>
                                                                
                                                                <input class="form-control ms-2" type="number" name="start_hour" id="start_hour" min="1" max="23" placeholder="HH" required style="max-width: 80px;">
                                                                <div class="text-danger small" id="error-start_hour"></div>
                                                                
                                                                <input class="form-control ms-2" type="number" name="start_minute" id="start_minute" min="0" max="59" placeholder="MM" required style="max-width: 80px;">
                                                                <div class="text-danger small" id="error-start_minute"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="input-group d-flex">
                                                                <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                                    <span class="fas fa-calendar-alt"></span><span class="ms-1">End Date</span>
                                                                </div>
                                                                <input class="form-control flex-grow-1" type="text" name="end_date" id="end_date" required>
                                                                <div class="text-danger small" id="error-end_date"></div>

                                                                <input class="form-control ms-2" type="number" name="end_hour" id="end_hour" min="1" max="23" placeholder="HH" required style="max-width: 80px;">
                                                                <div class="text-danger small" id="error-end_hour"></div>

                                                                <input class="form-control ms-2" type="number" name="end_minute" id="end_minute" min="0" max="59" placeholder="MM" required style="max-width: 80px;">
                                                                <div class="text-danger small" id="error-end_minute"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row align-items-center small">
                                                                <div class="col-md-6 d-flex gap-4 small">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_now" value="now" required>
                                                                        <label class="form-check-label text-white" for="pay_now">Pay Now</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_later" value="later">
                                                                        <label class="form-check-label text-white" for="pay_later">Pay Later</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 text-md-end mt-3 mt-md-0 small">
                                                                    <div class="form-check d-flex align-items-center gap-2">
                                                                        <input class="form-check-input mt-0" type="checkbox" id="agree_terms" name="agree_terms" required>
                                                                        <label class="form-check-label text-white mb-0" for="agree_terms">
                                                                            I agree to the 
                                                                            <a href="layout.php?page=terms#user-responsibilities" target="_blank" class="text-primary text-decoration-underline">
                                                                                Terms & Conditions
                                                                            </a>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2" id="payment-box" style="display: none;">
                                                            <div class="bg-light rounded p-3">
                                                                <h6 class="text-dark mb-2"><i class="fas fa-money-check-alt me-2"></i>Payment Details</h6>
                                                                <div class="mb-2">
                                                                    <input type="text" class="form-control form-control-sm" name="card_number" placeholder="Card Number (XXXX-XXXX-XXXX-XXXX)">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <input type="text" class="form-control form-control-sm" name="card_name" placeholder="Cardholder Name">
                                                                </div>
                                                                <div class="row g-2">
                                                                    <div class="col-4">
                                                                        <input type="month" class="form-control form-control-sm" name="expiry_date">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="month" class="form-control form-control-sm" name="expiry_date">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="password" class="form-control form-control-sm" name="cvv" placeholder="CVV">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="btn btn-light w-100 py-2" type="button" id="submitBooking">Book Now</button>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                            <div class="text-start">
                                                <h1 class="display-5 text-white">Have a chance to get 15% off your rental. Plan your trip now !</h1>
                                                <p>Treat yourself in USA</p>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Carousel End -->
            
        <!-- Car categories Start -->
            <div class="container-fluid categories bg-white">
                <div class="container pt-5 pb-5">
                    <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                        <h1 class="display-5 text-capitalize">The Best <span class="text-primary">Choices</span></h1>
                    </div>

                    <div class="categories-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
                        <?php
                            $conn = new mysqli("localhost", "root", "", "car_rental");
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                            $now = date('Y-m-d H:i:s');
                           
                            $sql = "
                                SELECT * FROM cars
                                WHERE id NOT IN (
                                    SELECT DISTINCT car_id FROM bookings
                                    WHERE status != 'cancelled'
                                )
                                ORDER BY brand ASC, model ASC
                            ";
                            
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                        ?>
                        <div class="categories-item p-4">
                            <div class="categories-item-inner">
                                <div class="car-img-wrapper">
                                    <img src="img/<?php echo $row['image']; ?>" class="img-fluid w-100 rounded-top" alt="Car Image" style="height: 200px; object-fit: cover;">
                                </div>
                                <div class="categories-content rounded-bottom p-4">
                                    <h4><?php echo $row['brand'] . ' ' . $row['model']; ?></h4>
                                    <div class="categories-review mb-4">
                                        <div class="me-3">4.5 Review</div>
                                        <div class="d-flex justify-content-center text-secondary">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star text-body"></i>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h4 class="bg-white text-primary rounded-pill py-2 px-4 mb-0">
                                            $<?php echo number_format($row['price_per_hour'], 2); ?>/Hour
                                        </h4>
                                    </div>
                                    <div class="row gy-2 gx-0 text-center mb-4">
                                        <div class="col-4 border-end border-white">
                                            <i class="fa fa-users text-dark"></i>
                                            <span class="text-body ms-1"><?php echo $row['seats']; ?> Seat</span>
                                        </div>
                                        <div class="col-4">
                                            <i class="fa fa-gas-pump text-dark"></i>
                                            <span class="text-body ms-1">Petrol</span>
                                        </div>
                                        <div class="col-4 border-end border-white">
                                            <i class="fa fa-car text-dark"></i>
                                            <span class="text-body ms-1"><?php echo $row['year']; ?></span>
                                        </div>
                                        <div class="col-4 border-end border-white">
                                            <i class="fa fa-cogs text-dark"></i>
                                            <span class="text-body ms-1">AUTO</span>
                                        </div>
                                        <div class="col-4 border-end border-white">
                                            <i class="fa fa-check-circle text-success"></i>
                                            <span class="fw-bold text-success">Available</span>
                                        </div>
                                    </div>
                                    <a href="layout.php?page=home&car_id=<?php echo $row['id']; ?>" class="btn btn-primary rounded-pill d-flex justify-content-center py-3">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                                endwhile;
                            else:
                                echo "<p class='text-center'>No cars available at the moment.</p>";
                            endif;
                        ?>
                    </div>

                    <div class="text-center mt-4 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="layout.php?page=cars" class="btn btn-outline-primary rounded-pill px-5 py-3">View More Cars</a>
                    </div>
                </div>
            </div>
        <!-- Car categories End -->

        <!-- Blog Start -->
            <div class="container-fluid blog py-5 bg-white">
                <div class="container py-5">
                    <div class="text-center mx-auto pb-4" style="max-width: 800px;">
                        <h1 class="display-5 text-capitalize mb-3">Cental <span class="text-primary">Blog & News</span></h1>
                    </div>

                    <div class="categories-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
                        <?php
                            $conn = new mysqli("localhost", "root", "", "car_rental");
                            if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

                            $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 10";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                        ?>
                        <div class="blog-card shadow-sm rounded" style="border:1px solid #ccc; background:#f7f7f7; border-radius:8px;">
                            <div class="blog-img-wrapper">
                                <img src="/cental-admin-dashboard/assets/img/<?php echo htmlspecialchars($row['image']); ?>" 
                                    class="img-fluid rounded-top w-100" 
                                    alt="<?php echo htmlspecialchars($row['title']); ?>" 
                                    style="height:180px; object-fit:cover;">
                            </div>
                            <div class="blog-content p-3">
                                <div class="blog-date text-muted mb-1" style="font-size:0.8rem;">
                                    <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                                </div>
                                <div class="blog-author text-secondary mb-2" style="font-size:0.8rem;">
                                    <span class="fa fa-user"></span> <?php echo htmlspecialchars($row['author']); ?>
                                </div>
                                <a href="layout.php?page=blog_details&id=<?php echo $row['id']; ?>" 
                                class="h6 d-block mb-2 text-dark">
                                <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                                <p class="mb-2 small text-muted">
                                    <?php echo mb_substr(strip_tags($row['content']), 0, 100) . '...'; ?>
                                </p>
                            </div>
                        </div>
                        <?php
                                endwhile;
                            else:
                        ?>
                        <div class="text-center text-primary">No blog found.</div>
                        <?php endif; ?>
                    </div>

                     <div class="text-center mt-4 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="layout.php?page=blog" class="btn btn-outline-primary rounded-pill px-5 py-3">View More Blogs</a>
                    </div>
                </div>
            </div>

            <style>
            .blog-card {
                display: flex;
                flex-direction: column;
                transition: all 0.3s ease;
                border: 1px solid transparent;
                min-height: 360px;
            }

            .blog-card:hover {
                box-shadow: 0 8px 20px rgba(0,0,0,0.2);
                transform: translateY(-3px);
            }
        </style>
        <!-- Blog End -->

        <!-- Banner Start -->
            <div class="container-fluid banner pb-5 wow zoomInDown bg-white" data-wow-delay="0.1s">
                <div class="container pb-5">
                    <div class="banner-item rounded">
                        <img src="img/banner-1.jpg" class="img-fluid rounded w-100" alt="">
                        <div class="banner-content">
                            <h2 class="text-primary">Rent Your Car</h2>
                            <h1 class="text-white">Interested in Renting?</h1>
                            <p class="text-white">Don't hesitate and send us a message.</p>
                            <div class="banner-btn">
                                <a href="https://www.whatsapp.com/" class="btn-secondary rounded-pill py-3 px-4 px-md-5 me-2">WhatsApp</a>
                                <a href="layout.php?page=contact" class="btn-primary rounded-pill py-3 px-4 px-md-5 ms-2">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Banner End -->
         
        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="js/home.js"></script>

        <script>
            document.getElementById("submitBooking").addEventListener("click", function() {

                const form = document.getElementById("reservationForm");
                const formData = new FormData(form);

                fetch("booking_process.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        let modal = new bootstrap.Modal(document.getElementById("bookingSuccessModal"));
                        modal.show();

                        document.getElementById("bookingSuccessOk").onclick = function() {
                            window.location.href = "layout.php?page=home";
                        };
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    alert("Unexpected error occurred!");
                });
            });
        </script>
    </body>
</html>