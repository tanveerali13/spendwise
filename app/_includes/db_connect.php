<?php

$host = "localhost:3306";
$user = "";
$pass = "";
$db = "tanveer_demo_db";

$link = mysqli_connect($host, $user, $pass, $db);

$db_response = [];
$dp_response['success'] = 'not set';
if (!$link) {
    $db_response['success'] = false;
} else {
    $db_response['success'] = true;
}

//echo json_encode($db_response);

?>