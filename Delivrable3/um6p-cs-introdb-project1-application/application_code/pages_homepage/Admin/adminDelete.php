<?php
include 'connect.php';

$membershipId = $_POST['membership_id'];

$con->begin_transaction();


try {

    $delH = $con->prepare("DELETE FROM has WHERE membership_id = ?");
    $delH->bind_param("i", $membershipId);
    $delH->execute();


    $delC = $con->prepare("DELETE FROM customer WHERE customer_id IN (SELECT customer_id FROM subscribed WHERE membership_id = ?)");
    $delC->bind_param("i", $membershipId);
    $delC->execute();


    $delS = $con->prepare("DELETE FROM subscribed WHERE membership_id = ?");
    $delS->bind_param("i", $membershipId);
    $delS->execute();


    $delM = $con->prepare("DELETE FROM membership WHERE membership_id = ?");
    $delM->bind_param("i", $membershipId);
    $delM->execute();

    $con->commit();
    header("Location: successDelete.html");
    exit();
} catch (Exception $e) {
    $con->rollback();
    echo "Error: " . $e->getMessage();
}

$con->close();

?>