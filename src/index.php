<?php

include 'database_setup.php';
require_once './PageConfig/navbar.php';
include './upload/upload_form.php';
require_once '../User/authenticate.php';

if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['message']) . "</div>";
    unset($_SESSION['message']); // Unset the message after displaying it
} elseif (isset($_SESSION['error-message'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['error-message']) . "</div>";
    unset($_SESSION['error-message']); // Unset the message after displaying it
}

$db = connect_database();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <button onclick="location.href='./CRUD/Transaction/Read/read_html.php'" class="btn btn-info my-2">View Transactions</button>
                <button onclick="location.href='./Chart/chart_html.php'" class="btn btn-info my-2">Chart</button>
                <button onclick="location.href='../src/CRUD/Bucket/Read/read_html.php'" class="btn btn-info my-2">View Bucket</button>
                <?php
                if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                    echo '<button onclick="location.href=\'../User/admin.php\'" class="btn btn-info my-2 mr-2">User Approval</button>';
                    // echo '<button onclick="location.href=\'../src/CRUD/Bucket/Read/read_html.php\'" class="btn btn-info my-2">View Bucket</button>';
                }
                ?>
                <div class="text-center">
                    <button onclick="location.href='../User/logout.php'" class="btn btn-dark my-2">Logout</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
require_once './PageConfig/footer.php';
?>