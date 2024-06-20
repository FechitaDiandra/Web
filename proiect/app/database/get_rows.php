<?php
header("Content-Type: text/html"); // Important to use text/html for direct HTML output
include 'db_connect.php';

$sql = "SELECT user_id, username, email, role FROM users";
$result = $conn->query($sql);

$html = '';
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>";
    $html .= "<td contenteditable='true' onBlur='saveToDatabase(this, \"username\", " . $row['user_id'] . ")'>" . $row['username'] . "</td>";
    $html .= "<td contenteditable='true' onBlur='saveToDatabase(this, \"email\", " . $row['user_id'] . ")'>" . $row['email'] . "</td>";
    $html .= "<td contenteditable='true' onBlur='saveToDatabase(this, \"role\", " . $row['user_id'] . ")'>" . $row['role'] . "</td>";
    $html .= "<td><button onclick='deleteRow(" . $row['user_id'] . ")'>Delete</button></td>";
    $html .= "</tr>";
}

$conn->close();

echo $html;
?>
