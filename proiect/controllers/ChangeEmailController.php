<?php
require_once 'models/UserModel.php';

class ChangeEmailController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        $token = $_GET['token'] ?? null;
        

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new-email'], $_POST['confirm-new-email'], $_POST['token'])) {
            $newEmail = $_POST['new-email'];
            $confirmNewEmail = $_POST['confirm-new-email'];
            $token = $_POST['token'];

            if ($newEmail === $confirmNewEmail) {
                if ($this->userModel->is_change_email_token_valid($token)) {
                    if ($this->userModel->update_email_by_token($token, $newEmail)) {
                        $_SESSION['message'] = "Your email has been updated successfully.";
                        $_SESSION['email'] = $newEmail;
                        $this->userModel->invalidate_change_email_token($token);
                        $this->redirectTo('myaccount.php');
                    } else {
                        $_SESSION['message'] = "There was an error updating your email.";
                        $this->redirectTo("change-email.php?token=$token");
                    }
                } else {
                    $_SESSION['message'] = "Invalid or expired token.";
                    $this->redirectTo('myaccount.php');
                }
            } else {
                $_SESSION['message'] = "The emails do not match. Please try again.";
                $this->redirectTo("change-email.php?token=$token");
            }
        // If it's not a POST request, check for the token and display the form
        } elseif ($token) {
            require_once 'views/new-email-form.php';
        // Redirect to myaccount.php if no token is present
        } else {
            $this->redirectTo('myaccount.php');
        }
    }

    
    private function redirectTo($location) {
        header("Location: $location");
        exit;
    }
}


?>
