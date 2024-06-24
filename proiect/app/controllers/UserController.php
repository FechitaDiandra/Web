<?php
require_once 'BaseController.php';
require_once 'models/UserModel.php';


class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getUserById($id) {
        $response = $this->userModel->getUserById($id);
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            return $responseDecoded['message'];
        }

        return "Error retrieving your account details..";
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $rememberMe = isset($_POST['remember_me']) && $_POST['remember_me'];

        if (empty($email) || empty($password)) {
            $_SESSION['message'] = 'Email and password are required.';
            $this->redirect('login');
        }

        $response = $this->userModel->login($email, $password, $rememberMe);
        $responseDecoded = json_decode($response, true);

        if ($responseDecoded['success']) {
            $user = $this->userModel->getUserByEmail($email);
            $userDecoded = json_decode($user, true);

            if ($userDecoded['success']) {
                $_SESSION['isLogged'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['id'] = $userDecoded['message']['user_id'];
                $_SESSION['username'] = $userDecoded['message']['username'];
                $_SESSION['role'] = $userDecoded['message']['role'];
                $this->redirect('myaccount');
            } else {
                $_SESSION['message'] = 'Failed to retrieve user details.';
            }
        } else {
            $_SESSION['message'] = $responseDecoded['message'];
        }

        $this->redirect('login');
        exit;
    }

    public function logout(){
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        $this->redirect('login');
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['message'] = 'Username, email, and password are required.';
            $this->redirect('register');
        }

        $response = $this->userModel->register($username, $email, $password);
        $responseDecoded = json_decode($response, true);

        if ($responseDecoded['success']) {
            $user = $this->userModel->getUserByEmail($email);
            $userDecoded = json_decode($user, true);

            if ($userDecoded['success']) {
                $_SESSION['isLogged'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['id'] = $userDecoded['message']['user_id'];
                $_SESSION['role'] = $userDecoded['message']['role'];
                $this->redirect('myaccount');
            } else {
                $_SESSION['message'] = 'Failed to retrieve user details.';
            }
        } else {
            $_SESSION['message'] = $responseDecoded['message'];
        }

        $this->redirect('register');
        exit;
    }

    public function updateUsername() {
        $newUsername = trim($_POST['username']);
        $id = $_SESSION['id'] ?? '';

        if (empty($newUsername)) {
            $_SESSION['message'] = 'Username cannot be empty.';
        } else {
            $updateData = ['username' => $newUsername];
            $response = $this->userModel->updateUserById($id,$updateData);
            $responseDecoded = json_decode($response, true);

            if ($response && $responseDecoded['success']) {
                $_SESSION['username'] = $newUsername;
                $_SESSION['message'] = 'Username updated successfully.';
            } else {
                $_SESSION['message'] = $responseDecoded['message'];
            }
        }

        $this->redirect('myaccount');
    }

    //DELETE ACCOUNT FUNCTIONS
    public function deleteAccount() {
        $userId = $_SESSION['id'] ?? null;
        $email = $_SESSION['email'] ?? null;
    
        // Default message
        $_SESSION['message'] = 'Failed to initiate deletion.';
    
        if ($userId && $email) {
            $deleteAccountToken = bin2hex(random_bytes(16));
            $deleteAccountTokenExpires = date('Y-m-d H:i:s', time() + 3600);
        
            $updateData = [
                'delete_account_token' => $deleteAccountToken,
                'delete_account_token_expires' => $deleteAccountTokenExpires
            ];
            $response = $this->userModel->updateUserById($userId, $updateData);
            $responseDecoded = json_decode($response, true);
        
            if ($response && $responseDecoded['success']) {
                $sendLink = $this->userModel->sendDeleteAccountLink($email, $deleteAccountToken);
                if ($sendLink) 
                    $_SESSION['message'] = 'A confirmation link has been sent to your email address.';
                else 
                    $_SESSION['message'] = 'Failed to send the confirmation link. Please try again later.';
            }
        } else {
            $_SESSION['message'] = 'User is not logged in.';
        }
    
        $this->redirect('myaccount');
    }
    
    public function isDeleteAccountTokenValid($token) {
        return $this->userModel->isDeleteAccountTokenValid($token);
    }

    public function confirmAccountDeletion() {
        $token = $_POST['token'] ?? null;
        $userId = $this->userModel->getUserIdByDeleteToken($token);

        if ($token && $userId && $this->userModel->isDeleteAccountTokenValid($token)) {

            $response = $this->userModel->deleteUser($userId);
            $responseDecoded = json_decode($response, true);

            if ($responseDecoded && $responseDecoded['success']) {
                $_SESSION = array();
                session_destroy();

                session_start();
                $_SESSION['message'] = 'Your account has been successfully deleted.';
            } else {
                $_SESSION['message'] = 'There was an error deleting your account.';
            }
        } else {
            $_SESSION['message'] = 'Invalid token.';
        }

        $this->redirect('myaccount');
    }

    //RESET PASSWORD FUNCTIONS
    //1) for non-logged users
    public function resetPassword(){
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        //get user id by email
        $user = $this->userModel->getUserByEmail($email);
        $userDecoded = json_decode($user, true);
        if($user && $userDecoded['success']) {
            $userId = $userDecoded['message']['user_id'];
        }

        if ($userId && $email) {
            $resetPasswordToken = bin2hex(random_bytes(16));
            $resetPasswordTokenExpires = date('Y-m-d H:i:s', time() + 3600);
        
            $updateData = [
                'reset_password_token' => $resetPasswordToken,
                'reset_password_token_expires' => $resetPasswordTokenExpires
            ];
            $response = $this->userModel->updateUserById($userId, $updateData);
            $responseDecoded = json_decode($response, true);
        
            if ($response && $responseDecoded['success']) {
                $sendLink = $this->userModel->sendResetPasswordLink($email, $resetPasswordToken);
                if ($sendLink) 
                    $_SESSION['message'] = 'A reset link has been sent to your email address.';
                else 
                    $_SESSION['message'] = 'Failed to send the resetlink. Please try again later.';
            }
        } else {
            $_SESSION['message'] = 'Invalid email address.';
        }

        $this->redirect('forgot-password');
    }

    //2) for logged in users
    public function changePassword(){
        $userId = $_SESSION['id'] ?? null;
        $email = $_SESSION['email'] ?? null;

        // Default message
        $_SESSION['message'] = 'Failed to initiate pasword resetting.';
    
        if ($userId && $email) {
            $resetPasswordToken = bin2hex(random_bytes(16));
            $resetPasswordTokenExpires = date('Y-m-d H:i:s', time() + 3600);
        
            $updateData = [
                'reset_password_token' => $resetPasswordToken,
                'reset_password_token_expires' => $resetPasswordTokenExpires
            ];
            $response = $this->userModel->updateUserById($userId, $updateData);
            $responseDecoded = json_decode($response, true);
        
            if ($response && $responseDecoded['success']) {
                $sendLink = $this->userModel->sendResetPasswordLink($email, $resetPasswordToken);
                if ($sendLink) 
                    $_SESSION['message'] = 'A password reset link has been sent to your email address.';
                else 
                    $_SESSION['message'] = 'Failed to send the password reset link. Please try again later.';
            }
        } else {
            $_SESSION['message'] = 'User is not logged in.';
        }

        $this->redirect('myaccount');
    }

    public function isResetPasswordTokenValid($token) {
        return $this->userModel->isResetPasswordTokenValid($token);
    }

    public function confirmResetPassword(){
        $token = $_POST['token'] ?? null;
        $userId = $this->userModel->getUserIdByResetPasswordToken($token);
        $password = $_POST['password'] ?? null;
        $password_repeat = $_POST['password-repeat'] ?? null;
        if ($password != $password_repeat)
            $_SESSION['message'] = 'The passwords do not match.';
        else {
            if ($token && $userId && $this->userModel->isResetPasswordTokenValid($token)) {

                $updateData = ['password' => $password];
                $response = $this->userModel->updateUserById($userId, $updateData);
                $responseDecoded = json_decode($response, true);

                if ($responseDecoded && $responseDecoded['success']) {
                    $_SESSION['message'] = 'Your password has been successfully updated.';
                    //invalidate the token
                    $updateData = [
                        'reset_password_token' => null,
                        'reset_password_token_expires' => null
                    ];
                    $this->userModel->updateUserById($userId, $updateData);
                } else {
                    $_SESSION['message'] = 'There was an error updating your password. Please try again later.';
                }
            } else {
                $_SESSION['message'] = 'Invalid token.';
            }
        }

        $this->render('new-password-form', ['token' => $token]);
    }

    //CHANGE EMAIL FUNCTIONS
    public function changeEmail(){
        $userId = $_SESSION['id'] ?? null;
        $email = $_SESSION['email'] ?? null;

        // Default message
        $_SESSION['message'] = 'Failed to initiate email change.';
        if ($userId && $email) {
            $changeEmailToken = bin2hex(random_bytes(16));
            $changeEmailTokenExpires = date('Y-m-d H:i:s', time() + 3600);
        
            $updateData = [
                'change_email_token' => $changeEmailToken,
                'change_email_token_expires' => $changeEmailTokenExpires
            ];
            $response = $this->userModel->updateUserById($userId, $updateData);
            $responseDecoded = json_decode($response, true);
        
            if ($response && $responseDecoded['success']) {
                $sendLink = $this->userModel->sendEmailChangeLink($email, $changeEmailToken);
                if ($sendLink) 
                    $_SESSION['message'] = 'An email change link has been sent to your email address.';
                else 
                    $_SESSION['message'] = 'Failed to send the email change link. Please try again later.';
            }
        } else {
            $_SESSION['message'] = 'User is not logged in.';
        }

        $this->redirect('myaccount');
    }

    public function isChangeEmailTokenValid($token) {
        return $this->userModel->isChangeEmailTokenValid($token);
    }

    public function confirmEmailChange(){
        $token = $_POST['token'] ?? null;
        $userId = $this->userModel->getUserIdByChangeEmailToken($token);
        $email = $_POST['new-email'] ?? null;
        $email_repeat = $_POST['confirm-new-email'] ?? null;
        if ($email != $email_repeat)
            $_SESSION['message'] = 'The emails do not match.';
        else {
            if ($token && $userId && $this->userModel->isChangeEmailTokenValid($token)) {

                $updateData = ['email' => $email];
                $response = $this->userModel->updateUserById($userId, $updateData);
                $responseDecoded = json_decode($response, true);

                if ($responseDecoded && $responseDecoded['success']) {
                    $_SESSION['message'] = 'Your email has been successfully updated.';
                    //invalidate the token
                    $updateData = [
                        'change_email_token' => null,
                        'change_email_token_expires' => null
                    ];
                    $this->userModel->updateUserById($userId, $updateData);
                    $_SESSION['email'] = $email;
                } else {
                    $_SESSION['message'] = $responseDecoded['message'];
                }
            } else {
                $_SESSION['message'] = 'Invalid token.';
            }
        }

        $this->render('new-email-form', ['token' => $token]);
    }

    public function sendEmailFromContactPage(){
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        $to = "contact2feedbackoneverything@gmail.com";
        $subject = "New Contact Form Submission";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            $_SESSION['message'] = "Your message has been sent successfully!";
        } else {
            $_SESSION['message'] = "There was an error sending your message. Please try again.";
        }

        $this->redirect('contact');
    }
}
?>
