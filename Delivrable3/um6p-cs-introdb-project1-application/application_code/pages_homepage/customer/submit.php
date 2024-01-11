<?php
include "../../dbpassword.php";

$HOSTNAME = 'localhost';
$USERNAME = 'root';
$DATABASE = 'gym';

$conn = new PDO("mysql:host=$HOSTNAME;dbname=$DATABASE", $USERNAME, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve feedback data from the form
    $feedbackTitle = $_POST["feedbackTitle"];
    $feedbackText = $_POST["feedbackText"];
    $customer_id = $_POST["customer_id"]; // Assuming customer_id is in the form

    try {
        $conn = new PDO("mysql:host=localhost;dbname=your_database_name", "your_username", "your_password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL statement to insert feedback
        $stmt = $conn->prepare("
            INSERT INTO feedback (f_title, f_text, customer_id)
            VALUES (:f_title, :f_text, :customer_id)
        ");

        $stmt->bindParam(':f_title', $feedbackTitle);
        $stmt->bindParam(':f_text', $feedbackText);
        $stmt->bindParam(':customer_id', $customer_id);

        $stmt->execute();

        echo "Feedback submitted successfully.";
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the connection
        $conn = null;
    }
}
?>
