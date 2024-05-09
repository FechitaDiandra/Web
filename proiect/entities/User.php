<?php

class User {
    private $user_id;
    private $username;
    private $email;
    private $password;
    private $remember_me_token;
    private $reset_password_token;
    private $reset_password_token_expires;
    private $change_email_token;
    private $change_email_token_expires;
    private $delete_account_token;
    private $delete_account_token_expires;
    private $role;

    public function __construct($user_id, $username, $email, $password, $remember_me_token, $reset_password_token, $reset_password_token_expires, $change_email_token, $change_email_token_expires, $delete_account_token, $delete_account_token_expires, $role) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->remember_me_token = $remember_me_token;
        $this->reset_password_token = $reset_password_token;
        $this->reset_password_token_expires = $reset_password_token_expires;
        $this->change_email_token = $change_email_token;
        $this->change_email_token_expires = $change_email_token_expires;
        $this->delete_account_token = $delete_account_token;
        $this->delete_account_token_expires = $delete_account_token_expires;
        $this->role = $role;
    }


    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRememberMeToken() {
        return $this->remember_me_token;
    }

    public function setRememberMeToken($remember_me_token) {
        $this->remember_me_token = $remember_me_token;
    }

    public function getResetPasswordToken() {
        return $this->reset_password_token;
    }

    public function setResetPasswordToken($reset_password_token) {
        $this->reset_password_token = $reset_password_token;
    }

    public function getResetPasswordTokenExpires() {
        return $this->reset_password_token_expires;
    }

    public function setResetPasswordTokenExpires($reset_password_token_expires) {
        $this->reset_password_token_expires = $reset_password_token_expires;
    }

    public function getChangeEmailToken() {
        return $this->change_email_token;
    }

    public function setChangeEmailToken($change_email_token) {
        $this->change_email_token = $change_email_token;
    }

    public function getChangeEmailTokenExpires() {
        return $this->change_email_token_expires;
    }

    public function setChangeEmailTokenExpires($change_email_token_expires) {
        $this->change_email_token_expires = $change_email_token_expires;
    }

    public function getDeleteAccountToken() {
        return $this->delete_account_token;
    }

    public function setDeleteAccountToken($delete_account_token) {
        $this->delete_account_token = $delete_account_token;
    }

    public function getDeleteAccountTokenExpires() {
        return $this->delete_account_token_expires;
    }

    public function setDeleteAccountTokenExpires($delete_account_token_expires) {
        $this->delete_account_token_expires = $delete_account_token_expires;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

}
?>