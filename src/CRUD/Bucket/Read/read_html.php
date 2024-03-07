<?php
require_once '../../../../User/authenticate.php';
require './read.php';
require_once '../../../PageConfig/navbar.php';

$db = connect_database();

$buckets = get_buckets($db);

if (isset($_GET['message'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_GET['message']) . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Buckets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="my-4">View Buckets</h2>
        <?php
        if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            echo '<button class="btn btn-primary mb-3" onclick="location.href=\'../Create/create_html.php\'">Create Bucket</button>';
        }
        ?>


        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Bucket ID</th>
                    <th>Transaction Name</th>
                    <th>Category</th>
                    <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                        echo '<th>Actions</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buckets as $bucket) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($bucket['bucket_id']); ?></td>
                        <td><?php echo htmlspecialchars($bucket['transaction_name']); ?></td>
                        <td><?php echo htmlspecialchars($bucket['category']); ?></td>
                        <td>
                            <?php
                            if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                                echo '<button class="btn btn-warning" onclick="location.href=\'../Update/update_html.php?id=' . htmlspecialchars($bucket['bucket_id']) . '\'">Update</button>';
                                echo '<button class="btn btn-danger" onclick="location.href=\'../Delete/delete.php?id=' . htmlspecialchars($bucket['bucket_id']) . '\'">Delete</button>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button class="btn btn-secondary mt-3" onclick="location.href='../../../index.php'">Back</button>
    </div>
</body>

</html>
<?php
require_once '../../../PageConfig/footer.php';
?>