<?php
session_start(); // Add session_start() at the beginning of the file

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login_user"])) {
    // Include the Login_API.php file
    require_once "Login_API.php";

    // Retrieve the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Call the login function from the Login_API.php file
    $user = login($username, $password);

    if ($user) {
        // Login successful, store username in session and redirect to Dashboard.php
        $_SESSION['username'] = $username;
        header("Location: Dashboard.php");
        exit();
    } else {
        // Login failed, show an error message or redirect back to the login page
        echo "Invalid login credentials!";
        // Add your desired code here for a failed login
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0e7b96;
            border-bottom: 1px solid #0e7b96;
        }
        .card-title {
            color: #ffffff;
        }
        .form-control {
            border-radius: 6px;
            border-color: #ced4da;
        }
        .btn-primary {
            background-color: #0e7b96;
            border-color: #0e7b96;
        }
        .btn-primary:hover {
            background-color: #0c6a7f;
            border-color: #0c6a7f;
        }
        .btn-primary:focus,
        .btn-primary.focus {
            box-shadow: 0 0 0 0.2rem rgba(14, 123, 150, 0.5);
        }
        .btn-wide {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container col-xl-3 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center">Project Inventory</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="Login.php">
                        <div class="form-outline input-group mb-2 mt-4">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="username" type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-outline input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input name="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="text-center">
                            <div class="d-grid gap-2">
                                <button name="login_user" type="submit" class="my-3 mb-1 btn btn-primary btn-block btn-wide">
                                    Sign in
                                </button>
                            </div>
                            <div class="divider align-items-center my-0">
                                <p class="text-center fw-bold mx-3 mb-1 text-muted">OR</p>
                            </div>
                            <div class="d-grid gap-2 mb-4">
                                <a href="Register.php" class="btn btn-primary btn-block btn-wide" role="button">Create an Account</a>
                            </div>
                        </div>
                    </form>    
                </div>
            </div>  
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
