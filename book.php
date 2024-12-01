<?php
header("Content-Type: application/json");

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$rid = $_POST['rid'];
$title = $_POST['title'];
$uid = $_POST['uid'];
$username = $_POST['username'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$price = $_POST['price'];
$method = $_POST['method'];

if (empty($check_in) || empty($check_out) || empty($cid) || empty($rid) || empty($price) || empty($method)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

$conn->begin_transaction();

try {
    $bookingSql = "INSERT INTO booking (rid, uid, title, username, check_in, check_out, price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($bookingSql);
    $stmt->bind_param('sssssss', $rid, $uid, $title, $username, $check_in, $check_out, $price, 'confirmed');

    if (!$stmt->execute()) {
        throw new Exception('Error inserting booking data: ' . $stmt->error);
    }

    $paymentSql = "INSERT INTO payments (rid, uid, title, username, amount, method) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($paymentSql);
    $stmt->bind_param('ssds',  $rid, $uid, $title, $username, $price, $method);

    if (!$stmt->execute()) {
        throw new Exception('Error inserting payment data: ' . $stmt->error);
    }

    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'title rented successfully, status updated to Unavailable, and payment recorded']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
