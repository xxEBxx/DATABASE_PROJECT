<?php
session_start();
require_once "../../dbpassword.php"; // Include your database credentials
$servername = "localhost";
$username = "root";
//$password = "";
$dbname = "gym";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $equipment_id = $_GET['equipment_id'];
    $barcode = $_GET['barcode'];
    $technician_id = $_SESSION['id'];

    // Begin the transaction
    $conn->beginTransaction();

    try {
        // Query 1: Update equipment_details
        $query = "UPDATE equipment_details SET last_check_date = CURDATE() WHERE equipment_id=:equipment_id AND barcode=:barcode";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':equipment_id', $equipment_id);
        $stmt->bindParam(':barcode', $barcode);
        $stmt->execute();

        // Query 2: Insert into maintains
        $query1 = "
    INSERT INTO maintains (equipment_id, barcode, technician_id)
    VALUES (:equipment_id, :barcode, :id)
    ON DUPLICATE KEY UPDATE
    technician_id = :id;
";

        $stmt1 = $conn->prepare($query1);
        $stmt1->bindParam(':equipment_id', $equipment_id);
        $stmt1->bindParam(':barcode', $barcode);
        $stmt1->bindParam(':id', $technician_id);
        $stmt1->execute();

        // If both queries are successful, commit the transaction
        $conn->commit();

        // Redirect to technician_home.php after the transaction
        header("Location: technician_equipment.php");
        exit();
    } catch (PDOException $e) {
        // If an error occurs in the transaction, roll back
        $conn->rollBack();
        throw $e; // Re-throw the exception after rolling back
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
