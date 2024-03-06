<?php

require_once '../../../database_setup.php';
require_once '../Read/Read.php';

$db = connect_database();

// PHP to handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $expense = empty($_POST['expense']) ? 0 : floatval($_POST['expense']);
    $deposit = empty($_POST['deposit']) ? 0 : floatval($_POST['deposit']);

    // Get the latest overall balance
    $latest_balance = get_latest_balance($db); // You need to implement this function

    // Calculate the new overall balance
    $new_balance = $latest_balance + $deposit - $expense;

    // Insert the new transaction into the database
    $stmt = $db->prepare("INSERT INTO transactions (transaction_date, name, expense, income, overall_balance) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $date, SQLITE3_TEXT);
    $stmt->bindValue(2, $name, SQLITE3_TEXT);
    $stmt->bindValue(3, $expense, SQLITE3_FLOAT);
    $stmt->bindValue(4, $deposit, SQLITE3_FLOAT);
    $stmt->bindValue(5, $new_balance, SQLITE3_FLOAT);
    $stmt->execute();

    // Redirect to the read page
    header("Location: ../Read/read_html.php");
    exit();
}
