<?php
// Include db_connection.php to establish a database connection
include 'connect.php';

$my_id = 30; // Replace with the actual employee ID

// Assuming $employeeDetails is already defined
$employeeDetails = ['name' => 'John Doe', 'contact' => '123456789', 'salary' => '5000']; // Replace with the actual data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['new_contact'])) {
        // Retrieve the new contact information from the form
        $newContact = $_POST['new_contact'];

        // Update the contact information in the database (you may need to adjust this part based on your database structure)
        $updateQuery = "UPDATE employee SET contact = ? WHERE employee_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('si', $newContact, $my_id);
        $stmt->execute();

        // Refresh the page after updating the information
        header('Location: details.php');
        exit();
    }
}
?>