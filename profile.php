<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete your account? This action cannot be undone.");
        }
    </script>
</head>

<body>
    <div class="bg-image">
        <div class="login-contener">
            <div class="form-container">
                <h2 class="text-center">User Profile</h2>
                <div class="p-4">
                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['full_name']); ?></p>
                    <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($_SESSION['contact']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($_SESSION['gender']); ?></p>

                    <a href="edit_profile.php" class="btn btn-primary">Edit</a>
                    <a href="login.php" class="btn btn-secondary">Logout</a>
                    <a href="delete_account.php" class="btn btn-danger" onclick="return confirmDelete();">Delete</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>