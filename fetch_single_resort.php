<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT id, title, location, description, status, price, image FROM resort WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $resort = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $resort]);
    } else {
        echo json_encode(['success' => false, 'message' => `Resort not found $id`]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
