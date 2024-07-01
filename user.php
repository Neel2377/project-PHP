<?php
session_start();
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Hash the password for comparison
    $hashedPassword = md5($password);

    // Check if email and password match in the registration table
    $sql = "SELECT * FROM registration WHERE email ='$email' AND password = '$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Set the user's email in a session variable
        while($row = $result->fetch_assoc()) {
            // remove all session variables

        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['fullname'];
        print_r($_SESSION);
        }
        
        header("Location: home.php");
        // Redirect to another page where you want to display the welcome message
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid email and password";
        
        // Redirect back to signin.php to display the error message
        header("Location: signin.php");
        exit();
    }

    $conn->close();
}
?>