<?php
session_start(); 

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$email = $data['email'];
$role = $data['role'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$conn = new mysqli('localhost', 'root', '', 'hotel');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$sql = "SELECT email FROM users WHERE BINARY email = '".$email."'";
$result = mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);
  
if($count == 1) {
    echo json_encode(['success' => false, 'message' => 'Email already exists. Please try a different email address.']);
} else {
    $insert = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    $query = mysqli_query($conn,$insert);
    
    if($query) {
        $userId = mysqli_insert_id($conn); 
        
        $_SESSION['user'] = [
            'id' => $userId,
            'username' => $username,
            'email' => $email,
            'role' => $role
        ];
        
        echo json_encode(['success' => true, 'message' => 'Registration successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
}

$conn->close();
?>
