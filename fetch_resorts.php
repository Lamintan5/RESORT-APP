<?php
header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

$sql = "SELECT id, title, location, description, status, price, image FROM resort";
$result = $conn->query($sql);

$resorts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $resorts[] = $row;
    }
}

echo json_encode(['success' => true, 'data' => $resorts]);

$conn->close();
?>
