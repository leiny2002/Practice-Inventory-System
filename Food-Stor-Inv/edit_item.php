<?php
// Connect to the database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'project_inventory';
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the submitted values from the form
  $itemId = $_POST['id'];
  $productExpDate = $_POST['product_exp_date'];
  $productName = $_POST['product_name'];
  $supplier = $_POST['supplier'];
  $dateBought = $_POST['date_bought'];

  // Prepare the update query
  $stmt = $conn->prepare("UPDATE food_storage SET product_exp_date=?, product_name=?, supplier=?, date_bought=?, updated_at=NOW() WHERE id=?");
  $stmt->bind_param("ssssi", $productExpDate, $productName, $supplier, $dateBought, $itemId);

  // Execute the update query
  if ($stmt->execute()) {
    header('Content-Type: text/plain');
    echo 'success';
  } else {
    header('Content-Type: text/plain');
    echo 'error';
  }

  // Close the prepared statement
  $stmt->close();
}

// Close the database connection
$conn->close();
?>
