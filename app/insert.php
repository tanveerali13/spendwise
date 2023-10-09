<?php

session_start();

require_once "_includes/db_connect.php";

$userid = $_SESSION["user_id"];
$isloggedin = $_SESSION["loggedIn"];

$results = [];
$insertedRows = 0;

if (!$isloggedin) {
  header("Location: login.php");
}

try {
  if (!isset($_REQUEST["expense_name"]) || !isset($_REQUEST["amount"]) || !isset($_REQUEST["category_name"])) {
    throw new Exception('Required data is missing i.e. expense_name, amount, or category_name');
  } else {

    // Retrieve the category_id based on the provided category_name
    $categoryQuery = "SELECT category_id FROM category WHERE category_name = ?";
    if ($stmt = mysqli_prepare($link, $categoryQuery)) {
      mysqli_stmt_bind_param($stmt, 's', $_REQUEST["category_name"]);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $category_id);
      mysqli_stmt_fetch($stmt);
      mysqli_stmt_close($stmt);
    }

    // Insert the expense record with the retrieved Category ID
    $query = "INSERT INTO expense (added_on, expense_name, amount, details, category_id, user_id) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $query)) {
      mysqli_stmt_bind_param($stmt, 'ssisii', $_REQUEST["date"], $_REQUEST["expense_name"], $_REQUEST["amount"], $_REQUEST["details"], $category_id, $userid);
      mysqli_stmt_execute($stmt);
      $insertedRows = mysqli_stmt_affected_rows($stmt);

      if ($insertedRows > 0) {
        $results[] = [
          "insertedRows" => $insertedRows,
          "id" => $link->insert_id,
          "date" => $_REQUEST["date"],
          "expense_name" => $_REQUEST["expense_name"],
          "amount" => $_REQUEST["amount"],
          "details" => $_REQUEST["details"],
          "category_id" => $category_id,
          "user_id" => $userid,
        ];
      } else {
        throw new Exception("No rows were inserted");
      }
    } else {
      throw new Exception("Prepared statement did not insert records.");
    }
  }
} catch (Exception $error) {
  $results[] = ["error" => $error->getMessage()];
} finally {
  echo json_encode($results);
}
?>