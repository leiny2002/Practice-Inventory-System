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
  $equipmentId = $_POST['equipment_id'];
  $equipmentType = $_POST['equipment_type'];
  $productModel = $_POST['product_model'];
  $supplier = $_POST['supplier'];
  $serialNumber = $_POST['serial_number'];
  $endUser = $_POST['end_user'];

  // Prepare the update query
  $stmt = $conn->prepare("UPDATE technological_devices SET equipment_id=?, equipment_type=?, product_model=?, supplier=?, serial_number=?, end_user=?, updated_at=NOW() WHERE id=?");
  $stmt->bind_param("ssssssi", $equipmentId, $equipmentType, $productModel, $supplier, $serialNumber, $endUser, $itemId);

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
