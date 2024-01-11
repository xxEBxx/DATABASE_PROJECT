<?php
session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer - My sessions</title>
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

                    <li class="nav-item ">
                        <a class="nav-link" href="./details.php">My details </a>
                    </li>
                    <li class="nav-item active">
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

    <main>
        <!--My sessions display : -->
        <?php
        include 'connect.php';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$database", $username, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $trainer_id = $_SESSION['id'];

            // SQL query to select discipline IDs for a trainer
            $query = "
        SELECT DISTINCT d.discipline_id, d.d_name
        FROM discipline d
        JOIN experts_in e ON d.discipline_id = e.discipline_id
        WHERE e.employee_id = :trainer_id;
    ";

            // Prepare and execute the query
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':trainer_id', $trainer_id);
            $stmt->execute();

            // Fetch the discipline IDs and names
            $disciplines = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display sessions for each discipline
            foreach ($disciplines as $discipline) {
                $discipline_id = $discipline['discipline_id'];
                $discipline_name = $discipline['d_name'];

                echo "<div class='container mt-4'>";
                echo "<h2>Sessions for Discipline: $discipline_name</h2>";

                // SQL query to select sessions for a discipline
                $session_query = "
            SELECT s.space_id, s.start_time, e.end_time, s.s_day
            FROM s_session s
            JOIN end_time_founder e ON s.s_day = e.s_day AND s.start_time = e.start_time
            WHERE s.discipline_id = :discipline_id;
        ";

                // Prepare and execute the session query
                $session_stmt = $conn->prepare($session_query);
                $session_stmt->bindParam(':discipline_id', $discipline_id);
                $session_stmt->execute();

                // Fetch and display the sessions in a Bootstrap table
                $sessions = $session_stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($sessions)) {
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead class='thead-light'><tr><th>Space ID</th><th>Discipline Name</th><th>Start Time</th><th>End Time</th><th>Day</th></tr></thead>";
                    echo "<tbody>";

                    foreach ($sessions as $session) {
                        echo "<tr>";
                        echo "<td>{$session['space_id']}</td>";
                        echo "<td>$discipline_name</td>";
                        echo "<td>{$session['start_time']}</td>";
                        echo "<td>{$session['end_time']}</td>";
                        echo "<td>{$session['s_day']}</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>No sessions found for Discipline: $discipline_name</p>";
                }

                echo "</div>";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
        ?>

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
</body>

</html>