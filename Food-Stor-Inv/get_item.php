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

// Check if the request is a GET request
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  // Get the item ID from the query parameters
  $itemId = $_GET['id'];

  // Prepare and execute the query to retrieve the item details
  $stmt = $conn->prepare("SELECT * FROM food_storage WHERE id = ?");
  $stmt->bind_param("i", $itemId);
  $stmt->execute();

  // Get the result set
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    // Fetch the item details from the result set
    $item = $result->fetch_assoc();

    // Return the item details as JSON response
    $response = [
      'status' => 'success',
      'data' => $item
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    // Item not found
    $response = [
      'status' => 'error',
      'message' => 'Item not found'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  // Close the prepared statement
  $stmt->close();
}

// Close the database connection
$conn->close();
?>
