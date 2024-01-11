<?php
session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer - GymLog</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
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
    }

    footer {
        flex-shrink: 0;
    }

    #hello {
        margin: 60px;
        height: 200px;
        text-align: center;
        color: white;
        background-image: url(./images/background_for_customer.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
    }
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="./home_trainer.php">
                <img src="./images/logo-light.png" alt="" width="200" >
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item ">
                        <a class="nav-link" href="details.php">My details </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sessions.php">My sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Find us</a>
                    </li>
                    <a class="btn btn-sm btn-outline-secondary" href="../../index.php">Log out</a>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div id="hello" class="text-center">
            <?php
            // Include db_connection.php to establish a database connection
            include 'connect.php';

            $my_id = $_SESSION['id']; 
            
            $query = "SELECT e_name FROM employee WHERE employee_id = $my_id";
            // Perform the query
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                $row = mysqli_fetch_assoc($result);

                // Display the name on the page
                echo " <h1 >Hello, {$row['e_name']}!</h1>";
            } else {
                // Handle the case where the query failed
                echo "<p>Error retrieving data from the database</p>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>

        <!-- Upcoming sessions : -->
        <div class="container mt-4 border border-danger rounded border-4">
            <?php
            include 'connect.php';

            try {
                $conn = new PDO("mysql:host=$host;dbname=$database", $username, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $trainer_id = 60;

                // Get the current date
                $currentDate = date('Y-m-d');

                // SQL query to get upcoming sessions for the trainer on the current day
                $session_query = "
            SELECT s.space_id, s.start_time, e.end_time, s.s_day, d.d_name
            FROM s_session s
            JOIN end_time_founder e ON s.s_day = e.s_day AND s.start_time = e.start_time
            JOIN discipline d ON s.discipline_id = d.discipline_id
            WHERE s.discipline_id IN (
                SELECT discipline_id
                FROM experts_in
                WHERE employee_id = :trainer_id
            )
            AND s.s_day = :current_date
            AND s.start_time > CURRENT_TIME();
        ";

                // Prepare and execute the session query
                $session_stmt = $conn->prepare($session_query);
                $session_stmt->bindParam(':trainer_id', $trainer_id);
                $session_stmt->bindParam(':current_date', $currentDate);
                $session_stmt->execute();

                // Fetch and display the upcoming sessions
                $sessions = $session_stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<div class='container mt-4'>";
                echo "<h2>Upcoming Sessions for Today</h2>";

                if (!empty($sessions)) {
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead class='thead-light'><tr><th>Space ID</th><th>Discipline Name</th><th>Start Time</th><th>End Time</th><th>Day</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($sessions as $session) {
                        echo "<tr>";
                        echo "<td>{$session['space_id']}</td>";
                        echo "<td>{$session['d_name']}</td>";
                        echo "<td>{$session['start_time']}</td>";
                        echo "<td>{$session['end_time']}</td>";
                        echo "<td>{$session['s_day']}</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p class='text-danger'>No upcoming sessions for today</p>";
                }

                echo "</div>";

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            $conn = null;
            ?>
        </div>
    </main>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="./images/logo_transparent.png" alt="" height="100">
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

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-GLhlTQ8iK6UqO5F0+PQdiSFtX81S/JnL6PEZ5Lc/6v5uUZbA6dFj0Ddd5S6YbSS"
        crossorigin="anonymous"></script>
</body>


</html>