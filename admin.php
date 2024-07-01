<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('image/admin.jpeg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh; 
        }
        
    </style>
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto my-5">
                <div class="card" style="width: 450px;">
                    <div class="card-header bg-success text-white text-center">
                    <img src="image/logo2.png" alt="Admin Logo" style="max-width: 100px; max-height: 100px;"> 
                    <br>
                    <br>
                        <h3>Admin</h3>
                        <?php
                                // Display error message if exists
                                if (isset($_SESSION['error_message'])) {
                                    echo '<div style="color: red; text-align: center;">' . $_SESSION['error_message'] . '</div>';
                                    // Clear the error message from session
                                    unset($_SESSION['error_message']);
                                }
                                ?>
                    </div>
                    <div class="card-body mt-2 pb-4">
                        <form method="post" action="adminconnect.php">
                            <div class="form-group">
                                <label for="email">email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>