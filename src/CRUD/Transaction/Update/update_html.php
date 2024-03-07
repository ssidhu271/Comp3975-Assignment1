<?php
require_once '../../../../User/authenticate.php';
require_once '../../../PageConfig/navbar.php';
require_once './update.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

$id = $_GET['id'];
$transaction = get_transaction_id($db, $id); // You need to implement this function

// Convert the transaction date from the database to 'YYYY-MM-DD' format for the date input field.
$transaction_date = date('Y-m-d', strtotime($transaction['transaction_date']));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaction</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <form action="update.php" method="post" class="mb-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($transaction_date); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($transaction['name']); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="expense">Expense:</label>
                <input type="number" id="expense" name="expense" step="any" value="<?php echo htmlspecialchars(number_format($transaction['expense'], 2, '.', '')); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="income">Income:</label>
                <input type="number" id="income" name="income" step="any" value="<?php echo htmlspecialchars(number_format($transaction['income'], 2, '.', '')); ?>" class="form-control">
            </div>
            <input type="submit" value="Update" class="btn btn-primary">
        </form>
        <button onclick="window.location.href='../Read/read_html.php'" class="btn btn-secondary">Back</button>
    </div>

    <?php
    // Unset the form data after displaying it
    if (isset($_SESSION['form_data'])) {
        unset($_SESSION['form_data']);
    }
    ?>

</body>

</html>
<?php
require_once '../../../PageConfig/footer.php';
?>