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

    // Check if email and password match in the admin table (without hashing)
    $sql = "SELECT * FROM admin WHERE email ='$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Password is correct, set the user's email in a session variable
        $_SESSION['email'] = $email;
        $row = $result->fetch_assoc();
        $username = $row["username"];

        // Redirect to dashboard.php with a welcome message
        header("Location: dashboard.php?welcome=$username");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid email and password";
        
        // Redirect back to signin.php to display the error message
        header("Location: admin.php");
        exit();
    }

    $conn->close();
}
?>