<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "profile";

// Connect to MySQL
$con = new mysqli($server, $username, $password);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Create database if it doesn't exist
$db_create = "CREATE DATABASE IF NOT EXISTS $database";
if ($con->query($db_create) === FALSE) {
    die("Error creating database: " . $con->error);
}

// Select the database
$con->select_db($database);

// Create the `data` table if it doesn't exist
$table_create = "CREATE TABLE IF NOT EXISTS `data` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `Full_Name` VARCHAR(255) NOT NULL,
    `Contact_Number` VARCHAR(20) NOT NULL,
    `Email` VARCHAR(255) NOT NULL UNIQUE,
    `Gender` VARCHAR(10) NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `DateTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($con->query($table_create) === FALSE) {
    die("Error creating table: " . $con->error);
}

// Insert registration data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $con->real_escape_string($_POST['name']);
    $contact = $con->real_escape_string($_POST['contact']);
    $email = $con->real_escape_string($_POST['email']);
    $gender = $con->real_escape_string($_POST['gender']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing password

    // Insert data into table
    $insert_query = "INSERT INTO `data` (Full_Name, Contact_Number, Email, Gender, Password) 
                     VALUES ('$name', '$contact', '$email', '$gender', '$password')";

    if ($con->query($insert_query) === TRUE) {
        // Redirect to login page with success message
        header("Location: login.php?success=1");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: index.php?error=Registration failed! Email may already exist.");
        exit();
    }
}

$con->close();
?>