<?php

if(isset($_GET['city_id'])) {
    $cityId = $_GET['city_id'];

    // Establish a database connection
    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Fetch fuel stations based on the selected city
    $sql = "SELECT * FROM fuelstations WHERE city_id = '$cityId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $fuelStations = '<option value="" disabled selected>Select Fuel Stations</option>';
        while ($row = $result->fetch_assoc()) {
            $fuelStations .= '<option value="' . $row['station_id'] . '">' . $row['station_name'] . '</option>';
        }
        echo $fuelStations;
    } else {
        echo '<option value="" disabled>No fuel stations found</option>';
    }

    // Close the database connection
    $conn->close();
}
?>