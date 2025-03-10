<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "profile";

// Connect to MySQL
$con = new mysqli($server, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Delete user data from database
$delete_query = "DELETE FROM `data` WHERE id='$user_id'";

if ($con->query($delete_query) === TRUE) {
    // Destroy session
    session_destroy();
    
    // Redirect to registration page with success message
    header("Location: index.php?success=Account deleted successfully.");
    exit();
} else {
    header("Location: profile.php?error=Failed to delete account.");
    exit();
}

$con->close();
?>
