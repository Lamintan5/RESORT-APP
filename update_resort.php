<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imagePath = 'uploads/' . basename($image['name']);
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit();
        }
    }
    $sql = "UPDATE resort SET 
            title = '$title', 
            location = '$location', 
            price = '$price', 
            description = '$description'";
    
    if ($imagePath) {
        $sql .= ", image = '$imagePath'";
    }

    $sql .= " WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Resort updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating resort: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
