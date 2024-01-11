<?php
include 'connect.php';

$NoPeople = $_POST['person_involved'];
$duration = $_POST['duaration'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            padding: 20px;
        }

        form {
            background-color: #15172b;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #fff;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #fff;
            margin-top:8px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="date"],
        input[type="checkbox"]{
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #dddddd;
        }

        input[type="text"],
        input[type="tel"],
        input[type="date"],
        input[type="checkbox"] {
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #eeeeee;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>



<form method="post" action="submit_membership.php" id="details">
    <label for="paymentType">Type of Payment:</label>
    <select name="paymentType" id="paymentType" required>
        <option value="">--Select Payment Type--</option>
        <option value="credit_card">Credit Card</option>
        <option value="debit_card">Debit Card</option>
        <option value="cash">Cash</option>
        <option value="check">Check</option>
    </select>
    <input type="hidden" name="person_involved" value="<?php echo htmlspecialchars($NoPeople); ?>">
    <input type="hidden" name="duration" value="<?php echo htmlspecialchars($_POST['duration']); ?>">


    <?php for ($i = 0; $i < $NoPeople; $i++): ?>
        <div class="member-section">
            <h3>Member <?php echo $i + 1; ?></h3>
            <label for="name<?php echo $i; ?>">Name:</label>
            <input type="text" id="name<?php echo $i; ?>" name="name<?php echo $i; ?>" required><br>

            <label for="birthDate<?php echo $i; ?>">Birth Date:</label>
            <input type="date" id="birthDate<?php echo $i; ?>" name="birthDate<?php echo $i; ?>" required><br>

            <label for="contact<?php echo $i; ?>">Phone:</label>
            <input type="tel" id="contact<?php echo $i; ?>" name="contact<?php echo $i; ?>" required><br>
        </div>
        <hr>
    <?php endfor; ?>

    <input type="checkbox" name="disciplines[]" value="Cardio"> Cardio<br>
    <input type="checkbox" name="disciplines[]" value="Weightlifting"> Weightlifting<br>
    <input type="checkbox" name="disciplines[]" value="Yoga"> Yoga<br>
    <input type="checkbox" name="disciplines[]" value="Spin Class"> Spin Class<br>
    <input type="checkbox" name="disciplines[]" value="Pilates"> Pilates<br>
    <input type="checkbox" name="disciplines[]" value="CrossFit"> CrossFit<br>
    <input type="checkbox" name="disciplines[]" value="Zumba"> Zumba<br>
    <input type="checkbox" name="disciplines[]" value="Boxing"> Boxing<br>
    <input type="checkbox" name="disciplines[]" value="Bootcamp"> Bootcamp<br>
    <input type="checkbox" name="disciplines[]" value="Martial Arts"> Martial Arts<br>
    <input type="checkbox" name="disciplines[]" value="Aerobics"> Aerobics<br>
    <input type="checkbox" name="disciplines[]" value="Swimming"> Swimming<br>
    <input type="checkbox" name="disciplines[]" value="Barre"> Barre<br>
    <input type="checkbox" name="disciplines[]" value="Kickboxing"> Kickboxing<br>
    <input type="checkbox" name="disciplines[]" value="Plyometrics"> Plyometrics<br>
    <input type="checkbox" name="disciplines[]" value="Circuit Training"> Circuit Training<br>
    <input type="checkbox" name="disciplines[]" value="Functional Training"> Functional Training<br>
    <input type="checkbox" name="disciplines[]" value="Stretching"> Stretching<br>
    <input type="checkbox" name="disciplines[]" value="TRX"> TRX<br>
    <input type="checkbox" name="disciplines[]" value="HIIT"> HIIT<br>
    <div id="error-message" style="color: red;"></div>
    <input type="submit" value="Add All Members">
</form>

<script>
    document.getElementById('details').onsubmit = function() {
    var checkboxes = document.getElementsByName('disciplines[]');
    var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);

    if (!checkedOne) {
        document.getElementById('error-message').textContent = 'Please select at least one discipline.';
        return false;
    }

    document.getElementById('error-message').textContent = '';
    return true;
};
</script>
</body>
</html>


