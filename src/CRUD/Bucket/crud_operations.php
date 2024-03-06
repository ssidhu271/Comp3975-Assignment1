<?php

function get_bucket_id($db, $id)
{
    // Prepare the SQL SELECT statement
    $stmt = $db->prepare("SELECT * FROM buckets WHERE bucket_id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);

    // Execute the statement
    $result = $stmt->execute();

    // Fetch the transaction
    $transaction = $result->fetchArray(SQLITE3_ASSOC);

    return $transaction;
}
