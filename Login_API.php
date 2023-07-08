<?php

// Function to connect to the database
function connectDB() {
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = "";     // Replace with your database password
    $dbname = "project_inventory";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to check login credentials
function login($username, $password) {
    $conn = connectDB();

    // Sanitize input
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Hash the password (You should use a stronger password hashing mechanism)
    $hashedPassword = md5($password); // Please consider using a stronger encryption method like bcrypt or Argon2

    // Prepare and execute the query
    $query = "SELECT * FROM user_info WHERE username='$username' AND password='$hashedPassword' LIMIT 1";
    $result = $conn->query($query);

    // Check if the query returned any rows
    if ($result->num_rows === 1) {
        // User exists and credentials are correct
        $user = $result->fetch_assoc();
        return $user;
    } else {
        // User does not exist or credentials are incorrect
        return false;
    }
}
