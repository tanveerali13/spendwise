<?php

session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Clear all session data
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../logout.html");
exit();
?>