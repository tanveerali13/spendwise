<?php

session_start();

// Displaying errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "_includes/db_connect.php";


//DELETE query
$query = "DELETE FROM expense WHERE id = ?";

// Prepare the query
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 'i', $_GET["id"]);
mysqli_stmt_execute($stmt);

?>