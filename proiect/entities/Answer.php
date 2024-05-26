<?php

class Answer {
    private $answer_id;
    private $form_id;
    private $user_id;
    private $response;
    private $created_at;

    public function __construct($answer_id, $form_id, $user_id, $response, $created_at) {
        $this->answer_id = $answer_id;
        $this->form_id = $form_id;
        $this->user_id = $user_id;
        $this->response = $response;
        $this->created_at = $created_at;
    }

    public function getAnswerId() {
        return $this->answer_id;
    }

    public function setAnswerId($answer_id) {
        $this->answer_id = $answer_id;
    }

    public function getFormId() {
        return $this->form_id;
    }

    public function setFormId($form_id) {
        $this->form_id = $form_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getResponse() {
        return $this->response;
    }

    public function setResponse($response) {
        $this->response = $response;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}
?>
