<?php

require_once '../../../database_setup.php';

$db = connect_database(); // Ensure this line is in the file that needs to create the `$db` object

function get_buckets($db)
{
    $query = "SELECT * FROM buckets";

    $results = $db->query($query);
    $buckets = [];
    if ($results) {
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $buckets[] = $row;
        }
    } else {
        echo "Query Error: " . $db->lastErrorMsg();
    }
    return $buckets;
}
