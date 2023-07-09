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

// Get the form data
$equipmentId = $_POST['equipment_id'];
$equipmentType = $_POST['equipment_type'];
$productModel = $_POST['product_model'];
$supplier = $_POST['supplier'];
$serialNumber = $_POST['serial_number'];
$endUser = $_POST['end_user'];

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO technological_devices (equipment_id, equipment_type, product_model, supplier, serial_number, end_user, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");

// Bind parameters and execute the statement
$stmt->bind_param("ssssss", $equipmentId, $equipmentType, $productModel, $supplier, $serialNumber, $endUser);

// Check if the statement executed successfully
if ($stmt->execute()) {
  // Item added successfully
  echo "success";
} else {
  // Error occurred while adding the item
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
