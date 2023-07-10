<?php
// Connect to the database
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'project_inventory';
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        // Fetch data from the database
        $sql = "SELECT * FROM cleaning_materials";
        if (!empty($_GET['search'])) {
          $searchTerm = $_GET['search'];
          $sql .= " WHERE equipment_id LIKE '%$searchTerm%' OR equipment_type LIKE '%$searchTerm%' OR supplier LIKE '%$searchTerm%' OR serial_number LIKE '%$searchTerm%'";
        }
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
          echo '<div class="list">';
          echo '<div class="list-info">' . $row["equipment_id"] . '</div>';
          echo '<div class="list-info">' . $row["equipment_type"] . '</div>';
          echo '<div class="list-info">' . $row["supplier"] . '</div>';
          echo '<div class="list-info">' . $row["serial_number"] . '</div>';
          echo '<div class="list-actions">';
          echo '<button class="edit" data-item-id="' . $row["id"] . '">Edit</button>';
          echo '<button class="remove" data-item-id="' . $row["id"] . '">Remove</button>';
          echo '</div>';
          echo '</div>';
        }

        $conn->close();
?>        