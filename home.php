<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>TodoList - Home</title>
    <style>
        main {
            flex: 1 0 auto;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">TodoList</a>
            <div>
                <?php
                session_start();

                if(isset($_SESSION['name'])){
                    echo "<a href='logout.php' class='btn btn-outline-danger'><i class='bi bi-box-arrow-right'></i> Logout</a>";
                } else {
                    echo "<a href='login.php' class='btn btn-outline-success me-2'><i class='bi bi-box-arrow-in-right'></i> Login</a>
                              <a href='registration.php' class='btn btn-outline-primary'><i class='bi bi-person-plus'></i> Sign Up</a>";
                }
                ?>
            </div>
        </div>
    </nav>
</header>

<main class="flex-shrink-0">
    <div class="container mt-5">
        <h1 class="text-center mb-5">Welcome to TodoList</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-list-check"></i> Task Management</h5>
                        <p class="card-text">Easily create, edit, and delete tasks. Stay organized with our intuitive task management system.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-calendar-date"></i> Due Dates</h5>
                        <p class="card-text">Set start and end dates for your tasks. Never miss a deadline with our built-in calendar feature.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-circle"></i> User Accounts</h5>
                        <p class="card-text">Create your personal account to keep your tasks private and synchronized across devices.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <?php
            if(!isset($_SESSION['name'])){
                echo "<a href='registration.php' class='btn btn-primary btn-lg'>Get Started</a>";
            } else {
                echo "<a href='dashboard.php' class='btn btn-primary btn-lg'>Go to Dashboard</a>";
            }
            ?>
        </div>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted">© 2024 TodoList. All rights reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>