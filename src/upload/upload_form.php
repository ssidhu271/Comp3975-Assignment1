<?php
require_once '../User/authenticate.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload CSV File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Upload Transaction CSV</h2>
                <form action="../src/upload/upload.php" method="post" enctype="multipart/form-data" class="form-group text-center">
                    <label for="transactionFile">Select CSV file to upload:</label>
                    <input type="file" name="transactionFile" id="transactionFile" class="form-control" required><br>
                    <input type="submit" value="Upload File" name="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

</body>

</html>