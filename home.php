<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gofuelly</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* Custom CSS styles */
        .navbar-brand {
            color: #6dd855; /* Golden Yellow color */
        }

        #our-service {
            margin-bottom: -50px; /* Adjust this value to reduce space */
        }

        .contact-section {
            margin-top: 30px; /* Adjust this value to add space to the Contact Us section */
            background-color: lightgrey;
        }

        .service-overlay img {
            height: 300px; /* Set your desired height */
            width: 500px; /* Maintain aspect ratio */
        }

        /* Additional Custom Styles */
        .btn-order-now {
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            background-color: #6dd855; /* Golden Yellow color */
            color: #ffffff; /* White color */
            border: none;
        }

        .btn-order-now:hover {
            background-color: #5cb85c; /* Darker shade of yellow */
        }
    </style>
</head>

<body data-spy="scroll" data-target="#navbarNav" data-offset="50">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="image/logo.png" alt="Logo" width="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>

                </ul>


                <ul class="navbar-nav ms-auto">

                    <?php if (isset($_SESSION['email'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Welcome, <?php echo $_SESSION['name']; ?> </a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="logout.php" class="d-flex">
                                <button type="submit" class="btn btn-outline-light me-2">Logout</button>
                            </form>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php"> Sign up </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signin.php">sign in </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div>
        <img src="image/poster.png" alt="Poster" class="img-fluid" style="width: 100%; height: 600px;">
        <button type="button" class="btn btn-success btn-order-now" onclick="location.href='order.php'">Order
            Now</button>
    </div>
    <br>
    <section id="services">
        <div class="container text-center">
            <h3 class="section-heading">Our Services</h3>
            <p class="section-p">On-demand Fuel Delivery Services and Fuel Storage Solutions.</p>
            <div class="row justify-content-center">
                <div class="col-md-4 text-md-left mb-5">
                    <div class="service-overlay">
                        <img src="image/new.jpg" class="img-fluid">
                        <h5 class="service-h5">Fuel Delivery</h5>
                        <p class="service-p">India with unique challenge of uninterrupted power supply requires over 20
                            million residential</p>
                        <a class="service-a btn btn-primary" href="order.php">Order Now &gt;</a>
                    </div>
                </div>
                <div class="col-md-4 text-md-center mb-5">
                    <div class="service-overlay">
                        <img src="image/service2.png" class="img-fluid">
                        <h5 class="service-h5">Diesel-on-Tap</h5>
                        <p class="service-p">Smart fuel storage, monitoring and dispensing solution designed with the
                            market requirement</p>
                        <a class="service-a btn btn-primary" href="order.php">Order Now &gt;</a>
                    </div>
                </div>
                <div class="col-md-4 text-md-left mb-5">
                    <div class="service-overlay">
                        <img src="image/new2.jpg" class="img-fluid">
                        <h5 class="service-h5">Buddy Cans</h5>
                        <p class="service-p">Whether storing fuel for your power equipment or emergency, having the best
                            storage can for you helps.</p>
                        <a class="service-a btn btn-primary" href="order.php">Order Now &gt;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>


    <section id="contact-us" class="contact-section">
        <div class="container mt-5 text-center">
            <h2>Contact Us</h2>
            <p>Please fill the form below</p>

            <div class="row justify-content-center">
                <div class="col-md-6 text-md-left mx-auto">
                    <form id="contactForm" method="post">
                        <div class="form-group">
                            <input name="name" id="name" placeholder="Name* " title="Name" value=""
                                class="form-control input-text required-entry" type="text">
                        </div>
                        <br>
                        <div class="form-group">
                            <input name="email" id="email" placeholder="Email*" title="Email" value=""
                                class="form-control input-text required-entry validate-email" type="text">
                        </div>
                        <br>
                        <div class="form-group">
                            <input name="telephone" id="telephone" placeholder="Telephone*" title="Telephone" value=""
                                class="form-control input-text" type="text">
                        </div>
                        <br>
                        <div class="form-group">
                            <textarea name="comment" id="comment" placeholder="Comment" title="Comment"
                                class="form-control required-entry input-text" cols="5" rows="3"></textarea>
                        </div>
                        <br>
                        <div id="captchamsg"></div>
                        <table width="400" border="0" align="left" cellpadding="5" cellspacing="1" class="table"
                            style="margin-bottom:0"></table>

                        <div class="buttons-set text-center">
                            <button type="submit" onclick="submitcontactform(this)" title="Submit"
                                class="button btn btn-info">
                                <span><span>Submit</span></span>
                            </button>

                        </div>
                    </form>
                    <br>
                </div>

            </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Add custom JavaScript code here if needed
    </script>
<?php
include("include/footer.php")
?>
</body>

</html>
