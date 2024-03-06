<?php

require_once '../../../../User/authenticate.php';
require "./create.php";
require_once '../../../PageConfig/navbar.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Bucket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="my-4">Create Bucket</h2>
        <form action="create.php" method="post" class="mb-3">
            <div class="form-group">
                <label for="transaction_name">Transaction Name:</label>
                <input type="text" id="transaction_name" name="transaction_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" class="form-control" required>
            </div>
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
        <button class="btn btn-secondary" onclick="window.location.href='../Read/read_html.php'">Back</button>
    </div>
</body>

</html>
<?php
require_once '../../../PageConfig/footer.php';
?>