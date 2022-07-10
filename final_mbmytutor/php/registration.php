
<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
    $custname = addslashes($_POST['name']);
    $custemail = addslashes($_POST['email']);
    $custphone = $_POST['phone'];
    $state = addslashes($_POST['state']);
    $address = $_POST['address'];
    // $credit = 5;
    // $otp = rand(10000,99999);
    $base64image = $_POST['image'];
    $pass = $_POST['password'];
    $password = sha1($pass);
    
    $sqlinsert = "INSERT INTO `login_db`(`name`, `email`, `phone`, `address`, `state`, `pass`) 
    VALUES ('$custname','$custemail','$custphone','$state','$address','$password')";    
    if ($conn->query($sqlinsert) === TRUE) {
        $response = array('status' => 'success', 'data' => null);
        $filename = mysqli_insert_id($conn);
        $decoded_string = base64_decode($base64image);
        $path = '../assets/profile/' . $filename . '.jpg';
        $is_written = file_put_contents($path, $decoded_string);
        sendJsonResponse($response);
    } else {
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
    }
    
    function sendJsonResponse($sentArray)
    {
        header('Content-Type: application/json');
        echo json_encode($sentArray);
    }
    ?>

