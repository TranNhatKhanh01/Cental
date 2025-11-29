
<?php
    session_start();
    $loggedIn = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'customer';
    $fullName = $loggedIn ? $_SESSION['user']['full_name'] : '';
    $page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Cental - Car Rent Website</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- Modals -->
        <?php include 'modals/signin.php'; ?>
        <?php include 'modals/signup.php'; ?>
        <?php include 'modals/forgot-password.php'; ?>

        <!-- Navbar & Hero Start -->
        <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a href="" class="navbar-brand p-0">
                        <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i>Cental</h1>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav mx-auto py-0">
                            <a href="layout.php" class="nav-item nav-link <?= ($page == 'home') ? 'active text-danger fw-bold' : '' ?>">Home</a>
                            <a href="layout.php?page=cars" class="nav-item nav-link <?= ($page == 'cars') ? 'active text-danger fw-bold' : '' ?>">Product</a>
                            <a href="layout.php?page=blog" class="nav-item nav-link <?= ($page == 'blog') ? 'active text-danger fw-bold' : '' ?>">Blog & News</a>
                            <a href="layout.php?page=about" class="nav-item nav-link <?= ($page == 'about') ? 'active text-danger fw-bold' : '' ?>">About</a>
                            <a href="layout.php?page=contact" class="nav-item nav-link <?= ($page == 'contact') ? 'active text-danger fw-bold' : '' ?>">Contact</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link explore-toggle <?= in_array($page, ['service', 'testimonial']) ? 'active text-danger fw-bold' : '' ?>">
                                    Explore <i class="fas fa-chevron-down ms-1 arrow-icon"></i>
                                </a>
                                <div class="dropdown-menu m-0 ">
                                    <a href="layout.php?page=service" class="dropdown-item <?= ($page == 'service') ? 'text-danger fw-bold' : '' ?>">Service</a>
                                    <a href="layout.php?page=testimonial" class="dropdown-item <?= ($page == 'testimonial') ? 'text-danger fw-bold' : '' ?>">Testimonial</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2" id="authSection">
                            <?php if ($loggedIn): ?>
                                <div class="nav-item dropdown account-dropdown">
                                    <a href="#" class="btn btn-outline-primary rounded-pill py-2 px-4">
                                        <i class="fas fa-user me-2"></i>Account
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        <a href="layout.php?page=profile#info-profile" class="dropdown-item">
                                            <i class="fas fa-user-cog me-2"></i>Profile
                                        </a>
                                        <a href="#" class="dropdown-item sign-out">
                                            <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                                        </a>
                                    </div>
                                </div>
                                <a href="layout.php?page=history" class="btn btn-outline-primary rounded-pill py-2 px-4">
                                    <i class="fas fa-history me-1"></i> History
                                </a>
                            <?php else: ?>
                                <div class="nav-item dropdown account-dropdown">
                                    <a href="#" class="btn btn-outline-primary rounded-pill py-2 px-4">
                                        <i class="fas fa-user me-2"></i>Account
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end m-0">
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#loginModal">
                                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                        </a>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#signupModal">
                                            <i class="fas fa-user-plus me-2"></i>Sign Up
                                        </a>
                                    </div>
                                </div>
                                <a href="#" id="historyLink" class="btn btn-outline-primary rounded-pill py-2 px-4">
                                    <i class="fas fa-history me-1"></i> History
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <div class="main-content">
            <?php
                switch ($page) {
                    case 'contact': include 'contact.php'; break;
                    case 'about': include 'about.php'; break;
                    case 'blog': include 'blog.php'; break;
                    case 'service': include 'service.php'; break;
                    case 'cars': include 'cars.php'; break;
                    case 'testimonial': include 'testimonial.php'; break;
                    case 'profile': include 'profile.php'; break;
                    case 'terms': include 'terms&conditions.php'; break;
                    case '404': include '404.php'; break;
                    case 'history': include 'history.php'; break;
                    case 'booking_details': include 'booking_details.php'; break;
                    case 'blog_details': include 'blog_details.php'; break;
                    case 'home':
                    default: include 'home.php'; break;
                }
            ?>
        </div>

        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <div class="footer-item">
                                <h4 class="text-white mb-4">About Us</h4>
                                <p class="mb-3">Cental is a professional car rental system with a nationwide service network, offering both short-term and long-term rental solutions for individual and corporate customers.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Quick Links</h4>
                            <a href="layout.php?page=about"><i class="fas fa-angle-right me-2"></i> About</a>
                            <a href="layout.php?page=cars"><i class="fas fa-angle-right me-2"></i> Car Types</a>
                            <a href="layout.php?page=contact"><i class="fas fa-angle-right me-2"></i> Contact us</a>
                            <a href="layout.php?page=terms"><i class="fas fa-angle-right me-2"></i> Terms & Conditions</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Business Hours</h4>
                            <div class="mb-3">
                                <h6 class="text-muted mb-0">Mon - Friday:</h6>
                                <p class="text-white mb-0">09.00 am to 07.00 pm</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-0">Saturday:</h6>
                                <p class="text-white mb-0">10.00 am to 05.00 pm</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-0">Vacation:</h6>
                                <p class="text-white mb-0">All Sunday is our vacation</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Contact Information</h4>
                            <a href="https://www.google.com/maps/place/Greenwich+Vi%E1%BB%87t+Nam+-+C%C6%A1+s%E1%BB%9F+C%E1%BA%A7n+Th%C6%A1+1/@15.4553512,101.6861025,6z/data=!4m10!1m2!2m1!1sgreenwich+vi%E1%BB%87t+nam!3m6!1s0x31a089c191c9270b:0x3c10c29b8cb0e5cf!8m2!3d10.0130662!4d105.7310424!15sChRncmVlbndpY2ggdmnhu4d0IG5hbZIBCnVuaXZlcnNpdHmqAVsKDS9nLzExZnh4d2JzczkQASoNIglncmVlbndpY2goADIfEAEiG3NfwjNX-vFgJjMawc5FBQW1SfEGW1nkl7m9ijIYEAIiFGdyZWVud2ljaCB2aeG7h3QgbmFt4AEA!16s%2Fg%2F11lyxhs3tg?entry=ttu&g_ep=EgoyMDI1MDUyOC4wIKXMDSoASAFQAw%3D%3D"><i class="fa fa-map-marker-alt me-2"></i> 600 Nguyen Van Cu Street, Ninh Kieu, Can Tho, Vietnam</a>
                            <a href="mailto:Khanhtngcc19208@fpt.edu.vn"><i class="fas fa-envelope me-2"></i>Khanhtngcc19208@fpt.edu.vn</a>
                            <a href="tel:+84365207822"><i class="fas fa-phone me-2"></i>0365207822</a>
                            <a href="tel:+84365207822" class="mb-3"><i class="fas fa-print me-2"></i>0365207822</a>
                            <div class="d-flex">
                                <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-facebook-f text-white"></i></a>
                                <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-instagram text-white"></i></a>
                                <a class="btn btn-secondary btn-md-square rounded-circle me-0" href=""><i class="fab fa-linkedin-in text-white"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="js/layout.js"></script>
    </body>
</html>