<?php
include 'Database.php';

class FormModel {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    //DONE
    public function createForm($formData) {
        if (!isset($formData['user_id'], $formData['title'], $formData['description'], $formData['is_published'], $formData['feedback_type'], $formData['answer_time'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }
    
        $filePath = '';
        if (isset($formData['file']) && $formData['file'] !== '') {
            $uploadDir = 'user-uploads/';
            $fileData = base64_decode($formData['file']);
            $fileExtension = strpos($formData['file'], 'data:image/jpeg') === 0 ? '.jpg' : '.png';
            $filePath = $uploadDir . uniqid() . $fileExtension;
    
            if (file_put_contents($filePath, $fileData) === false) {
                return ['success' => false, 'message' => 'Failed to upload file.'];
            }
        }
    
        $query = "INSERT INTO forms (user_id, title, description, is_published, feedback_type, file_path, created_at, answer_time) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("isssiss", 
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
    

    //DONE
    public function getAllForms() {
        $query = "SELECT * FROM forms";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $forms = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'message' => $forms];
        } else {
            return  ['success' => false, 'message' => $this->connection->error];
        }
    }

    //DONE
    public function getPublicForms() {
        $query = "SELECT * FROM forms WHERE is_published = 1";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $forms = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'message' => $forms];
        } else {
            return  ['success' => false, 'message' => $this->connection->error];
        }
    }

    //DONE
    public function getFormsByUserId($userId) {
        $query = "SELECT * FROM forms WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $forms = $result->fetch_all(MYSQLI_ASSOC);
        if ($forms) {
            return ['success' => true, 'message' => $forms];
        } else {
            return ['success' => false, 'message' => 'The user with the id ' . $userId . " doesn't have any forms."];
        }
    }

    //DONE
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

    //DONE
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

    //DONE
    public function reportForm($formId) {
        $query = "UPDATE forms SET reported = 1 WHERE form_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $formId);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Form reported successfully'];
        } else {
            return ['success' => false, 'message' => $this->connection->error];
        }
    }
    

    //DONE
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
                return ['success' => false, 'message' => 'The user with the id ' . $userId . " doesn't have any forms."];
            }
        } else {
            return ['success' => false, 'message' => $this->connection->error];
        }
    }
}
