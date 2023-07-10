<?php
// Function to get the count of users
function getUserCount()
{
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_inventory";

    // Create a new MySQLi object and establish the database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get the count of users from user_info table
    $sql = "SELECT COUNT(*) AS count FROM user_info";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userCount = $row['count'];
    } else {
        $userCount = 0;
    }

    // Close the database connection
    $conn->close();

    return $userCount;
}
?>
