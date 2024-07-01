<?php
session_start();

?>

<?php
if (!isset($_SESSION['email'])) {
    header('Location: signin.php');
    exit();
}

$userEmail = $_SESSION['email'];
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM registration WHERE email ='$userEmail'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    // ... (Other form fields)

    // Insert order details into the database
    $insertOrderSql = "INSERT INTO orders (sr_no, order_no, name, email, contact, fuel_station, status, order_date_time)
                       VALUES ('$yourSrNoValue', '$yourOrderNoValue', '$fullName', '$email', '$contact', '$yourFuelStationValue', 'Pending', NOW())";

    if ($conn->query($insertOrderSql) === TRUE) {
        $orderId = $conn->insert_id;
        // Redirect to the order status page with the new order ID
        header("Location: status.php?orderId=$orderId");
        exit();
    } else {
        echo "Error inserting order details: " . $conn->error;
    }
}

// Rest of your HTML content goes here
?>


<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- Add Bootstrap CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Delivery Order Form</title>
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
</style>
</head>
   
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="image/logo.png" alt="Logo" width="80">
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
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="home.php">Profile</a>
            <a class="dropdown-item" href="history.php">Order History</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
    </li>
</ul>
            </div>
        </div>
    </nav>
   
    
<div class="container-fluid">
        <div class="row">

    <div class="container ">

        <h2 class="text-center mb-4"> Delivery Order Form</h2>

        <form action="manageorder.php" method="POST">
            
            <!-- Contact Information -->
            <div class="form-group">
                <label for="fullName">Full Name:</label>
                <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo $userData[ 'fullname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['email' ]; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="contact" class="form-control" id="contact" name="contact" value="<?php echo $userData[ 'contact']; ?>" required>
            </div>
            <!-- ... (Other form groups follow the same structure) -->
    <!-- State Dropdown -->
               <div class="form-group">
                  <label for="state">State</label>
                  <select class="form-control" name="state"  id="state-dropdown">
                  </select>
               </div>                        
               <div class="form-group">
                  <label for="city">City</label>
                  <select class="form-control" name="city"  id="city-dropdown">
                  </select>
               </div>
               
               
            <div class="form-group">
                <label for="fuelStation">Available Fuel Station:</label>
                <select class="form-control" name="fuelstation" id="fuelStation-dropdown">
                  
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="form-group">
                        <label for="latitude">Latitude:</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude:</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                    </div>
                    <div id="map" style="height: 400px; width: 100%;"></div>
                    <button type="button" class="btn btn-primary" onclick="getLocation()">Get Live Location</button>
                    <br><br>
            <div class="form-group">
                <label for="delivery-address">Delivery Address:</label>
                <textarea class="form-control" name="delivery-address" id="delivery-address"  rows="3" required></textarea>
            </div>
            <!-- Fuel Type Dropdown -->
           
            <div class="form-group">
                <label for="fuelType">Fuel Type:</label>
                <select class="form-control" id="fuelType" name="fuelType" required>
                <option value=""  selected>Select Fuel Type</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity (in liters):</label>
                    <input type="number" class="form-control"  id="quantity" placeholder="Enter quantity" name="quantity" required>
                    <input type="hidden" name="totalcost" class="totalCost">
                    <p id="totalCost"></p>
                </div>

                <div class="form-group col-md-6">
                    <label for="deliveryDateTime">Delivery Date and Time:</label>
                    <input type="datetime-local" class="form-control" id="deliveryDateTime" name="deliveryDateTime" required>
                </div>
            </div>

            <!-- ... (Other form groups follow the same structure) -->

            <!-- Payment Information Dropdown -->
            <div class="form-group">
                <label for="paymentMethod">Payment Information:</label>
                <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                <option value="" disabled selected>Select Payment Method</option>
                    <option value="Cash on delivery">Cash on delivery</option>
                    <option value="Credit Card">Debit Card</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="upi">UPI</option>
                </select>
                
    
            <div id="creditCardDetails" style="display: none;">
            <div class="form-group">
            <label for="cardNumber">Card Number:</label>
            <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
        </div>
        <div class="form-group">
            <label for="expirationDate">Expiration Date:</label>
            <input type="text" class="form-control" id="expirationDate" name="expirationDate" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV:</label>
            <input type="text" class="form-control" id="cvv" name="cvv" required>
        </div>
            </div>
            <input type="hidden" name="paymentMethodToken" id="paymentMethodToken" value=""> -->
            Terms and Conditions
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="agreeTerms" name="agreeTerms" required>
                <label class="form-check-label" for="agreeTerms">I agree to the terms and conditions of the fuel delivery service.</label>
            </div>

            <!-- <!-- Submit Button
            <button type="submit" class="btn btn-success">Submit Order</button>
        </form>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXrQRknZLrPQk87f8qd_bBLJDPTRrj4s&callback=initMap" async defer></script>
     -->

    <script type="text/javascript">
  var map;
  var marker;

  function initMap() {
    const myLatLng = { lat:23.195056, lng:72.6269321 };
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 16,
      center: myLatLng,
    });

    // Initialize marker here
    marker = new google.maps.Marker({
      position: myLatLng,
      map,
    });
  }

  window.initMap = initMap;

  function updateMapLocation(lat, lng) {
    var location = new google.maps.LatLng(lat, lng);

    // Update marker position
    marker.setPosition(location);

    // Pan to the new location
    map.panTo(location);
  }


  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // Update input fields
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;

        // Update the map with the new location
        updateMapLocation(latitude, longitude);
      });
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }
</script>


<script>
    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url: 'states.php',
            success: function(response) {
               
                $('#state-dropdown').html(response);
            }
        });

        $('#state-dropdown').change(function() {
            var stateId = $(this).val();

            $.ajax({
                type: 'GET',
                url: 'cities.php',
                data: { state_id: stateId },
                success: function(response) {
                    
                    $('#city-dropdown').html(response);
                }
            });
            
        });
    });
   
    </script>
    <!-- Add this code inside the existing script -->
    <script>
    // ... (existing code)

    $('#city-dropdown').change(function() {
        var cityId = $(this).val();

        $.ajax({
            type: 'GET',
            url: 'fuel_station.php',  // Corrected filename
            data: { city_id: cityId },
            success: function(response) {
                $('#fuelStation-dropdown').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching fuel stations:', error);
            }
        });
    });
</script>
<script>


        // $('#paymentMethod').change(function() {
        //     var selectedPaymentMethod = $(this).val();

        //     // Toggle visibility of credit card details based on the selected payment method
        //     if (selectedPaymentMethod === 'Debit Card' || selectedPaymentMethod === 'Credit Card') {
        //         $('#creditCardDetails').show();
        //     } else {
        //         $('#creditCardDetails').hide();
        //     }
        // });
        $('#fuelType, #quantity').change(function() {
            var fuelType = $('#fuelType').val();
            var quantity = parseFloat($('#quantity').val());
            var perLiterPrice;

            // Set per liter price based on fuel type
            if (fuelType === 'Petrol') {
                perLiterPrice = 96; // Replace with actual per liter price for petrol
            } else if (fuelType === 'Diesel') {
                perLiterPrice = 90; // Replace with actual per liter price for diesel
            }

            // Calculate total cost
            var totalCost = quantity * perLiterPrice;

            // Display total cost
            $('#totalCost').text('Total Cost: Rs.' + totalCost.toFixed(2));
            $('.totalCost').val(totalCost.toFixed(2));
            
        });
</script>

</body>
</html>
<?php include 'include/footer.php'; ?>

<?php 
$conn->close();
?>