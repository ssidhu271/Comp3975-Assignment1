<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/database_setup.php';
require_once '../src/PageConfig/navbar.php';
$db = connect_database(); // Connect to the database

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_user_id'])) {
    $user_id_to_approve = $_POST['approve_user_id'];
    $stmt = $db->prepare("UPDATE users SET is_approved = 1 WHERE user_id = ?");
    $stmt->bindValue(1, $user_id_to_approve, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">User has been approved!</div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">An error occurred.</div>';
    }

    header('Location: admin.php');
    exit;
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
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
    </div>
    <div class="container">
        <h2 class="my-4">Admin User Approval</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $unapproved_users->fetchArray(SQLITE3_ASSOC)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <form method="post" action="admin.php">
                                <input type="hidden" name="approve_user_id" value="<?php echo $user['user_id']; ?>">
                                <input type="submit" value="Approve" class="btn btn-primary">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button onclick="location.href='/src/index.php'" class="btn btn-secondary">Back</button>
    </div>
</body>

</html>