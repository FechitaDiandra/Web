<?php
include 'Database.php';

class FormModel {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function createForm($formData) {
        if (!isset($formData['user_id'], $formData['title'], $formData['description'], $formData['is_published'], $formData['feedback_type'], $formData['answer_time'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }
    
        $filePath = '';
        if (isset($formData['file']) && $formData['file'] !== '') {
            $uploadDir = '../../user-uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Check if the base64 string contains the prefix and strip it
            if (strpos($formData['file'], 'data:image/jpeg;base64,') === 0) {
                $fileData = base64_decode(str_replace('data:image/jpeg;base64,', '', $formData['file']));
                $fileExtension = '.jpg';
            } elseif (strpos($formData['file'], 'data:image/png;base64,') === 0) {
                $fileData = base64_decode(str_replace('data:image/png;base64,', '', $formData['file']));
                $fileExtension = '.png';
            } else {
                return ['success' => false, 'message' => 'Invalid image format.'];
            }
    
            $filePath = $uploadDir . uniqid() . $fileExtension;
    
            if (file_put_contents($filePath, $fileData) === false) {
                return ['success' => false, 'message' => 'Failed to upload file.'];
            }
            $filePath = basename($filePath);
        }
    
        $query = "INSERT INTO forms (user_id, title, description, is_published, feedback_type, file_path, created_at, answer_time) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("issssss", 
            $formData['user_id'], 
            $formData['title'], 
            $formData['description'], 
            $formData['is_published'], 
            $formData['feedback_type'], 
            $filePath,
            $formData['answer_time']
        );
    
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Form created successfully', 'form_id' => $this->connection->insert_id];
        } else {
            return ['success' => false, 'message' => $stmt->error];
        }
    }

    public function getAllForms() {
        $query = "SELECT * FROM forms ORDER BY created_at DESC";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $forms = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'message' => $forms];
        } else {
            return  ['success' => false, 'message' => $this->connection->error];
        }
    }

    public function getPublicAvailableForms() {
        $query = "SELECT * FROM forms WHERE is_published = 1 AND answer_time > NOW() ORDER BY created_at DESC";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $forms = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'message' => $forms];
        } else {
            return  ['success' => false, 'message' => $this->connection->error];
        }
    }

    public function getFormsByUserId($userId) {
        $query = "SELECT * FROM forms WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $forms = $result->fetch_all(MYSQLI_ASSOC);
        if ($forms) {
            return ['success' => true, 'message' => $forms];
        } else {
            return ['success' => true, 'message' => 'The user with the id ' . $userId . " doesn't have any forms."];
        }
    }

    public function getFormById($id) {
        $query = "SELECT * FROM forms WHERE form_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $form = $result->fetch_assoc();
        if ($form) {
            return ['success' => true, 'message' => $form];
        } else {
            return ['success' => false, 'message' => 'No form found with id ' . $id];
        }
    }

    public function getReportedForms() {
        $query = "SELECT * FROM forms WHERE reported = 1";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $forms = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'message' => $forms];
        } else {
            return  ['success' => false, 'message' => $this->connection->error];
        }
    }

    public function reportForm($formId) {
        $checkQuery = "SELECT * FROM forms WHERE form_id = ?";
        $checkStmt = $this->connection->prepare($checkQuery);
        $checkStmt->bind_param("i", $formId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
    
        if ($result->num_rows > 0) {
            $query = "UPDATE forms SET reported = 1 WHERE form_id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("i", $formId);
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Form reported successfully'];
            } else {
                return ['success' => false, 'message' => $this->connection->error];
            }
        } else {
            return ['success' => false, 'message' => 'Form does not exist'];
        }
    }
    
    public function deleteForm($id) {
        $query = "DELETE FROM forms WHERE form_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return ['success' => true, 'message' => 'Form deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'No form found with ID ' . $id];
            }
        } else {
            return ['success' => false, 'message' => $this->connection->error];
        }
    }

    public function deleteFormsByUserId($userId) {
        $query = "DELETE FROM forms WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return ['success' => true, 'message' => 'Forms deleted successfully'];
            } else {
                return ['success' => true, 'message' => 'The user with the id ' . $userId . " doesn't have any forms."];
            }
        } else {
            return ['success' => false, 'message' => $this->connection->error];
        }
    }
}
