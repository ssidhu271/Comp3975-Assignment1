<?php

require "../Read/read.php";

// PHP to handle deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL DELETE statement
    $stmt = $db->prepare("DELETE FROM transactions WHERE transaction_id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);

    // Execute the statement
    $stmt->execute();

    // Redirect to the read page
    header("Location: ../../Transaction/Read/read_html.php?message=Transaction+deleted+successfully");
    exit;
}
