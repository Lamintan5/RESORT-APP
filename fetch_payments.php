<?php
header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}
$sql = "SELECT id, rid, title, username, amount, method, time FROM payments";
$result = $conn->query($sql);

$payments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $payments]);
} else {
    echo json_encode(['success' => false, 'message' => 'No payments found']);
}

$conn->close();
?>
