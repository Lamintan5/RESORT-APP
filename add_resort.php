<?php
header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image'];
    $uploadDir = 'uploads/';
    $imagePath = $uploadDir . basename($image['name']);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error']);
    exit();
}

$title = $_POST['title'];
$location = $_POST['location'];
$price = $_POST['price'];
$description = $_POST['description'];

if (empty($title) || empty($location) || empty($price) || empty($description)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}
$sql = "INSERT INTO resort (image, title, location, price, status, description) 
        VALUES ('$imagePath', '$title', '$location', '$price', 'available', '$description')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Resort added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>
