<?php
include 'connect.php';
if ($con->connect_error) {
    die("COnnection Failed: ". $con->connect_error);
}

// retrieve data :

$NoPeople = $_POST['person_involved'];
$duration = $_POST['duration'];
$payment_method = $_POST['paymentType'];
$disciplines = $_POST['disciplines']; 
$customers = [];
$curr_date = date("Y-m-d");

$con->begin_transaction();

try {
    $numM = $con->prepare("INSERT INTO `membership` (number_person_involved, duration) VALUES (?,?)");
    $numM->bind_param("ii", $NoPeople, $duration);
    $numM->execute();
    $membership_id = $con->insert_id;

    $customer_ids = [];
    for ($i = 0; $i < $NoPeople; $i++) {
        $newC = $con->prepare("INSERT INTO `customer` (c_name,registration_date,birth_date,contact) VALUES (?,?,?,?)");
        
        $name = $_POST["name$i"];
        $birthDate = $_POST["birthDate$i"];
        $phone = $_POST["contact$i"];
        $registration_date = $curr_date;
        
        $newC->bind_param("ssss",$name,$registration_date,$birthDate,$phone);
        $newC->execute();
        $customer_ids[] = $con->insert_id;
}   
        foreach ($customer_ids as $customer_id) {
            $newS = $con->prepare("INSERT INTO `subscribed` (payment_id, type_of_payment, date_of_payment, customer_id, membership_id) VALUES (?, ?, ?, ?, ?)");
            $paymentDate = $curr_date;
            $newS->bind_param("issii", $membership_id, $payment_method, $paymentDate, $customer_id, $membership_id);
            $newS->execute();
        }

        foreach ($disciplines as $discipline) {

            $discipline = "SELECT discipline_id FROM `discipline` WHERE d_name = '$discipline' ";
            $disciplineId = mysqli_query($con,$discipline);

            $row = $disciplineId->fetch_assoc();
            $DisciplineId = $row['discipline_id'];

            $newH = $con->prepare("INSERT INTO has (membership_id, discipline_id) VALUES (?, ?)");

            $newH->bind_param("ii", $membership_id, $DisciplineId);
            $newH->execute();
        }

    $con->commit();
    header("Location: successMembership.html");
    exit();
} catch (Exception $e){
    $con->rollback();
    echo "Error: " . $e->getMessage();
}

$con->close();

?>
