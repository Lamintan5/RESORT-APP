<?php
header("Content-Type: application/json");

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get the booking ID from the request body
$data = json_decode(file_get_contents('php://input'), true);
$bookingId = isset($data['id']) ? $data['id'] : null;

if (!$bookingId) {
    echo json_encode(['success' => false, 'message' => 'Booking ID is required']);
    exit();
}

// Update the status of the booking to 'canceled'
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
