<?php
include 'UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function registerUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $passwordErrors = $this->validatePassword($data['password']);
    
        if (!empty($passwordErrors)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => $passwordErrors], JSON_PRETTY_PRINT);
            return;
        }
    
        $result = $this->userModel->register($data);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    
    

    public function loginUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->userModel->login($data);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    public function getUserById($id) {
        $result = $this->userModel->getUserById($id);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function getUserByEmail($email) {
        $result = $this->userModel->getUserByEmail($email);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function updateUser($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['password'])) { // Verifică dacă actualizarea include o parolă
            $passwordErrors = $this->validatePassword($data['password']);
            if (!empty($passwordErrors)) {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'message' => $passwordErrors], JSON_PRETTY_PRINT);
                return;
            }
        }
    
        $result = $this->userModel->updateUser($id, $data);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    
    
    public function deleteUser($id) {
        $result = $this->userModel->deleteUser($id);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function getAllUsers() {
        $result = $this->userModel->getAllUsers();
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    private function validatePassword($password) {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = "Password must contain at least one special character.";
        }

        return $errors;
    }
    public function resetPassword($userId, $newPassword) {
        $passwordErrors = $this->validatePassword($newPassword);
        if (!empty($passwordErrors)) {
            return ['success' => false, 'message' => $passwordErrors];
        }
    
        $updateSuccess = $this->userModel->updatePassword($userId, $newPassword);
        if ($updateSuccess) {
            return ['success' => true, 'message' => 'Parola a fost actualizată cu succes.'];
        } else {
            return ['success' => false, 'message' => 'Eroare la actualizarea parolei.'];
        }
    }
    
    
}
?>
