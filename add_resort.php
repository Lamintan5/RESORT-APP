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

// Validate and upload the image
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image'];
    $uploadDir = 'uploads/';
    $imagePath = $uploadDir . basename($image['name']);

    // Ensure the upload directory exists
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

// Collect form data
$title = $_POST['title'];
$location = $_POST['location'];
$price = $_POST['price'];
$description = $_POST['description'];

// Validate form inputs
if (empty($title) || empty($location) || empty($price) || empty($description)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

// Insert data into the database
$sql = "INSERT INTO resort (image, title, location, price, status, description) 
        VALUES ('$imagePath', '$title', '$location', '$price', 'available', '$description')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Resort added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>
