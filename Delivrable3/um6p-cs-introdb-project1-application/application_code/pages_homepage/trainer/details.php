<?php
session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Trainer - My details </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Dancing+Script:wght@700&family=Handjet&family=Outfit:wght@300&family=Roboto:wght@100&family=Rubik+Bubbles&family=Ubuntu:wght@500&display=swap');

    body {
        font-family: Bebas Neue;
        display: flex;
        flex-direction: column;
        min-height: 100vh;

    }

    main {
        flex: 1;
        margin-top: 50px;
    }

    footer {
        flex-shrink: 0;
    }
    #showFormBtn{
        margin-top: 35px;
        margin-left: 80px;
    }

    #updateContactForm{
        padding: 20px;
    }
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="../home_trainer.php">
                <img src="../images/logo-light.png" alt="" width="200">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="./details.php">My details </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./sessions.php">My sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Find us</a>
                    </li>
                    <a class="btn btn-sm btn-outline-secondary" href="../../index.php">Log out</a>
                </ul>
            </div>
        </nav>
    </header>

    <!--Get our trainer details : -->
    <?php
    include 'connect.php';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $trainerId = $_SESSION['id']; // Replace with the actual trainer ID
    
        // Call the stored procedure :
        $stmt = $conn->prepare("CALL GetTrainerDetails(:trainerId)");
        $stmt->bindParam(':trainerId', $trainerId, PDO::PARAM_INT);
        $stmt->execute();

        $employeeDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        // Now $trainerDetails contains details of the trainer
    

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
    ?>



    <main>
        <div class="main-content">
            <div class="container mt-7">
                <!-- Table -->
                <div class="container mt-7">
                    <!-- Table -->
                    <div class="row">
                        <div class="col-xl-8 m-auto order-xl-1">
                            <div class="card bg-secondary shadow">
                                <div class="card-body">
                                    <h6 class="heading-normal mb-4 text-center">User Information</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label for="input-username">Username</label>
                                                    <p class="form-control form-control-alternative">
                                                        <?php echo $employeeDetails['e_name']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label for="input-last-name">My ID</label>
                                                    <p class="form-control form-control-alternative">
                                                        <?php echo $employeeDetails['employee_id']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label for="input-first-name">First day of work</label>
                                                    <p class="form-control form-control-alternative">
                                                        <?php echo $employeeDetails['first_day_work']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="input-email">Contact</label>
                                                    <p class="form-control form-control-alternative">
                                                        <?php echo $employeeDetails['contact']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label for="input-first-name">My salary</label>
                                                    <p class="form-control form-control-alternative">
                                                        <?php echo $employeeDetails['salary'] . ' DHS'; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <!-- HTML Form -->
                                                <button id="showFormBtn">Update Contact Info</button>

                                                <!-- Update form -->
                                                <form id="updateContactForm" style="display: none;" action="update_contact.php"
                                                    method="post">
                                                    <label for="newContact">New Contact Information:</label>
                                                    <input type="text" id="newContact" name="new_contact" required>
                                                    <button type="submit">Submit</button>
                                                </form>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </main>
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="../images/logo_transparent.png" alt="" height="100">
                <small class="d-block mb-3 text-muted">&copy; 2019-</small>
            </div>
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="./pages_homepage/coaches.php">Our coaches</a></li>
                    <li><a class="text-muted" href="/pages_homepage/disciplines.php">Our disciplines</a></li>
                    <li><a class="text-muted" href="/pages_homepage/spaces.php">Our spaces</a></li>

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


    <!-- Include Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-GLhlTQ8iK6UqO5F0+PQdiSFtX81S/JnL6PEZ5Lc/6v5uUZbA6dFj0Ddd5S6YbSS"
        crossorigin="anonymous"></script>
    <!-- Update salary : -->
    <script>
        // JavaScript to show/hide the update form
        $(document).ready(function () {
            $("#showFormBtn").click(function () {
                $("#updateContactForm").toggle();
            });
        });
    </script>

</body>

</html>