<?php
header("Content-Type: application/json");
include 'db_connect.php';

$id = $_POST['id'];
$column = $_POST['column'];
$editval = $_POST['editval'];

$sql = "UPDATE users SET $column = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $editval, $id);

$response = [];
if ($stmt->execute()) {
    $response = ["message" => "User updated successfully."];
} else {
    $response = ["error" => "Failed to update user."];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
