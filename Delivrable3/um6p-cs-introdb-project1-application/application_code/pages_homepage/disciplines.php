<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our disciplines - GymLog</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Dancing+Script:wght@700&family=Handjet&family=Outfit:wght@300&family=Roboto:wght@100&family=Rubik+Bubbles&family=Ubuntu:wght@500&display=swap');

    body {
        font-family: Bebas Neue;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;
    }

    footer {
        flex-shrink: 0;
    }

    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<body>
    <div class="image-container">
        <img src="../img/logo_transparent.png" alt="Gym Logo" height="100">
    </div>
    <main></main>
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
            <img class="mb-2" src="../img/logo_transparent.png" alt="" height="100">
                <small class="d-block mb-3 text-muted">&copy; 2019-</small>
            </div>
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="./pages_homepage/coaches.php">Our coaches</a></li>
                    <li><a class="text-muted" href="/pages_homepage/disciplines.php">Our disciplines</a></li>
                    <li><a class="text-muted" href="/pages_homepage/spaces.php">Our spaces</a></li>

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
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-GLhlTQ8iK6UqO5F0+PQdiSFtX81S/JnL6PEZ5Lc/6v5uUZbA6dFj0Ddd5S6YbSS"
        crossorigin="anonymous"></script>
</body>

</html>