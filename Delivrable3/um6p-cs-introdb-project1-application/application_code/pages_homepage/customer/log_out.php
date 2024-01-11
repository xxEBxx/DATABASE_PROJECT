<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Ensure that the cookie is deleted by setting an empty value and an expiration time in the past
setcookie(session_name(), '', time() - 3600, '/');

// Redirect to the login page or another relevant location
header("Location:../../index.php");
exit;
?>
