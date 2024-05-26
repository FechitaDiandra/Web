<?php

class Form {
    private $form_id;
    private $user_id;
    private $title;
    private $description;
    private $is_published;
    private $created_at;
    private $delete_form_token;
    private $delete_form_token_expires;

    public function __construct($form_id, $user_id, $title, $description, $is_published, $created_at, $delete_form_token, $delete_form_token_expires) {
        $this->form_id = $form_id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->is_published = $is_published;
        $this->created_at = $created_at;
        $this->delete_form_token = $delete_form_token;
        $this->delete_form_token_expires = $delete_form_token_expires;
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

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getIsPublished() {
        return $this->is_published;
    }

    public function setIsPublished($is_published) {
        $this->is_published = $is_published;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getDeleteFormToken() {
        return $this->delete_form_token;
    }

    public function setDeleteFormToken($delete_form_token) {
        $this->delete_form_token = $delete_form_token;
    }

    public function getDeleteFormTokenExpires() {
        return $this->delete_form_token_expires;
    }

    public function setDeleteFormTokenExpires($delete_form_token_expires) {
        $this->delete_form_token_expires = $delete_form_token_expires;
    }
}
?>
