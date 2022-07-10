<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$email = $_POST['customer_email'];
$receiptid = $_POST['receipt_id'];

$sqlloadcart = "SELECT tbl_carts.cart_id, tbl_carts.course_id, tbl_carts.cart_qty, tbl_subjects.subject_name, tbl_subjects.subject_price, tbl_subjects.subject_qty 
FROM tbl_carts INNER JOIN tbl_subjects ON tbl_carts.course_id = tbl_subjects.subject_id WHERE tbl_carts.email = '$email' AND tbl_carts.payment_id = '$receiptid'";


$result = $conn->query($sqlloadcart);
$number_of_result = $result->num_rows;
if ($result->num_rows > 0) {
    //do something
    $total_payable = 0;
    $carts["cart"] = array();
    while ($rows = $result->fetch_assoc()) {
        
        $crlist = array();
        $crlist['cartid'] = $rows['cart_id'];
        $crlist['crname'] = $rows['subject_name'];
        $crprice = $rows['subject_price'];
        $crlist['crqty'] = $rows['subject_qty'];
        $crlist['crice'] = number_format((float)$crprice, 2, '.', '');
        $crlist['cartqty'] = $rows['cart_qty'];
        $crlist['crid'] = $rows['course_id'];
        $price = $rows['cart_qty'] * $crprice;
        $crlist['pricetotal'] = number_format((float)$price, 2, '.', ''); 
        array_push($carts["cart"],$crlist);
    }
    $response = array('status' => 'success', 'data' => $carts);
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