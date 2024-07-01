<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: admin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Define the SQL query
$sql = "SELECT * FROM orders WHERE order_status = 'Pending'";

// Execute the SQL query
$result = $conn->query($sql);

// Retrieve the welcome message if available
$welcomeMessage = isset($_GET['welcome']) ? " " . $_GET['welcome'] : "";

// Retrieve the profile photo URL
$profilePhoto = isset($_SESSION['profile_photo']) ? $_SESSION['profile_photo'] : 'image/u.png';

// Other dashboard.php code...

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- Add Bootstrap CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order history</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
.navbar-nav .nav-item.dropdown .dropdown-toggle::after {
    display: none; /* Hide the dropdown arrow */
  }


  .navbar-nav .nav-item.dropdown:hover .dropdown-menu a:hover {
    background-color: #28a745; /* Green background color */
    color: #ffffff !important; /* White text color */
  }

  .rounded-image {
            border-radius: 60%;
            max-width: 100%;
            height: auto;
        }

        .sidebar {
        height: 100vh; /* Set the height to 100% of the viewport height */
        /* You can also use a specific value like height: 500px; */
    }
        
</style>
</head>
   
<body class="bg-light">

    
        <div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-success sidebar">
            <div class="sidebar-sticky">
                <br>
            <img src="image/u.png" alt="User Image" class="rounded-image mx-auto d-block mb-3" width="80">
            <h4 class="mx-auto text-white text-center text-sm"><?php echo "" . $welcomeMessage . " " . $_SESSION['name'] . ""; ?></h4>
            <br>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="dashboard.php">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link dropdown-toggle collapsed text-truncate text-white" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">Order status</span></a>
                    <div class="collapse" id="submenu1" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">
                        <li class="nav-item"><a class="nav-link py-0 text-white" href="admin_history.php"><span>All</span></a></li>
                            <li class="nav-item"><a class="nav-link py-0 text-white" href="pending.php"><span>Pending</span></a></li>
                            <li class="nav-item"><a class="nav-link py-0 text-white" href="success.php"><span>Success</span></a></li>
                            <li class="nav-item"><a class="nav-link py-0 text-white" href="#"><span>Cancelled</span></a></li>
                        </ul>
                    </li>
                   
                    <li class="nav-item">
                   
                        <a class="nav-link text-white" href="admin.php">
                            Logout
                        </a>
            
                    </li>
                    
                </ul>
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
           
           
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXrQRknZLrPQk87f8qd_bBLJDPTRrj4s&callback=initMap" async defer></script>
    

    



</body>
</html>
