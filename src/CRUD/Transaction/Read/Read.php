<?php
require_once '../../../database_setup.php';

$db = connect_database(); // Ensure this line is in the file that needs to create the `$db` object

function get_transactions($db)
{
    // Adjusted query for flexible matching
    $query = "SELECT t.*, b.category
              FROM transactions t
              LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%'";

    $results = $db->query($query);
    $transactions = [];
    if ($results) {
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $transactions[] = $row;
        }
    } else {
        echo "Query Error: " . $db->lastErrorMsg();
    }
    return $transactions;
}

function get_latest_balance($db)
{
    $result = $db->query("SELECT overall_balance FROM transactions ORDER BY transaction_date DESC, transaction_id DESC LIMIT 1");
    $row = $result->fetchArray();
    return $row ? $row['overall_balance'] : 0;
}

function get_transaction_id($db, $id)
{
    // Prepare the SQL SELECT statement
    $stmt = $db->prepare("SELECT * FROM transactions WHERE transaction_id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);

    // Execute the statement
    $result = $stmt->execute();

    // Fetch the transaction
    $transaction = $result->fetchArray(SQLITE3_ASSOC);

    return $transaction;
}

function get_last_balance_before($db, $date)
{
    // Prepare the SQL SELECT statement
    $stmt = $db->prepare("SELECT overall_balance FROM transactions WHERE transaction_date < ? ORDER BY transaction_date DESC LIMIT 1");
    $stmt->bindValue(1, $date, SQLITE3_TEXT);

    // Execute the statement
    $result = $stmt->execute();

    // Fetch the balance
    $balance = $result->fetchArray(SQLITE3_NUM);

    return $balance ? $balance[0] : 0;
}
