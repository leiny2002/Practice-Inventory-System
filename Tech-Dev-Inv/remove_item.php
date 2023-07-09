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

// Get the item ID from the request
$itemId = $_POST['id'];

// Prepare and execute the SQL statement to remove the item
$stmt = $conn->prepare("DELETE FROM technological_devices WHERE id = ?");
$stmt->bind_param("i", $itemId);

if ($stmt->execute()) {
  // Item removed successfully
  echo "success";
} else {
  // Error occurred while removing the item
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
