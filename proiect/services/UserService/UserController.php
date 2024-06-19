<?php
include 'UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function registerUser() {
        $data = json_decode(file_get_contents('php://input'), true);
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

}