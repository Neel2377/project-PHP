<?php
session_start();
include('include/header.php');
?>

    <div class="container-fluid text-left">
        <div class="row align-items-start">
            <div class="col">
                <div id="carouselExampleIndicators" class="carousel">
                    <div class="carousel-inner mt-1">
                        <div class="carousel-item active">
                            <img src="image/fd.png" class="d-block w-100" style="height: 550px;" alt="...">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-15">
                            <!-- Form Column -->
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title text-center" style="max-width: 150px; margin: auto; margin-top: 10px;">Sign In</h2>
                                    <?php
                                // Display error message if exists
                                if (isset($_SESSION['error_message'])) {
                                    echo '<div style="color: red; text-align: center;">' . $_SESSION['error_message'] . '</div>';
                                    // Clear the error message from session
                                    unset($_SESSION['error_message']);
                                }
                                ?>
                                <br>
                                    <form action="user.php" method="post">
                                        <br>
                                        <div class="col-md-10">
                                            <label for="email">Email-Id:</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <br>
                                        <div class="col-md-10">
                                            <label for="password">password:</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                        <br>
                                        <br>
                                        <p class="text-center">Don't have an account? <a href="signup.php">sign Up</a></p>
                                    </form>
                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            
    <?php

include('include/footer.php');
?>