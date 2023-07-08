<?php
session_start(); // Add session_start() at the beginning of the file

// Include server-side validation and registration logic
include 'Register_API.php';

// Define variables to store user inputs
$username = $firstName = $middleName = $lastName = $email = $password = '';

// Define array to store form validation errors
$errors = array();

// Handle form submission
if (isset($_POST['register_user'])) {
    // Get user inputs from the form
    $username = $_POST['username'];
    $firstName = $_POST['firstname'];
    $middleName = $_POST['middlename'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the register function
    register($username, $firstName, $middleName, $lastName, $email, $password);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: transparent;
            border: none;
            width: 40px;
            height: 40px;
            font-size: 30px;
            text-align: center;
            color: #000000;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease-in-out;
        }

        .back-button:hover {
            transform: scale(1.2);
        }

        .back-button::before {
            content: "<";
            display: block;
        }
    </style>
</head>

<body>
    <a href="Login.php" class="back-button"></a>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container col-xl-3 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center">Project Inventory</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="Register.php">
                        <?php include('errors.php'); ?>
                        <div class="form-outline input-group mb-2 mt-4">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="firstname" type="text" class="form-control" placeholder="First Name"
                                value="<?php echo $firstName; ?>">
                        </div>
                        <div class="form-outline input-group mb-2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="middlename" type="text" class="form-control" placeholder="Middle Name"
                                value="<?php echo $middleName; ?>">
                        </div>
                        <div class="form-outline input-group mb-2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="lastname" type="text" class="form-control" placeholder="Last Name"
                                value="<?php echo $lastName; ?>">
                        </div>
                        <div class="form-outline input-group mb-2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="username" type="text" class="form-control" placeholder="Username"
                                value="<?php echo $username; ?>">
                        </div>
                        <div class="form-outline input-group mb-2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input name="email" type="email" class="form-control" placeholder="Email"
                                value="<?php echo $email; ?>">
                        </div>
                        <div class="form-outline input-group mb-2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input name="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-outline input-group mb-4">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input name="confirm_password" type="password" class="form-control"
                                placeholder="Confirm Password">
                        </div>
                        <div class="text-center">
                            <div class="d-grid gap-2">
                                <button name="register_user" type="submit"
                                    class="my-3 mb-1 btn btn-primary btn-block btn-wide">
                                    Sign Up
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>
