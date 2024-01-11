<?php
include 'connect.php';
$membershipId = $_POST['membership_id'];


$dur = $con->prepare("SELECT duration FROM membership WHERE membership_id = ?");
$dur->bind_param("i", $membershipId); 
$dur->execute();

$result = $dur->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $duration = $row['duration'];
} else {
    die('Query failed: ' . mysqli_error($con));
}


$payment = $con->prepare("SELECT date_of_payment, type_of_payment FROM `subscribed` WHERE membership_id = ?");
$payment->bind_param("i", $membershipId); 
$payment->execute();
$result = $payment->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    $payment_date = $row['date_of_payment'];
    $payment_method = $row['type_of_payment'];
} else {
    die('Query failed: ' . mysqli_error($con));
}


$customer = $con->prepare("SELECT c.customer_id, c.c_name, c.birth_date, c.contact FROM customer AS c JOIN subscribed AS s ON c.customer_id = s.customer_id WHERE s.membership_id = ?");
$customer->bind_param("i", $membershipId);
$customer->execute();
$customer_details = $customer->get_result();

$discipline = $con->prepare("SELECT d_name FROM `discipline` WHERE discipline_id IN (SELECT discipline_id FROM `has` WHERE membership_id = ?)");
$discipline->bind_param("i", $membershipId);
$discipline->execute();

$result = $discipline->get_result();
$discipline_names = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $discipline_names[] = $row['d_name'];
    }
} else {
    die('Query failed: ' . mysqli_error($con));
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Membership Details</title>
    <style>

    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: black;
    color: #333;
    }
    p, li{
        color: white;
    }
    td {
        color:white;
    }
    .membership-details, .customer-table {
        margin: 20px;
        padding: 15px;
        background-color: #15172b;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
        color: #007bff;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #15172b;
    }
    </style>

    
</head>
<body>
    <div class="membership-details">
        <h1>Membership Details</h1>
        <p><strong>Membership ID:</strong> <span id="membership-id"><?php echo htmlspecialchars($membershipId); ?></span></p>
        <p><strong>Duration:</strong> <span id="duration"><?php echo htmlspecialchars($duration); ?> months</span></p>
        <p><strong>Date of Payment:</strong> <span id="payment-date"><?php echo htmlspecialchars($payment_date); ?></span></p>
        <p><strong>Method of Payment:</strong> <span id="payment-method"><?php echo htmlspecialchars($payment_method); ?></span></p>
        <p><strong>Discipline Names:</strong></p>
            <ul>
                <?php foreach ($discipline_names as $name): ?>
                    <li><?php echo htmlspecialchars($name); ?></li>
                <?php endforeach; ?>
            </ul>
    </div>

    <div class="customer-table">
        <h2>Customers in Membership</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while ($row = mysqli_fetch_assoc($customer_details)) {
                    echo "<tr>";
                    echo "<td><p>" . htmlspecialchars($row['customer_id']) . "</p></td>";
                    echo "<td><p>" . htmlspecialchars($row['c_name']) . "</p></td>";
                    echo "<td><p>" . htmlspecialchars($row['birth_date']) . "</p></td>";
                    echo "<td><p>" . htmlspecialchars($row['contact']) . "</p></td>";
                    echo "</tr>";
                }
            ?>

            </tbody>
        </table>
    </div>
</body>
</html>
