<?php
session_start();
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $checkEmailQuery = $conn->prepare("SELECT COUNT(*) FROM registration WHERE email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $checkEmailQuery->bind_result($count);
    $checkEmailQuery->fetch();
    $checkEmailQuery->close();

    $checkContactQuery = $conn->prepare("SELECT COUNT(*) FROM registration WHERE contact = ?");
    $checkContactQuery->bind_param("i", $contact);
    $checkContactQuery->execute();
    $checkContactQuery->bind_result($contactCount);
    $checkContactQuery->fetch();
    $checkContactQuery->close();

    
if ($count > 0) {
    $_SESSION['error_message'] = "Email already exists. Please choose another email";
        
    // Redirect back to signin.php to display the error message
    header("Location: signup.php");
    exit();
}
     elseif ($contactCount > 0) {
        $_SESSION['error_message'] = "Contact already exists. Please choose another contact";
        
        // Redirect back to signin.php to display the error message
        header("Location: signup.php");
        exit();
    } else {
        $hashedPassword = md5($password);
        $insertQuery = $conn->prepare("INSERT INTO registration (fullname, contact, email, password) VALUES (?, ?, ?, ?)");
        $insertQuery->bind_param("siss", $fullname, $contact, $email, $hashedPassword);
        $insertQuery->execute();
        echo  '<script>alert("Registration successful!"); window.location.href="signin.php"; </script>';
        $insertQuery->close();
    }

    $conn->close();
}
?>