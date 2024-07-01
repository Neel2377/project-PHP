<?php
// Assuming you have a database connection established
$conn = new mysqli('localhost', 'root', '', 'test');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Sample data from the provided array
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$stateId = $_POST['state'];
$cityId = $_POST['city'];
$fuelStationId = $_POST['fuelstation'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$deliveryAddress = $_POST['delivery-address'];
$fuelType = $_POST['fuelType'];
$quantity = $_POST['quantity'];
$totalCost = $_POST['totalcost'];
$deliveryDateTime = $_POST['deliveryDateTime'];
$paymentMethod = $_POST['paymentMethod'];
$agreeTerms = isset($_POST['agreeTerms']) ? 1 : 0;

// Insert data into the orders table
$insertOrderSql = "INSERT INTO orders (full_name, email, contact, state_id, city_id, fuel_station_id, latitude, longitude, delivery_address, fuel_type, quantity, total_cost, delivery_date_time, payment_method, agreement_terms)
 VALUES ('$fullName', '$email', '$contact', $stateId, $cityId, $fuelStationId, $latitude, $longitude, '$deliveryAddress', '$fuelType', $quantity, $totalCost, '$deliveryDateTime', '$paymentMethod', '$agreeTerms')";

if ($conn->query($insertOrderSql) === TRUE) {
    $orderId = $conn->insert_id;

    // if($paymentMethod != "Cash on delivery"){
         

        $merchantId = 'PGTESTPAYUAT'; // sandbox or test merchantId
        $apiKey="099eb0cd-02cf-4e2a-8aca-3e6c6aff0399"; // sandbox or test APIKEY
        $redirectUrl = 'http://localhost:80/project/payment-success.php';
         
        // Set transaction details
        $order_id = uniqid(); 
        $name=$fullName;
        $email=$email;
        $mobile=$contact;
        $amount = $totalCost*100; // amount in INR
        $description = "Payment for $quantity of $fuelType";
         
        $merchantTransactionId = 'PHPSDK' . date("ymdHis") . "payPageTest-$orderId";
        $paymentData = array(
            'merchantId' => $merchantId,
            'merchantTransactionId' => $merchantTransactionId, // test transactionID
            "merchantUserId"=>"MUID123",
            'amount' => $amount,
            'redirectUrl'=>$redirectUrl,
            'redirectMode'=>"POST",
            'callbackUrl'=>$redirectUrl,
            "merchantOrderId"=>$orderId,
           "mobileNumber"=>$mobile,
           "message"=>$description,
           "email"=>$email,
           "shortName"=>$name,
           "paymentInstrument"=> array(
            "type"=> "PAY_PAGE",
          )
        );
         

        print_r($paymentData);
        // exit();
         
         $jsonencode = json_encode($paymentData);
         $payloadMain = base64_encode($jsonencode);
         $salt_index = 1; //key index 1
         $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
         $sha256 = hash("sha256", $payload);
         $final_x_header = $sha256 . '###' . $salt_index;
         $request = json_encode(array('request'=>$payloadMain));
                        
        $curl = curl_init();
        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
           CURLOPT_POSTFIELDS => $request,
          CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
             "X-VERIFY: " . $final_x_header,
             "accept: application/json"
          ],
        ]);
         
        $response = curl_exec($curl);
       
        $err = curl_error($curl);
         
        curl_close($curl);
         
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
           $res = json_decode($response);
         
        if(isset($res->success) && $res->success=='1'){
        $paymentCode=$res->code;
        $paymentMsg=$res->message;
        $payUrl=$res->data->instrumentResponse->redirectInfo->url;
       // print_r($payUrl);
  
        header('Location:'.$payUrl) ;
       
        }
        }
   // }
    // Redirect to the order status page with the new order ID
   // header("Location: status.php?orderId=$orderId");
    exit();
} else {
    echo "Error inserting order details: " . $conn->error;
}

$conn->close();
?>
