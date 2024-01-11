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
            <img src="logo-light.png" width="70" height="70" alt="">
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
                    <a class="nav-link" href="#">Feedback</a>
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

// Extract the values from the URL parameters
$space_id = $_GET['space_id'];
$equipment_id = $_GET['equipment_id'];
$barcode = $_GET['barcode'];
$technician_id = $_SESSION['id'];

// Display the equipment details in a small table
echo "<div class='container mt-4'>";
echo "<h2>Equipment Details</h2>";

echo "<table class='table table-bordered'>";
echo "<thead class='thead-light'><tr><th>Space ID</th><th>Barcode</th><th>Equipment ID</th><th>Technician ID</th></tr></thead>";
echo "<tbody>";
echo "<tr>";
echo "<td>$space_id</td>";
echo "<td>$barcode</td>"; // Switched position
echo "<td>$equipment_id</td>"; // Switched position
echo "<td>$technician_id</td>";
echo "</tr>";
echo "</tbody>";
echo "</table>";

// Buttons for 'Release' and 'Done'
echo "<div class='mt-3'>";
echo "<a href='technician_equipment.php'><button class='btn btn-danger'>Release</button></a>";
echo "<a href='technician_done.php?equipment_id=$equipment_id&barcode=$barcode'><button class='btn btn-success'>Done</button></a>";
echo "</div>";

echo "</div>";
?>





<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="brand.png" alt="" width="60" height="60">
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
