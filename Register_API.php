<?php
// Include database configuration
include 'config.php';

// Function to register user
function register($username, $firstName, $middleName, $lastName, $email, $password)
{
    global $db;

    // Escape user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($db, $username);
    $firstName = mysqli_real_escape_string($db, $firstName);
    $middleName = mysqli_real_escape_string($db, $middleName);
    $lastName = mysqli_real_escape_string($db, $lastName);
    $email = mysqli_real_escape_string($db, $email);
    $password = mysqli_real_escape_string($db, $password);

    // Form validation: ensure that the form is correctly filled
    $errors = array();
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($firstName)) {
        array_push($errors, "First Name is required");
    }
    if (empty($lastName)) {
        array_push($errors, "Last Name is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if ($password != $_POST['confirm_password']) {
        array_push($errors, "The two passwords do not match");
    }

    // Check if user already exists
    $user_check_query = "SELECT * FROM user_info WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // If there are no errors, register the user
    if (count($errors) == 0) {
        // Hash the password for security
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $query = "INSERT INTO user_info (username, first_name, middle_name, last_name, email, password, created_at, updated_at) 
                  VALUES ('$username', '$firstName', '$middleName', '$lastName', '$email', '$password', NOW(), NOW())";
        mysqli_query($db, $query);

        // Set session and redirect to home page
        $_SESSION['username'] = $username; // $username is the logged-in user's username
        header('location: Dashboard.php');
    }
}
