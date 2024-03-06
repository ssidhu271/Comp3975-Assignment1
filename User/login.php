<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/database_setup.php'; // Include your database setup file
$db = connect_database(); // Make sure you adjust this line according to how you set up and access your database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Don't hash yet, you'll need to verify it first

    // SQL to check if information is in the users table and the user is approved
    $stmt = $db->prepare("SELECT user_id, email, password_hash, is_approved, is_admin FROM users WHERE email = ?");
    $stmt->bindValue(1, $email, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    // Verify the password and the approval status
    if ($user && password_verify($password, $user['password_hash'])) {
        if ($user['is_approved'] == 1) {
            // Password is correct, and user is approved, set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['email'] = $user['email'];

            // Redirect to a protected page
            header("Location: ../src/index.php");
            exit();
        } else {
            $error = "Your account is pending approval.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}

// Include this check in all your files to ensure only logged-in users can access them
if (isset($_SESSION['user_id'])) {
    header("Location: ../src/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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
        <h2 class="text-center">Login</h2>
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post" class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required><br>
            <input type="submit" value="Login" class="btn btn-primary">
        </form>
        <button onclick="location.href='../index.php'" class="btn btn-secondary">Back</button>
    </div>
</body>

</html>