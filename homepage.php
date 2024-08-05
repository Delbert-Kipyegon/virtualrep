<?php
session_start();
include 'php/db.php';
$unique_id = $_SESSION['unique_id'];
$email = $_SESSION['email'];
if (empty($unique_id)) {
    header("Location: login_page.html");
}
$qry = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    $first_name = $row['fname'];
    $phone = $row['phone'];
    $role = $row['Role'];
    $data = "20";
    $amount = "20";

    if ($row) {
        $_SESSION['Role'] = $row['Role'];
        if ($row['verification_status'] != 'Verified') {
            header("Location: verify.html");
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <link rel="stylesheet" href="css1/owl.carousel.min.css">
    <link rel="stylesheet" href="css1/fontAwsome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css1/style.css">
</head>

<body>

    <!--Navbar-->
    <nav style="background: #a200ff; " class="navbar navbar-expand-lg fixed-top">
        <!-- Brand -->
        <div class="container">
            <a href="#"
                style="display: flex; justify-content: center; align-items: center; width: 4.5rem; height: 4.5rem; overflow: hidden;">
                <img src="./img1/logo.png" alt="logo" style="max-width: 100% !important; max-height: 100% !important;">
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" data-scroll-nav="0" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        // Check if the user is an admin and set the dashboard link accordingly
                        if ($_SESSION['Role'] === 'admin') {
                            echo '<a class="nav-link" href="./task/admin_dashboard.php">Dashboard</a>';
                        } else {
                            echo '<a class="nav-link" href="./task/user_dashboard.php">Dashboard</a>';
                        }
                        ?>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-scroll-nav="5" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item logout-btn">
                        <a class="nav-link" href="php/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Home section start-->
    <section class="home d-flex  h-full  align-items-center" id="home" data-scroll-index="0">
        <div class="effect-wrap">
            <i class="fas fa-plus effect effect-1"></i>
            <i class="fas fa-plus effect effect-2"></i>
            <i class="fas fa-circle-notch effect effect-3"></i>
        </div>
        <div class="container h-full">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="home-text">
                        <h1>Welcome to VirtualRep, <?php echo $first_name; ?></h1>
                        <p>Congratulations on joining VirtualRep! You are now part of a dynamic platform where you can
                            earn good money by representing companies in online meetings. Check your dashboard for new
                            job assignments matched to your profile.

                        </p>
                        <div class="home-btn">
                            <a href="<?php echo ($_SESSION['Role'] === 'admin') ? './task/admin_dashboard.php' : './task/user_dashboard.php'; ?>"
                                target="_blank" class="btn btn-1">Dashboard</a>
                            <button type="button" class="btn btn-1 video-play-button" onclick="video_play()"><i
                                    class="fas fa-play"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-center">
                    <div class="home-img">
                        <div class="circle"></div>
                        <img class="landing-img" src="./zoom-fatique1.png" alt="Landing">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Home section End-->

    <!-- video pupup start -->
    <div class="video-popup" onclick="video_play()">
        <div class="video-popup-inner">
            <i class="fas fa-times video-popup-close"></i>
            <div class="iframe-box">
                <iframe id="player-1" src="https://www.youtube.com/embed/45izX9pkiiw"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <!-- video pupup End -->

    <!-- App Download Section Start -->
    <section class=" section-padding bg-white" data-scroll-index="3">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Check Your <span>Dashboard</span> </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="app-download-item">
                        <h3>Be Professional</h3>
                        <p>Always maintain a professional demeanor during meetings to build a good reputation and
                            receive positive feedback.

                        </p>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="app-download-item">
                        <h3>Upcoming Meetings</h3>
                        <p>Stay updated with your scheduled meetings and prepare accordingly.
                            Payment Status: Track your earnings and payment status easily.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="app-download-item">
                        <h3>Complete Your Profile</h3>
                        <p>Make sure your profile is complete and up-to-date to increase your chances of getting matched
                            with more assignments.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- App Download Section End -->

    <!-- Contact section start -->
    <section class="contact section-padding" data-scroll-index="5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Get in <span>Touch</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="contact-info">
                        <h3>For Any Queries an d Support</h3>
                        <div class="contact-info-item">
                            <i class="fas fa-location-arrow"></i>
                            <h4>Company Location</h4>
                            <p>845 Linn Ave, Oregon City, OR 97045</p>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <h4>Write to us at </h4>
                            <p>mail@virtualrep.online</p>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <h4>Call us on</h4>
                            <p>
                                +254 712 345 678
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="contact-form">
                        <form method="post" action="php/contact.php">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Your Name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Your Email" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" name="phone" placeholder="Your Phone" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" name="subject" placeholder="Your subject"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea placeholder="Your message" name="message"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-2">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact section End -->


    <!-- Footer section start -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>About Us</h3>
                        <p>Join VirtualRep and start making good money by representing Individuals or companies in
                            online meetings!
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>Company</h3>
                        <ul>
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#">Term & condition</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>Quik LInks</h3>
                        <ul>
                            <li>
                                <a href="#" data-scroll-nav="0">Home</a>
                            </li>


                            <li>
                                <a href="#" data-scroll-nav="5">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>Social Pages</h3>
                        <ul>
                            <li>
                                <a href="#">Facebook</a>
                            </li>
                            <li>
                                <a href="#">Twitter</a>
                            </li>
                            <li>
                                <a href="#">instegram</a>
                            </li>
                            <li>
                                <a href="#">Linkedin</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright-text">&copy; VirtualRep</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer section End -->

    <!-- Toggle Theme start ligt and dark mode  -->
    <div class="toggle-theme">
        <i class="fas">

        </i>
    </div>
    <!-- Toggle Theme End ligt and dark mode-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js1/owl.carousel.min.js"></script>
    <script src="js1/scrollIt.min.js"></script>
    <script src="js1/script.js"></script>


</body>

</html>