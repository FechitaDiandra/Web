<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foe_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    exit;
}

$sql = "SELECT user_id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$email = 'contact2feedbackoneverything@gmail.com';
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);
    $sqlInsert = "INSERT INTO users (username, email, password, role) VALUES ('admin','contact2feedbackoneverything@gmail.com', '$hashedPassword', 'admin')";
    
    if ($conn->query($sqlInsert) === TRUE) {
        error_log ("Admin account created successfully!");
    } else {
        error_log ("Error creating admin account: " . $conn->error);
    }
} else {
    error_log ("Admin account already exists.");
}

$conn->close();
?>
