<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../database_setup.php';

// Handling file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['transactionFile'])) {
    $uploadDir = '../'; // Specify the directory where files should be uploaded
    $uploadFile = $uploadDir . basename($_FILES['transactionFile']['name']);

    // Check if the file is a CSV by checking its MIME type or extension (optional, for security)
    $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    if ($fileType !== 'csv') {
        $_SESSION['error-message'] = "Error: Only CSV files are allowed.";
        header("Location: ../index.php");
        exit;
    }

    if (!is_uploaded_file($_FILES['transactionFile']['tmp_name'])) {
        $_SESSION['error-message'] = "No file was uploaded.";
    } elseif (!is_writable($uploadDir)) {
        $_SESSION['error-message'] = "Upload directory is not writable.";
    } elseif (move_uploaded_file($_FILES['transactionFile']['tmp_name'], $uploadFile)) {
        echo "The file " . htmlspecialchars(basename($_FILES['transactionFile']['name'])) . " has been uploaded.";
        // Call the import function
        $db = connect_database();
        importCSVToSQLite($uploadFile, $db);
        $_SESSION['message'] = "The file has been uploaded and imported.";
        header("Location: ../index.php");
    } else {
        $_SESSION['error-message'] = "There was an error uploading your file.";
    }
} else {
    $_SESSION['error-message'] = "No file uploaded or wrong method used.";
}

header("Location: ../index.php");
exit;
