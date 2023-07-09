<?php
// Connect to the database
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'project_inventory';
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        // Fetch data from the database
        $sql = "SELECT * FROM food_storage";
        if (!empty($_GET['search'])) {
          $searchTerm = $_GET['search'];
          $sql .= " WHERE product_exp_date LIKE '%$searchTerm%' OR product_name LIKE '%$searchTerm%' OR supplier LIKE '%$searchTerm%' OR date_bought LIKE '%$searchTerm%'";
        }
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
          echo '<div class="list">';
          echo '<div class="list-info">' . $row["product_exp_date"] . '</div>';
          echo '<div class="list-info">' . $row["product_name"] . '</div>';
          echo '<div class="list-info">' . $row["supplier"] . '</div>';
          echo '<div class="list-info">' . $row["date_bought"] . '</div>';
          echo '<div class="list-actions">';
          echo '<button class="edit" data-item-id="' . $row["id"] . '">Edit</button>';
          echo '<button class="remove" data-item-id="' . $row["id"] . '">Remove</button>';
          echo '</div>';
          echo '</div>';
        }

        $conn->close();
?>        