<?php

require_once '../../../database_setup.php'; // Adjust the path as necessary to ensure correct inclusion

$db = connect_database(); // Make sure this function correctly initializes your SQLite3 database connection

// PHP to handle deletion from the buckets table
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL DELETE statement to target the buckets table
    $stmt = $db->prepare("DELETE FROM buckets WHERE bucket_id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);

    // Execute the statement
    $result = $stmt->execute();

    // Check for successful deletion
    if ($result) {
        // Success - redirect to a confirmation page or the buckets listing
        header("Location: ../Read/read_html.php?message=Bucket+deleted+successfully");
        exit;
    } else {
        echo "Error deleting bucket. Please try again.";
    }
} else {
    echo "No bucket ID provided.";
}
