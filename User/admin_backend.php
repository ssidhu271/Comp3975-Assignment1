<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/database_setup.php';
require_once '../src/PageConfig/navbar.php';
$db = connect_database();

$message = '';
if (isset($_GET['approved']) && $_GET['approved'] == 1) {
    $message = '<div class="alert alert-success" role="alert">User has been approved!</div>';
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_user_ids'])) {
    $user_ids_to_approve = $_POST['approve_user_ids'];
    foreach ($user_ids_to_approve as $user_id) {
        $stmt = $db->prepare("UPDATE users SET is_approved = 1 WHERE user_id = ?");
        $stmt->bindValue(1, $user_id, SQLITE3_INTEGER);
        $stmt->execute();
    }
    $_SESSION['message'] = '<div class="alert alert-success" role="alert">' . count($user_ids_to_approve) . ' User(s) have been approved!</div>';
    header('Location: admin.php');
    exit;
}

$unapproved_users = $db->query("SELECT user_id, email FROM users WHERE is_approved = 0");

header('Location: ./admin.php');
exit;
