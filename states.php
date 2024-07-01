<?php
// get_cities.php

// Establish a database connection (similar to your order.php)
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the state_id from the AJAX request
$stateId = $_POST['state_id'];

// Fetch states from the states table
$sql = "SELECT * FROM states";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $states = '<option value="" disabled selected>Select State</option>';
    while ($row = $result->fetch_assoc()) {
        $selected = ($stateId == $row['state_id']) ? 'selected' : '';
        $states .= '<option value="' . $row['state_id'] . '" ' . $selected . '>' . $row['state_name'] . '</option>';
    }
    echo $states;
} else {
    echo '<option value="" disabled>No states found</option>';
}

// Close the database connection
$conn->close();
?>