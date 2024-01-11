<?php
session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <title>GYM </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
    require_once "../../dbpassword.php"; // Include your database credentials
    $servername = "localhost";
    $username = "root";
    //$password = "";
    $dbname = "gym";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id= $_SESSION['id'];

        // Fetch customer details based on ID
        $stmt = $conn->prepare("SELECT * FROM employee join technician WHERE employee.employee_id = :technician_id");
        $stmt->bindParam(':technician_id', $id);
        $stmt->execute();

        $technician_details = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>


    <div class="main-content">
        <div class="container mt-7">
            <!-- Table -->
            <div class="container mt-7">
                <!-- Table -->
                <h2 class="mb-5">My Account Card</h2>
                <div class="row">
                    <div class="col-xl-8 m-auto order-xl-1">
                        <div class="card bg-secondary shadow">
                            <div class="card-body">
                                <h6 class="heading-normal mb-4 text-center">Trainer's Information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label for="input-username">Username</label>
                                                <p class="form-control form-control-alternative"><?php echo $technician_details['e_name']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label for="input-last-name">My ID</label>
                                                <p class="form-control form-control-alternative"><?php echo $technician_details['employee_id']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label for="input-first-name">Salary</label>
                                                <p class="form-control form-control-alternative"><?php echo $technician_details['salary'] ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="input-email">Contact</label>
                                                <p class="form-control form-control-alternative"><?php echo $technician_details['contact']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr class="my-4">
                        <!-- additional info -->
                        <div class="card bg-secondary shadow">
                            <div class="card-body">
                                <h6 class="heading-normal mb-4 text-center">Additional information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label for="input-height">Height</label>
                                                <input type="text" id="input-height" class="form-control form-control-alternative" placeholder="height" value="ex:170">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label for="input-weight">Weight</label>
                                                <input id="input-weight" class="form-control form-control-alternative" placeholder="weight" value="ex:50" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6" class="style:margin-right :20px">
                                            <div class="form-group focused">
                                                <label for="input">Calculated BMI</label>
                                                <input type="text" id="input-bmi" class="form-control form-control-alternative" placeholder="BMI" readonly>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script>
                            // Function to calculate BMI
                            function calculateBMI() {
                                // Get height and weight values
                                var height = parseFloat(document.getElementById('input-height').value);
                                var weight = parseFloat(document.getElementById('input-weight').value);

                                // Check if height and weight are valid numbers
                                if (!isNaN(height) && !isNaN(weight)) {
                                    // Calculate BMI using the formula: BMI = weight (kg) / (height (m) * height (m))
                                    var bmi = weight / ((height / 100) * (height / 100));

                                    // Display the calculated BMI in the input field
                                    document.getElementById('input-bmi').value = bmi.toFixed(2);
                                } else {
                                    // If height or weight is not a valid number, display an error or handle accordingly
                                    alert('Please enter valid values for height and weight.');
                                }
                            }

                            // Attach the calculateBMI function to the input fields' onchange event
                            document.getElementById('input-height').addEventListener('change', calculateBMI);
                            document.getElementById('input-weight').addEventListener('change', calculateBMI);
                        </script>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
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