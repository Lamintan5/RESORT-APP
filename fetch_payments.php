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

// SQL query to fetch payment details
$sql = "SELECT id, rid, title, username, amount, method, time FROM payments";
$result = $conn->query($sql);

$payments = [];
if ($result->num_rows > 0) {
    // Fetch all payment records from the database
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
    // Return the payments data in JSON format
    echo json_encode(['success' => true, 'data' => $payments]);
} else {
    // Return an empty response if no data is found
    echo json_encode(['success' => false, 'message' => 'No payments found']);
}

// Close the database connection
$conn->close();
?>
