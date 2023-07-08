<?php
// Database configuration
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'project_inventory';

// Create database connection
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
