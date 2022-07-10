<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");

// $result = $conn->query($sqlloadtutor);
$results_per_page = 5;
$search = $_POST['search'];
$page_first_result = ($pageno - 1) * $results_per_page;
// $sqlloadtutor = "SELECT tbl_tutors.tutor_id, tbl_tutors.tutor_email, tbl_tutors.tutor_phone, tbl_tutors.tutor_name, tbl_tutors.tutor_description, GROUP_CONCAT(tbl_subjects.subject_name ORDER BY tbl_subjects.subject_id ASC)
// FROM tbl_tutors, tbl_subjects WHERE tbl_tutors.tutor_id = tbl_subjects.tutor_id AND tbl_tutors.tutor_name LIKE '%$search%' GROUP BY tbl_tutors.tutor_id ASC";
    $sqlloadtutor = "SELECT * FROM tbl_tutors WHERE tutor_name LIKE '%$search%' ORDER BY tutor_id DESC";    

$result = $conn->query($sqlloadtutor);
$number_of_result = $result -> num_rows;
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlloadtutor = $sqlloadtutor . "LIMIT $page_first_result, $results_per_page";
$result = $conn->query($sqlloadtutor);
if($result -> num_rows > 0) {
    $tutor["tutor"] =array();
    while($row = $result->fetch_assoc()) {   
        $tutorList = array();
        $tutorList["tutor_id"] = $row["tutor_id"];
        $tutorList["tutor_email"] = $row['tutor_email'];
        $tutorList["tutor_phone"] = $row['tutor_phone'];
        $tutorList["tutor_name"] = $row['tutor_name'];
        $tutorList["tutor_description"] = $row['tutor_description'];
        // $tutorList["subject_name"] = $row['GROUP_CONCAT(tbl_subjects.subject_name ORDER BY tbl_subjects.subject_id ASC)'];
        array_push($tutor["tutor"],$tutorList);
    }
    $response = array('status' => 'success', 'pageno' => "$pageno", 'numofpage' => "$number_of_page", 'data' =>$tutor);
    sendJsonResponse($response);
}else{
    $response = array('status' => 'failed', 'pageno'=>"$pageno",'numofpage'=>"$number_of_page",'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray){
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

?>