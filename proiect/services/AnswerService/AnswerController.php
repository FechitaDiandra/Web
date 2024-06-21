<?php
include 'AnswerModel.php';

class AnswerController {
    private $answerModel;

    public function __construct() {
        $this->answerModel = new AnswerModel();
    }


    public function addAnswer() {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->answerModel->addAnswer($data);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function getAnswersByFormId($formId) {
        $result = $this->answerModel->getAnswersByFormId($formId);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

    public function getStatisticsByFormId($formId) {
        $result = $this->answerModel->getStatisticsByFormId($formId);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode(['success' => $result['success'], 'message' => $result['message']], JSON_PRETTY_PRINT);
    }

}