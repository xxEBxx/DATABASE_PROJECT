<?php
include "../../dbpassword.php";
$HOSTNAME='localhost';
$USERNAME='root';
$DATABASE='gym';

$conn = mysqli_connect($HOSTNAME,$USERNAME,$dbpassword,$DATABASE);
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>