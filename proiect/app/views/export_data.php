<?php
header("Content-Type: application/json");
include 'db_connect.php';

try {
    $type = filter_var($_GET['type'] ?? 'csv', FILTER_SANITIZE_STRING);
    $data = [];
    $sql = "SELECT user_id, username, email, password, role FROM users";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if ($type == 'json') {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="data.json"');
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="data.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['user_id', 'username', 'email', 'password', 'role']);
        foreach ($data as $row) {
            $row = array_map('htmlspecialchars_decode', $row);
            fputcsv($output, $row);
        }
        fclose($output);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}

$conn->close();
?>
