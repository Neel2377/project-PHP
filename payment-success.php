<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "GET Data:<br>";
    print_r($_GET);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST Data:<br>";
    print_r($_POST);
    $transaction = explode("-",$_POST['transactionId']);
    print_r($transaction);
include_once('config.php');

    $orderId = $transaction[1];
    $newTransactionId = $transaction[0];

    // print_r($orderId);
    // print_r($newTransactionId);
    // exit();

    // Prepare the SQL query
    $sql = "UPDATE orders SET transaction_id = ?,payment_status = 1 WHERE order_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newTransactionId, $orderId);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Transaction ID updated successfully for order ID: $orderId";
        header("Location: home.php");
        exit();
    } else {
        echo "Error updating transaction ID for order ID: $orderId";
    }

    // Close statement
    $stmt->close();


// Close connection
$conn->close();
     
}

?>