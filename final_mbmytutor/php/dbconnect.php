<?php
$servername = "localhost";
$username   = "moneymon_279199_mb_db";
$password   = "2{pd%UPP6bsT";
$dbname     = "moneymon_279199_mytutor_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
