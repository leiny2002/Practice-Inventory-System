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
$itemId = $_GET['id'];

// Prepare and execute the SQL statement to retrieve the item
$stmt = $conn->prepare("SELECT * FROM technological_devices WHERE id = ?");
$stmt->bind_param("i", $itemId);
$stmt->execute();
$result = $stmt->get_result();

$response = array(); // Initialize the response array

if ($result->num_rows > 0) {
  // Item found, retrieve its details
  $row = $result->fetch_assoc();

  $item = array(
    'id' => $row['id'],
    'equipment_id' => $row['equipment_id'],
    'equipment_type' => $row['equipment_type'],
    'product_model' => $row['product_model'],
    'supplier' => $row['supplier'],
    'serial_number' => $row['serial_number'],
    'end_user' => $row['end_user']
  );

  $response['status'] = 'success';
  $response['data'] = $item;
} else {
  // Item not found
  $response['status'] = 'error';
  $response['message'] = 'Item not found.';
}

$stmt->close();
$conn->close();

// Set the appropriate content type for JSON response
header('Content-Type: application/json');

// Encode the response array as JSON and send the response
echo json_encode($response);
?>
