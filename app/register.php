<?php
//// Displaying errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

require_once "_includes/db_connect.php";

$results = [];

// Initialize a variable to keep track of the number of inserted rows
$insertedRows = 0;

// Use strip_tags to remove HTML tags from input fields
$username = strip_tags($_REQUEST["username"]);
$email = strip_tags($_REQUEST["email"]);
$password = strip_tags($_REQUEST["password"]);

// Check if the password is at least 8 characters long
if (strlen($password) < 8) {
    $results["success"] = false;
    $results["message"] = "Password should be at least 8 characters long.";
} else {
    // Check if the email already exists in the database
    $emailExists = emailExists($link, $email);

    if ($emailExists) {
        $results["success"] = false;
        $results["message"] = "Email already in use. Please use a different email or <a href='index.html'>login</a>.";
    } else {
        // If email is available and password is long enough, proceed with registration
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user data into the database
        $query = "INSERT INTO users (id, username, email, password) VALUES (NULL, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $query)) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

            // Execute the prepared statement
            mysqli_stmt_execute($stmt);

            // Get the number of affected rows
            $insertedRows = mysqli_stmt_affected_rows($stmt);

            if ($insertedRows > 0) {
                $results["success"] = true;

                // Set user data in the session (e.g., for displaying email)
                $_SESSION["user_id"] = mysqli_insert_id($link);
                $_SESSION["email"] = $email;

                // Set a cookie with user information (you can customize this)
                setcookie("user_email", $email, time() + 3600, "/"); // Cookie expires in 1 hour

                // Optionally, set additional cookie data as needed
                // setcookie("user_id", $_SESSION["user_id"], time() + 3600, "/");

                // Note: Be careful when storing sensitive information in cookies.
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    }
}

// Encode the results as JSON and send them as a response
echo json_encode($results);

// Function to check if email exists in the database
function emailExists($link, $email)
{
    $query = "SELECT email FROM users WHERE email=?";
    $stmt = mysqli_prepare($link, $query);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Store the result
    mysqli_stmt_store_result($stmt);

    // Get the number of rows returned
    $count = mysqli_stmt_num_rows($stmt);

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Return true if email exists, false otherwise
    return $count > 0;
}
?>