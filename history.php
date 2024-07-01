<?php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: signin.php');
    exit();
}

$userEmail = $_SESSION['email'];
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM orders WHERE email ='$userEmail'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
.navbar-nav .nav-item.dropdown .dropdown-toggle::after {
    display: none; /* Hide the dropdown arrow */
  }


  .navbar-nav .nav-item.dropdown:hover .dropdown-menu a:hover {
    background-color: #28a745; /* Green background color */
    color: #ffffff !important; /* White text color */
  }

  .status-pending {
            color: blue; /* Red text color */
        }

        .status-success {
            color: yellow; /* Green text color */
        }

</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="image/logo.png" alt="Logo" width="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="navbar-toggler-icon"></span>
</a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="home.php">Profile</a>
            <a class="dropdown-item" href="order.php">Order Fuel</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
    </li>
</ul>
            </div>
        </div>
    </nav>
<div class="container">
    <h2 class="text-center mb-4">Order History</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Fuel Type</th>
                <th>Status</th>
                <th>Order Date Time</th>
            </tr>
        </thead>
        <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $statusClass = '';
            switch ($row['order_status']) {
                case 'Pending':
                    $statusClass = 'status-pending';
                    break;
                case 'Success':
                    $statusClass = 'status-success';
                    break;
                case 'Cancelled':
                    $statusClass = 'status-cancelled';
                    break;
                default:
                    $statusClass = 'status-default';
                    break;
            }
            echo "<tr>";
            echo "<td>" . $row['order_id'] . "</td>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['contact'] . "</td>";
            echo "<td>" . $row['fuel_type'] . "</td>";
            echo "<td><span class='badge rounded-pill bg-" . $statusClass . "'>" . $row['order_status'] . "</span></td>";
            echo "<td>" . $row['order_date_time'] . "</td>";
            echo "</tr>";
            
        }
    } else {
        echo "<tr><td colspan='7'>No orders found</td></tr>";
    }
    ?>
</tbody>
        </table>
</div>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br>
<?php
include('include/footer.php');
?>