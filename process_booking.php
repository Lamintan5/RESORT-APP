<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    
    exit();
}

require 'db.php';  

$checkInDate = isset($_POST['checkInDate']) ? $_POST['checkInDate'] : null;
$checkOutDate = isset($_POST['checkOutDate']) ? $_POST['checkOutDate'] : null;
$paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : null;
$resortId = isset($_POST['resortId']) ? $_POST['resortId'] : null;
$userId = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];

if (!$checkInDate || !$checkOutDate || !$paymentMethod || !$resortId) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}
$checkInTimestamp = strtotime($checkInDate);
$checkOutTimestamp = strtotime($checkOutDate);
$daysCount = ($checkOutTimestamp - $checkInTimestamp) / (60 * 60 * 24);

$sql = "SELECT title, price FROM resort WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resortId);
$stmt->execute();
$resortResult = $stmt->get_result();
$resort = $resortResult->fetch_assoc();

if (!$resort) {
    echo json_encode(['success' => false, 'message' => 'Resort not found']);
    exit();
}

$title = $resort['title'];
$pricePerDay = $resort['price'];

$totalPrice = $pricePerDay * $daysCount;

$bookingSql = "INSERT INTO booking (rid, uid, title, username, checkin, checkout, price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($bookingSql);
$status = 'confirmed'; 
$stmt->bind_param("iissssss", $resortId, $userId, $title, $username, $checkInDate, $checkOutDate, $totalPrice, $status);
$bookingResult = $stmt->execute();

if ($bookingResult) {
    $paymentSql = "INSERT INTO payments (rid, uid, title, username, amount, method) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($paymentSql);
    $stmt->bind_param("iissds", $resortId, $userId, $title, $username, $totalPrice, $paymentMethod);
    $paymentResult = $stmt->execute();

    if ($paymentResult) {
        echo json_encode(['success' => true, 'message' => 'Booking confirmed!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Booking failed']);
}

$conn->close();
?>
