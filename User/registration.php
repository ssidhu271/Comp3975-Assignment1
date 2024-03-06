<?php
// Start PHP session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/database_setup.php'; // Include your database setup file
$db = connect_database(); // Connect to the database

$message = '';

// If form is submitted, process the form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize user inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // You'll hash this, so no need to sanitize

    // Check if email already exists in the database
    $checkStmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $checkStmt->bindValue(1, $email, SQLITE3_TEXT);
    $result = $checkStmt->execute();
    $count = $result->fetchArray()[0] ?? 0;

    if ($count > 0) {
        // Email already exists
        $message = '<div class="alert alert-warning" role="alert">Email already registered. Please choose another one.</div>';
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
        $stmt->bindValue(1, $email, SQLITE3_TEXT);
        $stmt->bindValue(2, $password_hash, SQLITE3_TEXT);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Registration submitted for approval.</div>';
            header("Refresh: 5; url=../index.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">There was an error submitting your registration.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Add custom CSS to center the form -->
    <style>
        .form-container {
            max-width: 300px;
            margin: auto;
            padding-top: 100px;
        }

        .form-container .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container form-container text-center">
        <h2 class="text-center">Register</h2>
        <form action="registration.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <input type="submit" value="Register" class="btn btn-primary">
        </form>
        <button onclick="location.href='../index.php'" class="btn btn-secondary mt-3">Back</button>
    </div>
</body>

</html>