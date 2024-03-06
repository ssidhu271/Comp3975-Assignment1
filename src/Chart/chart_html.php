<?php

require_once '../../User/authenticate.php';
require_once '../PageConfig/navbar.php';
require_once '../database_setup.php';
$db = connect_database();

require_once './chart.php';

// $year = $_POST['year'] ?? date("Y");
$year = $_POST['year'] ?? null;

$availableYears = getAvailableYears($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Expense Summary</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container text-center">
        <h2 class="my-4">Expense Summary for <?php echo $year; ?></h2>

        <!-- Form to select year -->
        <form action="chart_html.php" method="post" class="form-inline my-2">
            <label for="year" class="mr-2">Enter Year:</label>
            <input type="number" id="year" name="year" min="1990" max="2099" step="1" value="<?php echo $year; ?>" class="form-control mr-2" />
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>

        <?php
        if ($year) {
            if (in_array($year, $availableYears)) {
                generateExpensePieChart($db, $year);
        ?>
                <div style="display: flex; justify-content: center;">
                    <?php generateExpenseSummaryTable($db, $year); ?>
                </div>
        <?php
            } else {
                echo "<p class='alert alert-warning'>The selected year is not available. Please select one of the following years: ";
                echo implode(", ", $availableYears);
                echo "</p>";
            }
        }
        ?>

        <button onclick="location.href='../index.php'" class="btn btn-secondary mt-4">Back</button>
    </div>
</body>

</html>