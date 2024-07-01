<?php
// get_cities.php

// Establish a database connection (similar to your order.php)
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the state_id from the AJAX request
$stateId = $_GET['state_id'];

// Fetch cities based on the selected state
$sql = "SELECT * FROM cities WHERE state_id = '$stateId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cities = '<option value="" disabled selected>Select City</option>';
    while ($row = $result->fetch_assoc()) {
        $cities .= '<option value="' . $row['city_id'] . '">' . $row['city_name'] . '</option>';
    }
    echo $cities;
} else {
    echo '<option value="" disabled>No cities found</option>';
}

// Close the database connection
$conn->close();
?>