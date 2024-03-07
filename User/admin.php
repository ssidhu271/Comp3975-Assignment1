<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

require_once '../src/database_setup.php';
require_once '../src/PageConfig/navbar.php';
$db = connect_database();
$unapproved_users = $db->query("SELECT user_id, email FROM users WHERE is_approved = 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <?php echo $message; ?>
        <h2 class="my-4">Admin User Approval</h2>
        <form method="post" action="./admin_backend.php">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Select</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $unapproved_users->fetchArray(SQLITE3_ASSOC)) : ?>
                        <tr>
                            <td><input type="checkbox" name="approve_user_ids[]" value="<?php echo $user['user_id']; ?>"></td>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <input type="submit" value="Approve Selected" class="btn btn-primary">
        </form>
        <button onclick="location.href='/src/index.php'" class="btn btn-secondary mt-3">Back</button>
    </div>
</body>

</html>