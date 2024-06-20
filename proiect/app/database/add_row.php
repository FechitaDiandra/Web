<?php
header("Content-Type: application/json");
include 'db_connect.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash password before storing
$role = $_POST['role'];

$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $password, $role);

$response = [];
if ($stmt->execute()) {
    $response = ["message" => "User added successfully."];
} else {
    $response = ["error" => "Failed to add user."];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
