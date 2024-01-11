<?php
include "../../dbpassword.php";
$HOSTNAME='localhost';
$USERNAME='root';

$DATABASE='gym';


$con = mysqli_connect($HOSTNAME,$USERNAME,$dbpassword,$DATABASE);
if(!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>