<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sessions</title>
    <!-- Include your provided stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="style_session.css" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
         @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Dancing+Script:wght@700&family=Handjet&family=Outfit:wght@300&family=Roboto:wght@100&family=Rubik+Bubbles&family=Ubuntu:wght@500&display=swap');
        body {
            padding: 20px;
            font-family: Bebas Neue;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="customer_home.php">
            <img src="../../img/logo-light.png" width="70" height="70" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="technician_details.php">My details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="technician_equipment.php">Equipment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Find us</a>
                </li>
                <a class="btn btn-sm btn-outline-secondary" href="../../index.php">Log out</a>
            </ul>
        </div>
    </nav>
    <?php
session_start();
require_once "../../dbpassword.php"; // Include your database credentials
$servername = "localhost";
$username = "root";
$dbname = "gym";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $technician_id = $_SESSION['id'];

    // Query to find equipment of which deadline is near
    $query_upcoming = "
        SELECT space_id, eb.barcode, equipment_id, last_check_date, DATEDIFF(DATE_ADD(last_check_date, INTERVAL check_interval_days DAY), CURDATE()) AS remaining_days
        FROM Equipment_details AS ed
        JOIN Equipment_barcode AS eb ON eb.barcode = ed.barcode
        JOIN Equipment_type_brand AS etb ON etb.e_type = eb.e_type AND etb.brand = eb.brand
        WHERE DATE_ADD(last_check_date, INTERVAL (check_interval_days - 5) DAY) <= curdate()
        AND curdate() <= DATE_ADD(last_check_date, INTERVAL check_interval_days DAY) 
        ORDER BY remaining_days, check_interval_days DESC;
    ";

    // Prepare and execute the query
    $stmt = $conn->prepare($query_upcoming);
    $stmt->execute();
    $equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the entire result set
    echo "<div class='container mt-4'>";
    echo "<h2>EQUIPMENT TO MAINTAIN</h2>";

    if (!empty($equipments)) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='thead-light'><tr><th>Space ID</th><th>Barcode</th><th>Equipment ID</th><th>Last Check Date</th><th>Remaining Days</th><th>Action</th></tr></thead>";
        echo "<tbody>";

        foreach ($equipments as $equipment) {
            $remainingDays = $equipment['remaining_days'];
            $textColorClass = ($remainingDays <= 1) ? 'text-danger' : '';

            echo "<tr>";
            echo "<td class='$textColorClass'>{$equipment['space_id']}</td>";
            echo "<td class='$textColorClass'>{$equipment['barcode']}</td>";
            echo "<td class='$textColorClass'>{$equipment['equipment_id']}</td>";
            echo "<td class='$textColorClass'>{$equipment['last_check_date']}</td>";
            echo "<td class='$textColorClass'>$remainingDays</td>";

            // Button to navigate to another page
            echo "<td><a href='technician_take.php?equipment_id={$equipment['equipment_id']}&barcode={$equipment['barcode']}&space_id={$equipment['space_id']}' class='btn btn-primary'>Take</a></td>";

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No upcoming equipment deadlines found.</p>";
    }

    echo "</div>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

<?php


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $technician_id = $_SESSION['id'];

    // Query to find equipment of which deadline is near
    $query = "
        Select technician_id,space_id ,maintains.barcode,maintains.equipment_id   
        from maintains 
        join equipment_details
        where technician_id=:id
        LIMIT 20;
    ";
    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $technician_id);
    $stmt->execute();
    $equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the entire result set
    echo "<div class='container mt-4'>";
    echo "<h2>MAINTAINED EQUIPMENTS</h2>";
    echo "This is a list of equipments that were lastly maintained by you";

    if (!empty($equipments)) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='thead-light'><tr><th>Barcode</th><th>Space ID</th><th>Equipment ID</th></thead>";
        echo "<tbody>";

        foreach ($equipments as $equipment) {
            
            echo "<tr>";
            echo "<td class='$textColorClass'>{$equipment['barcode']}</td>";
            echo "<td class='$textColorClass'>{$equipment['space_id']}</td>";
            echo "<td class='$textColorClass'>{$equipment['equipment_id']}</td>";

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No Equipment was last maintained by you</p>";
    }

    echo "</div>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>


<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="../../img/brand.png" alt="" width="60" height="60">
                <small class="d-block mb-3 text-muted">&copy; 2019-</small>
            </div>
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Our coaches</a></li>
                    <li><a class="text-muted" href="#">Our disciplines</a></li>
                    <li><a class="text-muted" href="#">Our spaces</a></li>

                </ul>
            </div>

            <div class="col-6 col-md">
                <h5>About us</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Contact</a></li>
                    <li><a class="text-muted" href="#">Location</a></li>
                    <li><a class="text-muted" href="#">Privacy</a></li>
                    <li><a class="text-muted" href="#">Terms</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
