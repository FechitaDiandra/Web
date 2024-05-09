<?php
require_once 'models/UserModel.php';
require_once 'views/myaccount.php';

class MyAccountController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST['action'] ?? '';
            switch ($action) {
                    case 'Update Username':
                        $this->update_username();
                        break;
                    case 'Change Email':
                        $this->change_email();
                        break;
                    case 'Change Password':
                        $this->redirectTo('reset-password.php');
                        break;
                    case 'Delete Account':
                        $this->delete_account();
                        break;
                    default:
                        break;
                }
            }
        
        require_once 'views/myaccount.php';
    }
    


    public function update_username() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
            $email = $_SESSION['email'];
            $newUsername = trim($_POST['username']);
    
            if (empty($newUsername)) {
                $_SESSION['message'] ="Username cannot be empty.";
                $this->redirectTo('myaccount.php');
            } else {
                if ($this->userModel->update_username_by_email($email, $newUsername)) {
                    $_SESSION['username'] = $newUsername;
                    $_SESSION['message'] ="Your username has been updated successfully.";
                    $this->redirectTo('myaccount.php');
                } else {
                    $_SESSION['message'] ="There was an error updating your username.";
                    $this->redirectTo('myaccount.php');
                }
            }
        }
    }
    


    public function change_email() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_SESSION['email'];
            $token = $this->userModel->generate_token();

            if ($this->userModel->store_change_email_token($email, $token)) {
                $this->userModel->send_change_email_link($email, $token);
                $_SESSION['message'] ="A confirmation link has been sent to your email to change your email address.";
                $this->redirectTo('myaccount.php');
            } else {
                $_SESSION['message'] ="There was an error sending the confirmation link.";
                $this->redirectTo('myaccount.php');
            }
        }
    }



    public function delete_account() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_SESSION['email'];
            $token = $this->userModel->generate_token();

            if ($this->userModel->store_delete_account_token($email, $token)) {
                $this->userModel->send_delete_account_link($email, $token);
                $_SESSION['message'] ="A confirmation link has been sent to your email to delete your account.";
                $this->redirectTo('myaccount.php');
            } else {
                $_SESSION['message'] ="There was an error sending the confirmation link.";
                $this->redirectTo('myaccount.php');
            }
        }
    }


    private function redirectTo($location) {
        header("Location: $location");
        exit;
    }

}
?>