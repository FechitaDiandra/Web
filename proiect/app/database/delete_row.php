<?php
header("Content-Type: application/json");
include 'db_connect.php';

$id = $_POST['id'];

$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

$response = [];
if ($stmt->execute()) {
    $response = ["message" => "User deleted successfully."];
} else {
    $response = ["error" => "Failed to delete user."];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
