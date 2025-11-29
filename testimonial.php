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
        <link
            href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
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
        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Clients Reviews</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="layout.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Explore</a></li>
                    <li class="breadcrumb-item active text-primary">Testimonials</li>
                </ol>
            </div>
        </div>
        <!-- Header End -->

        <?php
            include 'connection.php';

            $stmt = $conn->prepare("
                SELECT f.*, u.full_name, u.image 
                FROM feedback f 
                JOIN users u ON f.user_id = u.id
                WHERE f.rating >= 4 AND u.role = 'customer'
                ORDER BY f.created_at DESC
            ");
            $stmt->execute();
            $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- Testimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <?php if (!empty($testimonials)): ?>
                    <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                        <?php foreach ($testimonials as $row): ?>
                            <div class="testimonial-item">
                                <div class="testimonial-quote">
                                    <i class="fa fa-quote-right fa-2x"></i>
                                </div>
                                <div class="testimonial-inner p-4 d-flex">
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="uploads/avatars/<?= htmlspecialchars($row['image']) ?>"
                                            class="img-fluid rounded-circle"
                                            style="width: 80px; height: 80px; object-fit: cover;"
                                            alt="<?= htmlspecialchars($row['full_name']) ?>">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded-circle"
                                            style="width: 80px; height: 80px;">
                                            <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="ms-4">
                                        <h4><?= htmlspecialchars($row['full_name']) ?></h4>
                                        <p><?= date('F j, Y', strtotime($row['created_at'])) ?></p>
                                        <div class="d-flex text-primary">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                $starClass = $i <= $row['rating'] ? 'text-primary' : 'text-body';
                                                echo '<i class="fas fa-star ' . $starClass . '"></i>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top rounded-bottom p-4">
                                    <p class="mb-0"><?= htmlspecialchars($row['comments']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="text-primary">No Testimonials Found.</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Testimonial End -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="js/home.js"></script>
    </body>
</html>
