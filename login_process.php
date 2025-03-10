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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $con->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Fetch user from database
    $query = "SELECT * FROM `data` WHERE Email='$email'";
    $result = $con->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['Password'])) {
            // Start session and store user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['Full_Name'];
            $_SESSION['contact'] = $user['Contact_Number'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['gender'] = $user['Gender'];

            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            header("Location: login.php?error=Invalid email or password.");
            exit();
        }
    } else {
        header("Location: login.php?error=Invalid email or password.");
        exit();
    }
}

$con->close();
?>
