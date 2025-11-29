<?php
    $conn = new mysqli("localhost", "root", "", "car_rental");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id <= 0) {
        die("Invalid blog ID");
    }

    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();

    if (!$blog) {
        die("Blog post not found");
    }
?>

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
        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Cental Blog & News</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="layout.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="layout.php?page=blog">Blog & News</a></li>
                    <li class="breadcrumb-item active text-primary">Details</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

        <!-- Blog Content Start -->
        <div class="container py-5 blog-content">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="mb-4 text-center">
                        <h1 class="mb-3"><?php echo htmlspecialchars($blog['title']); ?></h1>
                        <p class="text-muted"><i class="fa fa-user text-primary"></i> <?php echo htmlspecialchars($blog['author']); ?> &nbsp; | &nbsp; <i class="fa fa-calendar-alt text-primary"></i> <?php echo date('F j, Y', strtotime($blog['created_at'])); ?></p>
                    </div>

                    <?php if (!empty($blog['image'])): ?>
                        <img src="/cental-admin-dashboard/assets/img/<?php echo htmlspecialchars($blog['image']); ?>"
                        alt="Blog Image"
                        class="img-fluid rounded mb-4 mx-auto d-block">
                    <?php endif; ?>

                    <div class="lead">
                        <?php
                            $content = str_replace('../assets/img/', '/cental-admin-dashboard/assets/img/', $blog['content']);
                            echo $content;
                        ?>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="javascript:void(0);" onclick="history.back();" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fa fa-arrow-left"></i> Back to Previous Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

        <!-- JavaScript Libraries -->
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