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
                    <li class="breadcrumb-item active text-primary">Blog & News</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

        <!-- Blog Start -->
        <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <?php
                        $conn = new mysqli("localhost", "root", "", "car_rental");
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0):
                            $delay = 0.1;
                            while ($row = $result->fetch_assoc()):
                    ?>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                        <div class="blog-item" style="border:1px solid #ccc; background:#f7f7f7; border-radius:8px;">
                            <div class="blog-img">
                                <img src="/cental-admin-dashboard/assets/img/<?php echo htmlspecialchars($row['image']); ?>" class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="blog-content rounded-bottom p-4">
                                <div class="blog-date"><?php echo date('d M Y', strtotime($row['created_at'])); ?></div>
                                <div class="blog-comment my-3">
                                    <div class="small"><span class="fa fa-user text-primary"></span><span class="ms-2"><?php echo htmlspecialchars($row['author']); ?></span></div>
                                    <div class="small"><span class="fa fa-comment-alt text-primary"></span><span class="ms-2">6 Comments</span></div>
                                </div>
                                <a href="layout.php?page=blog_details&id=<?php echo $row['id']; ?>" class="h4 d-block mb-3"><?php echo htmlspecialchars($row['title']); ?></a>
                                <p class="mb-3"><?php echo mb_substr(strip_tags($row['content']), 0, 120) . '...'; ?></p>
                                <a href="layout.php?page=blog_details&id=<?php echo $row['id']; ?>">Read More <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php
                            $delay += 0.2;
                            endwhile;
                    ?>
                    <?php else: ?>
                        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                            <h5 class="text-primary">No blog found.</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Blog End -->

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