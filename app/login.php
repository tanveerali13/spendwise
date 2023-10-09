<?php

session_start();

require_once "_includes/db_connect.php";

$results = [];

$loggedIn = false;

$usernameOrEmail = strip_tags($_REQUEST["username"]);
$password = strip_tags($_REQUEST["password"]);


// SQL query to fetch user information based on username or email
$query = "SELECT * FROM users WHERE username=? OR email=?";

if ($stmt = mysqli_prepare($link, $query)) {

    mysqli_stmt_bind_param($stmt, "ss", $usernameOrEmail, $usernameOrEmail);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Fetch the user data as an associative array
    $user = mysqli_fetch_assoc($result);

    // Check if a user with the given username/email exists and the password is correct
    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];

        $_SESSION["email"] = $user["email"];

        $_SESSION["loggedIn"] = true;

        // Set a success flag in the results array

        $results["success"] = true;

    } else {

        // If login fails, set an error message
        $results["success"] = false;

        $results["message"] = "Invalid username or password";

    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);

}

// Encode the results as JSON and send them as a response
echo json_encode($results);

?>