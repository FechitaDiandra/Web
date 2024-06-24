<?php
include 'FormModel.php';

class FormController {
    private $formModel;

    public function __construct() {
        $this->formModel = new FormModel();
    }

    public function createForm() {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->formModel->createForm($data);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function getAllForms() {
        $result = $this->formModel->getAllForms();
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    public function getPublicAvailableForms() {
        $result = $this->formModel->getPublicAvailableForms();
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    public function getFormsByUserId($userId) {
        $result = $this->formModel->getFormsByUserId($userId);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    public function getFormById($id) {
        $result = $this->formModel->getFormById($id);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function getReportedForms() {
        $result = $this->formModel->getReportedForms();
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    public function reportForm($formId) {
        $result = $this->formModel->reportForm($formId);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    public function cancelReportForm($formId) {
        $result = $this->formModel->cancelReportForm($formId);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    public function deleteForm($id) {
        $result = $this->formModel->deleteForm($id);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function deleteFormsByUserId($userId) {
        $result = $this->formModel->deleteFormsByUserId($userId);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}
