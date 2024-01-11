<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GymLog</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
</head>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Dancing+Script:wght@700&family=Handjet&family=Outfit:wght@300&family=Roboto:wght@100&family=Rubik+Bubbles&family=Ubuntu:wght@500&display=swap');

  body {
    font-family: Bebas Neue;
  }

  .image-container {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* Typing effect :*/

  #typewriter-container {
    text-align: center;
  }

  #typewriter-text {
    overflow: hidden;
    border-right: 0.15em solid orange;
    white-space: nowrap;
    font-size: 2em;
    margin: 0 auto;
    letter-spacing: 0.15em;
    animation: typing 3.5s steps(40, end);
  }

  @keyframes typing {
    from {
      width: 0;
    }

    to {
      width: 100%;
    }
  }

  @keyframes blink-caret {

    from,
    to {
      border-color: transparent;
    }

    50% {
      border-color: grey;
    }
  }
</style>

<body>
  <div class="image-container">
    <img src="./img/logo_transparent.png" alt="Gym Logo" height="300">
  </div>


  <main>

    <!--Welcoming : -->
    <div id="typewriter-container">
      <div id="typewriter-text">Hey there! Welcome to GymLog,Your Gateway to a Healthier Lifestyle !</div>
    </div>

    <!-- Login for employee and customer: -->
    <div class="row justify-content-center align-items-center">
      <div class="col-sm-3 ">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Employee Portal</h5>
            <img src="./img/employee.jpg" alt="Employee" width="150" height="150">
            <p class="card-text">Streamline Gym Operations</p>
            <a href="./pages_homepage/login_employee.php" class="btn btn-dark">Login</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Member Portal</h5>
            <img src="./img/customer.jpg" alt="Customer" width="150" height="150">
            <p class="card-text">Your Gateway to Personalized Fitness</p>
            <a href="./pages_homepage/login_customer.php" class="btn btn-dark">Login</a>
          </div>
        </div>
      </div>
    </div>


  </main>

  <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">
        <img class="mb-2" src="./img/logo_transparent.png" alt="" height="100">
      </div>
      <div class="col-6 col-md">
        <h5>Features</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="./pages_homepage/coaches.php">Our coaches</a></li>
          <li><a class="text-muted" href="./pages_homepage/disciplines.php">Our disciplines</a></li>
          <li><a class="text-muted" href="./pages_homepage/spaces.php">Our spaces</a></li>

        </ul>
      </div>

      <div class="col-6 col-md">
        <h5>About us</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="#">Contact</a></li>
          <li><a class="text-muted" href="#">Location</a></li>
          <li><a class="text-muted" href="#">Privacy</a></li>
          <li><a class="text-muted" href="#">Terms</a></li>
        </ul>
      </div>
    </div>
  </footer>

  <!-- Bootstrap 5 JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu9Eo7kC8bNcF0gqo1BBl5T/Mb3I=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-eMN52oXIn3zW5PWvOe6Lpas0KPSvzuBAFOhPg5