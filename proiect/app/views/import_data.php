<?php
header("Content-Type: application/json");
include 'database/db_connect.php'; // Adjust the path according to your directory structure

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']) && isset($_POST['type'])) {
        $fileType = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
        $file = $_FILES['file']['tmp_name'];
        
        if ($fileType == 'csv') {
            $handle = fopen($file, 'r');
            if ($handle !== FALSE) {
                // Start transaction
                $conn->begin_transaction();

                // Clear existing data
                $conn->query("TRUNCATE TABLE users");
                
                // Reset auto increment
                $conn->query("ALTER TABLE users AUTO_INCREMENT = 1");

                // Read the header line
                $header = fgetcsv($handle, 1000, ',');

                // Ensure the header matches the expected columns
                $expectedHeader = ['user_id', 'username', 'email', 'password', 'role'];
                if ($header !== $expectedHeader) {
                    throw new Exception("CSV format invalid. Expected header: " . implode(',', $expectedHeader));
                }

                // Read and insert the data
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    if (count($data) == 5) {
                        $user_id = filter_var($data[0], FILTER_SANITIZE_NUMBER_INT);
                        $username = filter_var($conn->real_escape_string($data[1]), FILTER_SANITIZE_STRING);
                        $email = filter_var($conn->real_escape_string($data[2]), FILTER_VALIDATE_EMAIL);
                        $password = filter_var($conn->real_escape_string($data[3]), FILTER_SANITIZE_STRING);
                        $role = filter_var($conn->real_escape_string($data[4]), FILTER_SANITIZE_STRING);

                        if ($user_id && $username && $email && $password && $role) {
                            $sql = "INSERT INTO users (user_id, username, email, password, role) VALUES ('$user_id', '$username', '$email', '$password', '$role')";
                            $conn->query($sql);
                        }
                    }
                }

                fclose($handle);
                // Commit transaction
                $conn->commit();
                echo json_encode(["message" => "CSV data imported successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to open the CSV file."]);
            }
        } elseif ($fileType == 'json') {
            $data = json_decode(file_get_contents($file), true);
            if (is_array($data)) {
                // Start transaction
                $conn->begin_transaction();

                // Clear existing data
                $conn->query("TRUNCATE TABLE users");

                // Reset auto increment
                $conn->query("ALTER TABLE users AUTO_INCREMENT = 1");

                foreach ($data as $row) {
                    if (isset($row['user_id'], $row['username'], $row['email'], $row['password'], $row['role'])) {
                        $user_id = filter_var($row['user_id'], FILTER_SANITIZE_NUMBER_INT);
                        $username = filter_var($conn->real_escape_string($row['username']), FILTER_SANITIZE_STRING);
                        $email = filter_var($conn->real_escape_string($row['email']), FILTER_VALIDATE_EMAIL);
                        $password = filter_var($conn->real_escape_string($row['password']), FILTER_SANITIZE_STRING);
                        $role = filter_var($conn->real_escape_string($row['role']), FILTER_SANITIZE_STRING);

                        if ($user_id && $username && $email && $password && $role) {
                            $sql = "INSERT INTO users (user_id, username, email, password, role) VALUES ('$user_id', '$username', '$email', '$password', '$role')";
                            $conn->query($sql);
                        }
                    }
                }

                // Commit transaction
                $conn->commit();
                echo json_encode(["message" => "JSON data imported successfully."]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Invalid JSON format."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid file type."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid input."]);
    }
} catch (Exception $e) {
    // Rollback transaction in case of error
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}

$conn->close();
?>
