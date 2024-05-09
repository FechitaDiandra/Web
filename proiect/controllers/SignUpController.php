<?php
require_once 'models/UserModel.php';

class SignUpController {
    public function index() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password-repeat'];

            if ($password !== $password_repeat) {
                $_SESSION['message'] = "Passwords do not match.";
                header("Location: signup.php");
                return;
            }

            $userModel = new UserModel();

            if ($userModel->create_user($username, $email, $password)) {
                if (isset($_POST['remember_me'])) {
                    $token = $userModel->generate_token();
                    $_SESSION['remember_me_token'] = $token;
                    $userModel->store_remember_me_token($email, $token);
                    setcookie('remember_me_token', $token, time() + (86400 * 30), "/");
                }

                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['username'] = $username;
                $_SESSION['isLogged'] = true;
                header("Location: home.php");
                return;
            } else {
                $_SESSION['message'] = "Failed to sign up. An account with this email already exists.";
                header("Location: signup.php");
                return;
            }
        } 

        require_once 'views/signup.php';
    }
}
?>