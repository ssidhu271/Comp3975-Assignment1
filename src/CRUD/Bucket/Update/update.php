<?php
require_once '../../../database_setup.php'; // Adjust the path as needed
require_once '../crud_operations.php';

$id = null;

$db = connect_database(); // Make sure this function correctly initializes your SQLite3 database

$stmt = $db->prepare("SELECT * FROM buckets WHERE bucket_id = ?");
if ($stmt === false) {
    die($db->lastErrorMsg());
}
$stmt->bindValue(1, $id, SQLITE3_INTEGER);
$result = $stmt->execute();

$bucket = $result->fetchArray(); // Fetch the bucket data

// PHP to handle form submission for buckets
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure $id is obtained from the posted form data
    $id = $_POST['id']; // This line is crucial

    $transaction_name = $_POST['transaction_name'];
    $category = $_POST['category'];

    // Update the existing bucket in the database
    $stmt = $db->prepare("UPDATE buckets SET transaction_name = ?, category = ? WHERE bucket_id = ?");
    $stmt->bindValue(1, $transaction_name, SQLITE3_TEXT);
    $stmt->bindValue(2, $category, SQLITE3_TEXT);
    $stmt->bindValue(3, $id, SQLITE3_INTEGER);
    $stmt->execute();

    // Redirect to the read page or another appropriate location
    header("Location: ../../Bucket/Read/read_html.php"); // Adjust the redirection path as necessary
    exit();
}
