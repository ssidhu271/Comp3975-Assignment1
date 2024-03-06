<?php
require_once '../../../database_setup.php';

$db = connect_database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_name = $_POST['transaction_name'];
    $category = $_POST['category'];

    $stmt = $db->prepare("INSERT INTO buckets (transaction_name, category) VALUES (?, ?)");
    $stmt->bindValue(1, $transaction_name, SQLITE3_TEXT);
    $stmt->bindValue(2, $category, SQLITE3_TEXT);
    $stmt->execute();

    header("Location: ../Read/read_html.php");
    exit();
}
