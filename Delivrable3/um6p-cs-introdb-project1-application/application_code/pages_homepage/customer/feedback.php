<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2>Customer Feedback Form</h2>
    <form action="submit.php" method="post">
        <div class="form-group">
            <label for="feedbackTitle">Feedback Title:</label>
            <input type="text" class="form-control" id="feedbackTitle" name="feedbackTitle" required>
        </div>
        <div class="form-group">
            <label for="feedbackText">Feedback Text:</label>
            <textarea class="form-control" id="feedbackText" name="feedbackText" rows="4" required></textarea>
        </div>
        <!-- Add a hidden input for customer_id, you can get this dynamically based on the logged-in customer -->
        <input type="hidden" name="customer_id" value="1"> <!-- Replace with the actual customer ID -->

        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
