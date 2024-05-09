<?php
require_once 'models/UserModel.php';

class DeleteAccountController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
            $token = $_POST['token'];

            if ($this->userModel->is_delete_account_token_valid($token)) {
                if ($this->userModel->delete_account_by_token($token)) {
                    $_SESSION['isLogged'] = false;
                    $this->userModel->invalidate_delete_account_token($token);
                    if (isset($_COOKIE['remember_me_token'])) {
                        setcookie('remember_me_token', '', time() - 3600, "/");
                    }
                    
                    //destroy the session
                    $_SESSION = array();
                    if (ini_get("session.use_cookies")) {
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time() - 42000,
                            $params["path"], $params["domain"],
                            $params["secure"], $params["httponly"]
                        );
                    }
                    session_destroy();
                    $this->redirectTo('index.php');
                } else {
                    $_SESSION['message'] = "There was an error deleting your account.";
                    $this->redirectTo('myaccount.php');
                }
            } else {
                $_SESSION['message'] = "Invalid or expired token.";
                $this->redirectTo('myaccount.php');
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
            $token = $_GET['token'];
            if ($this->userModel->is_delete_account_token_valid($token)) {
                require_once 'views/confirm-account-deletion.php';
            } else {
                $_SESSION['message'] = "Invalid or expired token.";
                $this->redirectTo('myaccount.php');
            }
            
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
