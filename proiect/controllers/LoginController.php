<?php
require_once 'models/UserModel.php';

class LoginController {

    public function index() {
        $userModel = new UserModel();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_button'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($userModel->verify_login($email, $password)) {
                //create a token and save it in the database
                if (isset($_POST['remember_me'])) { 
                    $token = $userModel->generate_token();
                    $userModel->store_remember_me_token($email, $token);
                    $_SESSION['remember_me_token'] = $token;
                    setcookie('remember_me_token', $token, time() + (86400 * 30), "/");
                } else {
                    //if 'remember me' is not checked delete the cookie and its corresponding token from the database
                    setcookie('remember_me_token', '', time() - 3600, "/");
                    $userModel->store_remember_me_token($email, 'NULL');
                }

                $_SESSION['email'] = $email;
                $username = $userModel->get_username_by_email($email);
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['isLogged'] = true;
                header("Location: home.php");
                return;
            } else {
                $_SESSION['message'] = "Failed to login. Email or password are incorrect.";
                header("Location: login.php");
                return;
            }
        }

        if (isset($_COOKIE['remember_me_token'])) {
            $token = $_COOKIE['remember_me_token'];
            $email = $userModel->get_email_by_remember_me_token($token);

            if ($email !== false) {
                $_SESSION['remember_me_token'] = $token;
                $_SESSION['email'] = $email;
                $password = $userModel->get_password_by_email($email);
                $_SESSION['password'] = $password;
            }
        }

        require_once 'views/login.php';
    }
}
?>