<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login page - GymLog</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
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

    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<body>

    <div class="image-container">
        <a href="../index.php">
            <img src="../img/logo_transparent.png" alt="Gym Logo" height="100">
        </a>

    </div>


    <main>
        <div class="row justify-content-center align-items-center ">
            <div class="col-md-4 border rounded border-4 border-dark m-5 p-4">
                <form action="login_employee.php" method="post">
                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>

                    <div class="form-group">
                        <label for="r_password">Password:</label>
                        <input type="password" class="form-control" id="r_password" name="r_password" maxlength="10"
                            required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">I am aware of and agree to the terms and
                            conditions.</label>
                    </div>

                    <button type="submit" class="btn btn-dark mt-2">Find role</button>
                </form>
            </div>
        </div>

    </main>


    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="../img/logo_transparent.png" alt="" height="100">
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
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-GLhlTQ8iK6UqO5F0+PQdiSFtX81S/JnL6PEZ5Lc/6v5uUZbA6dFj0Ddd5S6YbSS"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
session_start();
require_once "../dbpassword.php";
$servername = "localhost";
$username = "root";
//$password = "";
$dbname = "gym";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Assuming $contact and $password are user inputs (e.g., from a form)
    $contact = $_POST['contact']; // Replace with your actual input method
    $password = $_POST['r_password']; // Replace with your actual input method

    $stmt = $conn->prepare("SELECT * FROM hashed_password_infos WHERE contact = :contact");
    $stmt->bindParam(':contact', $contact);
    $stmt->execute();

    // get the result
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        echo "Contact does not exist";
    } 
    else if ($result[0]["p_role"] == "customer"){
        echo "Access denied: Contact of a customer";
    } else {
        if (md5($password) == $result[0]['hashed_password']) {
            if ($result[0]["p_role"]=="admin"){
                $admin = "SELECT e.employee_id as employee_id
                    FROM e_admin a
                    Join Employee e
                    WHERE e.contact = :contact";

                    $adminStmt=$conn->prepare($admin);
                    $adminStmt->bindParam(':contact', $contact);
                    $adminStmt->execute();

                $adminResult= $adminStmt->fetch(PDO::FETCH_ASSOC);
                print_r($adminResult);
                $_SESSION['id'] = $adminResult['employee_id'];
                header("Location: Admin/admin.html");
                exit();
        }
        else if ($result[0]["p_role"]=="technician"){
            $admin = "SELECT e.employee_id as employee_id
                FROM technician a
                Join Employee e
                WHERE e.contact = :contact";

                $adminStmt=$conn->prepare($admin);
                $adminStmt->bindParam(':contact', $contact);
                $adminStmt->execute();

            $adminResult= $adminStmt->fetch(PDO::FETCH_ASSOC);
            print_r($adminResult);
            $_SESSION['id'] = $adminResult['employee_id'];
            header("Location: Technician/technician_home.php");
            exit();
    }
    else if ($result[0]["p_role"]=="trainer"){
        $admin = "SELECT e.employee_id as employee_id
            FROM trainer a
            Join Employee e
            WHERE e.contact = :contact";

            $adminStmt=$conn->prepare($admin);
            $adminStmt->bindParam(':contact', $contact);
            $adminStmt->execute();

        $adminResult= $adminStmt->fetch(PDO::FETCH_ASSOC);
        print_r($adminResult);
        $_SESSION['id'] = $adminResult['employee_id'];
        header("Location: trainer/home_trainer.php");
        exit();
}
        exit();}
        else{
            echo "Invalid password";
        }
    }
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
