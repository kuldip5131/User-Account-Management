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

// Fetch user data from database
$sql = "SELECT Full_Name, Contact_Number, Email, Gender FROM `data` WHERE id='$user_id'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

// Update profile data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $con->real_escape_string($_POST['name']);
    $contact = $con->real_escape_string($_POST['contact']);
    $gender = $con->real_escape_string($_POST['gender']);

    // Update database
    $update_query = "UPDATE `data` SET Full_Name='$name', Contact_Number='$contact', Gender='$gender' WHERE id='$user_id'";

    if ($con->query($update_query) === TRUE) {
        $_SESSION['full_name'] = $name;
        $_SESSION['contact'] = $contact;
        $_SESSION['gender'] = $gender;

        // Redirect to profile with success message
        header("Location: profile.php?success=Profile updated successfully.");
        exit();
    } else {
        echo "Error updating profile: " . $con->error;
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
</head>

<body>
    <div class="bg-image">
        <div class="edit-contener">
            <div class="form-container">
                <h2 class="text-center">Edit Profile</h2>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name"
                            value="<?php echo htmlspecialchars($user['Full_Name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" name="contact"
                            value="<?php echo htmlspecialchars($user['Contact_Number']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label><br>
                        <input type="radio" name="gender" value="Male" <?php echo ($user['Gender'] == 'Male') ? 'checked' : ''; ?>> Male
                        <input type="radio" name="gender" value="Female" <?php echo ($user['Gender'] == 'Female') ? 'checked' : ''; ?>> Female
                        <input type="radio" name="gender" value="Other" <?php echo ($user['Gender'] == 'Other') ? 'checked' : ''; ?>> Other
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <a href="profile.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>