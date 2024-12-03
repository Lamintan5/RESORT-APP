<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM resort WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Resort deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting resort: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
