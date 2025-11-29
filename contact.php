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
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Cental Contact</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="layout.php">Home</a></li>
                    <li class="breadcrumb-item active text-primary">Contact</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->

        <!-- Contact Start -->
        <div class="container-fluid contact">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="row g-5 justify-content-center text-center">
                            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="contact-add-item p-4">
                                    <div class="contact-icon mb-4">
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>Mail Us</h4>
                                        <p class="mb-0">Khanhtngcc19208@fpt.edu.vn</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="contact-add-item p-4">
                                    <div class="contact-icon mb-4">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>Address</h4>
                                        <p class="mb-0">600 Nguyen Van Cu Street, P, Ninh Kieu, Can Tho, Vietnam</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="contact-add-item p-4">
                                    <div class="contact-icon mb-4">
                                        <i class="fa fa-phone-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>Telephone</h4>
                                        <p class="mb-0">0365207822</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="bg-secondary p-5 rounded">
                            <h4 class="text-primary mb-4 text-center">Send Your Message</h4>
                            <form method="POST" action="contact_message.php" id="contactForm">
                                <div class="row g-4">
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                            <label for="name">Your Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                            <label for="email">Your Email</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                                            <label for="phone">Your Phone</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="project" name="project" placeholder="Project">
                                            <label for="project">Your Project</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                                            <label for="subject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a message here" id="message" name="message" style="height: 160px" required></textarea>
                                            <label for="message">Message</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-light w-100 py-3">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 
                    <div class="col-12 col-xl-1 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="d-flex flex-xl-column align-items-center justify-content-center">
                            <a class="btn btn-xl-square btn-light rounded-circle mb-0 mb-xl-4 me-4 me-xl-0" href="https://www.facebook.com/khanh.tran.508735"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-xl-square btn-light rounded-circle mb-0 mb-xl-4 me-4 me-xl-0" href="https://www.instagram.com/khanhtran00/"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-xl-square btn-light rounded-circle mb-0 mb-xl-0 me-0 me-xl-0" href="https://www.linkedin.com/in/khanh-tr%E1%BA%A7n-ab6237222/"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-12 col-xl-5 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="p-5 bg-light rounded">
                            <div class="bg-white rounded p-4 mb-4"
                                onclick="changeMap('cs1')"
                                onmouseover="this.classList.add('bg-light')"
                                onmouseout="this.classList.remove('bg-light')"
                                style="cursor:pointer;">
                                <h4 class="mb-3">University of Greenwich Can Tho Campus 1</h4>
                                <div class="d-flex align-items-center flex-shrink-0 mb-3">
                                    <p class="mb-0 text-dark me-2">Address:</p><i class="fas fa-map-marker-alt text-primary me-2"></i><p class="mb-0">600 Nguyen Van Cu Street, Ninh Kieu, Can Tho, Vietnam</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-dark me-2">Telephone:</p><i class="fa fa-phone-alt text-primary me-2"></i><p class="mb-0">(+84) 365207822</p>
                                </div>
                            </div>
                            <div class="bg-white rounded p-4 mb-4"
                                onclick="changeMap('cs2')"
                                onmouseover="this.classList.add('bg-light')"
                                onmouseout="this.classList.remove('bg-light')"
                                style="cursor:pointer;">
                                <h4 class="mb-3">University of Greenwich Can Tho Campus 2</h4>
                                <div class="d-flex align-items-center mb-3">
                                    <p class="mb-0 text-dark me-2">Address:</p><i class="fas fa-map-marker-alt text-primary me-2"></i><p class="mb-0">160, 30/4 Street, Thoi Binh, Ninh Kieu, Can Tho, Vietnam</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 text-dark me-2">Telephone:</p><i class="fa fa-phone-alt text-primary me-2"></i><p class="mb-0">(+84) 365207822</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="rounded">
                            <iframe id="map-frame" class="rounded w-100" style="height: 400px;" 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3913.709553396942!2d105.72885387587061!3d10.013066189932079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a089c191c9270b%3A0x3c10c29b8cb0e5cf!2sGreenwich%20Vi%E1%BB%87t%20Nam%20-%20C%C6%A1%20s%E1%BB%9F%20C%E1%BA%A7n%20Th%C6%A1%201!5e0!3m2!1sen!2s!4v1717292740000!5m2!1sen!2s" 
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

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
        <script src="js/contact.js"></script>
    </body>
</html>