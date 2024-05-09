<?php
require_once 'models/UserModel.php';

class ResetPasswordController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
            // Handle the form submission for password update
            $this->update_password($_POST['token'], $_POST['password'], $_POST['password-repeat']);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle the initial password reset request
            $this->handle_password_reset_request();
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
            // Display the form for the user to enter a new password
            $this->render_new_password_form($_GET['token']);
        } else {
            // Display the initial form to request a password reset link
            require_once 'views/reset-password.php';
        }
    }
    
    

    private function handle_password_reset_request() {
        $email = $_POST['email'];
        if (!$this->userModel->email_exists($email)) {
            $_SESSION['message'] = "No account found with that email address.";
            $this->redirectTo('reset-password.php');
            return;
        }
    
        $token = $this->userModel->generate_token();
        $this->userModel->store_reset_password_token($email, $token);
    
        if ($this->userModel->send_password_reset_email($email, $token)) {
            $_SESSION['message'] = "A password reset link has been sent to your email.";
            $this->redirectTo('reset-password.php');
        } else {
            $_SESSION['message'] = "There was an error sending the reset link.";
            $this->redirectTo('reset-password.php');
        }
    }
    


    private function render_new_password_form($token) {
        if ($this->userModel->is_reset_password_token_valid($token)) {
            require_once 'views/new-password-form.php';
        } else {
            $_SESSION['message'] = "Invalid or expired token.";
            $this->redirectTo('reset-password.php');
        }
    }



    private function update_password($token, $password, $password_repeat) {
        if ($this->userModel->is_reset_password_token_valid($token)) {
            if($password !== $password_repeat){
                $_SESSION['message'] = "The passwords do not match.";
                $this->redirectTo("reset-password.php?token=$token");
            }
            if ($this->userModel->update_password($token, $password)) {
                $this->userModel->invalidate_reset_pasword_token($token);
                $_SESSION['password'] = $password;
                $_SESSION['message'] = "Your password has been updated successfully.";
                $this->redirectTo('reset-password.php');
            } else {
                $_SESSION['message'] = "There was an error updating your password.";
                $this->redirectTo("reset-password.php?token=$token");
            }
        } else {
            $_SESSION['message'] = "Invalid or expired token.";
            $this->redirectTo('reset-password.php');
        }
    }



    private function redirectTo($location) {
        header("Location: $location");
        exit;
    }
}