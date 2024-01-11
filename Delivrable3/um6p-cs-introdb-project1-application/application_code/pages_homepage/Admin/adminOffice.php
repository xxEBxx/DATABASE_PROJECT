
<!DOCTYPE html>


<html>
<head>
    <title>My Office</title>
    <style>
        details {
        width: 80%;
        margin: 0 auto ;
        background: #282828;
        margin-bottom: .5rem;
        box-shadow: 0 .1rem 1rem -.5rem rgba(0,0,0,.4);
        border-radius: 5px;
        overflow: hidden;
        }

        summary {
        padding: 1rem;
        display: block;
        background: #333;
        padding-left: 2.2rem;
        position: relative;
        cursor: pointer;
        }

        p {
            margin-left:10px;
            font-family: Lucida Bright;
        }
        summary:before {
        content: '';
        border-width: .4rem;
        border-style: solid;
        border-color: transparent transparent transparent #fff;
        position: absolute;
        top: 1.3rem;
        left: 1rem;
        transform: rotate(0);
        transform-origin: .2rem 50%;
        transition: .25s transform ease;
        }


        details[open] > summary:before {
        transform: rotate(90deg);
        }


        details summary::-webkit-details-marker {
        display:none;
        }

        details > ul {
        padding-bottom: 1rem;
        margin-bottom: 0;
        }
        body {
        background: #222;
        height: 100vh;
        font-family: sans-serif;
        color: white;
        line-height: 1.5;
        letter-spacing: 1px;
        margin-top: 2rem;

        background-image: url('fitness-1882721_1920.jpg');
        height: 100%;
        width: 100%; 
        background-position: center; 
        background-repeat: no-repeat;
        background-size: cover;
        }
        h1 {
        position: relative;
        padding: 0;
        margin: 0;
        font-family: "Raleway", sans-serif;
        font-weight: 500;
        font-size: 50px;
        color: #ffffff;
        -webkit-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }

        h1 span {
        display: block;
        font-size: 0.5em;
        line-height: 1.3;
        }
        h1 em {
        font-style: normal;
        font-weight: 600;
        }
        .one h1 {
        text-align: center;
        text-transform: uppercase;
        padding-bottom: 5px;
        }

       

    </style>
</head>
<body>

<div class="one">
    <h1>My Office</h1>
</div>



<?php
//khas nakhd l id d admin on7to f $admin_id
include 'connect.php';
session_start();
$admin_id = $_SESSION['id'];
$space = $con->prepare("SELECT space_id FROM `e_admin` WHERE employee_id = ?");
$space->bind_param("i", $admin_id); 
$space->execute();

$result = $space->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $space_id = $row['space_id'];
} else {
    die('Query failed: ' . mysqli_error($con));
}


$state = $con->prepare("SELECT state_of_space FROM space WHERE space_id = ?");
$state->bind_param("i", $space_id);
$state->execute();

$result = $state->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $state_of_space = $row['state_of_space'];
} else {
    die('Query failed: ' . mysqli_error($con));
}

$offH = $con->prepare("SELECT office_start_time, office_end_time FROM office WHERE space_id = ?");
$offH->bind_param("i", $space_id); 
$offH->execute();

$result = $offH->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $office_start_time = $row['office_start_time'];
    $office_end_time = $row['office_end_time'];
} else {
    die('Query failed: ' . mysqli_error($con));
}

$stmt = $con->prepare("SELECT e_name FROM employee, e_admin WHERE employee.employee_id = e_admin.employee_id AND e_admin.space_id = ? AND employee.employee_id <> ?");
$stmt->bind_param("ii", $space_id, $admin_id); 
$stmt->execute();

$colleagues_names = $stmt->get_result();

?>

<details>
  <summary>Office Id</summary>
  <p><?php echo htmlspecialchars($space_id); ?></p>
</details>
<details>
  <summary>State</summary>
  <p><?php echo htmlspecialchars($state_of_space); ?>%</p>

</details>
<details>
  <summary>Office Hours</summary>
  <p>Starting time : <?php echo htmlspecialchars($office_start_time); ?></p>
  <p>Closing time :<?php echo htmlspecialchars($office_end_time); ?></p>
</details>
<details>
  <summary>Collegues</summary>
  <?php
    if ($colleagues_names) {
        while ($row = mysqli_fetch_assoc($colleagues_names)) {
            echo '<p>' . htmlspecialchars($row['e_name']) . '</p>';
        }
    } else {
        echo '<p>No colleagues found.</p>';
    }
    ?>
</details>
</div>
    
</body>
</html>