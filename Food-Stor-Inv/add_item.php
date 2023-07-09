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
$productExpDate = $_POST['product_exp_date'];
$productName = $_POST['product_name'];
$supplier = $_POST['supplier'];
$dateBought = $_POST['date_bought'];

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO food_storage (product_exp_date, product_name, supplier, date_bought, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");

// Bind parameters and execute the statement
$stmt->bind_param("ssss", $productExpDate, $productName, $supplier, $dateBought);

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
