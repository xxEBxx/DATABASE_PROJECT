<?php
    require_once "../../dbpassword.php";
    // Database connection parameters
    $host = "localhost"; // Change this if your database is on a different server
    $username = "root";
    //$password = "";
    $database = "gym";
    
    // Create a connection
    $conn = new mysqli($host, $username, $dbpassword, $database);
    
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (!debug_backtrace()) {
        echo "Connected successfully";
    }
    
    ?>