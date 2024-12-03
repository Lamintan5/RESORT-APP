<?php
header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}
$data = json_decode(file_get_contents('php://input'), true);
$bookingId = isset($data['id']) ? $data['id'] : null;

if (!$bookingId) {
    echo json_encode(['success' => false, 'message' => 'Booking ID is required']);
    exit();
}
$sql = "UPDATE booking SET status = 'canceled' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookingId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Booking canceled successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel booking']);
}

$conn->close();
?>
