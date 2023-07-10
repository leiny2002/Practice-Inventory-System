<?php
    // Function to get the count of items listed this week
    function getItemsListedThisWeekCount()
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

        // Get the current week's start and end dates
        $startOfWeek = date("Y-m-d", strtotime('monday this week'));
        $endOfWeek = date("Y-m-d", strtotime('sunday this week'));

        // Initialize the count variable
        $count = 0;

        // Query to get the count of items listed this week from technological_devices table
        $sql1 = "SELECT COUNT(*) AS count FROM technological_devices WHERE created_at BETWEEN '$startOfWeek' AND '$endOfWeek'";
        $result1 = $conn->query($sql1);

        if ($result1->num_rows > 0) {
            $row = $result1->fetch_assoc();
            $count += $row['count'];
        }

        // Query to get the count of items listed this week from food_storage table
        $sql2 = "SELECT COUNT(*) AS count FROM food_storage WHERE created_at BETWEEN '$startOfWeek' AND '$endOfWeek'";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
            $row = $result2->fetch_assoc();
            $count += $row['count'];
        }

        // Query to get the count of items listed this week from cleaning_materials table
        $sql3 = "SELECT COUNT(*) AS count FROM cleaning_materials WHERE created_at BETWEEN '$startOfWeek' AND '$endOfWeek'";
        $result3 = $conn->query($sql3);

        if ($result3->num_rows > 0) {
            $row = $result3->fetch_assoc();
            $count += $row['count'];
        }

        // Close the database connection
        $conn->close();

        return $count;
    }
    ?>