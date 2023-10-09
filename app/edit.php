<?php

session_start();

//// Displaying errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "_includes/db_connect.php";

//Finding the category_id of the edited category_name
$categoryQuery = "SELECT category_id FROM category WHERE category_name = ?";

if ($stmt = mysqli_prepare($link, $categoryQuery)) {
    mysqli_stmt_bind_param($stmt, 's', $_GET["category_name"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $category_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Updating all the edited information including the category_id in the expense table
$query = "UPDATE expense SET added_on=?, expense_name=?, category_id=?, amount=?, details=? WHERE id=?";

if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, 'ssissi', $_GET["date"], $_GET["expense_name"], $category_id, $_GET["amount"], $_GET["details"], $_GET["id"]);
    mysqli_stmt_execute($stmt);
    $stmt->close();
}
?>