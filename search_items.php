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

$searchTerm = $_GET['search'];

// Fetch data from the database based on the search query
$sql = "SELECT * FROM technological_devices WHERE equipment_id LIKE '%$searchTerm%' OR equipment_type LIKE '%$searchTerm%' OR product_model LIKE '%$searchTerm%' OR supplier LIKE '%$searchTerm%' OR serial_number LIKE '%$searchTerm%' OR end_user LIKE '%$searchTerm%'";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

$conn->close();

// Return the search results as JSON data
header('Content-Type: application/json');
echo json_encode(array('status' => 'success', 'data' => $data));
?>
