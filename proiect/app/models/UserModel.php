<?php
class UserModel {
    private $serviceUrl;

    public function __construct() {
        $this->serviceUrl = 'http://localhost/web/proiect/services/UserService/';
    }

    public function login($email, $password, $rememberMe) {
        $payload = json_encode([
            'email' => $email,
            'password' => $password
        ]);

        $ch = curl_init($this->serviceUrl . 'login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
            if ($rememberMe) {
                //set a cookie that expires in 30 days
                // $token = $this->generateRememberMeToken($authenticatedUser->id);
                // setcookie('remember_me_token', $token, time() + (30 * 24 * 60 * 60), '/');
            }
        } 
        
        return $response; //returns the json encoded from the service call
    }

    public function register($username, $email, $password) {
        $payload = json_encode([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);

        $ch = curl_init($this->serviceUrl . 'register');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        return $response; //returns the json encoded from the service call
    }

    public function getUserByEmail($email){
        $ch = curl_init($this->serviceUrl . 'user/' . $email);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
                return $response; //returns the json encoded
            }

        return json_encode(['success' => false, 'message' => "Retrieving the user from the database didn't work."]);
    }

    public function getUserById($id){
        $ch = curl_init($this->serviceUrl . 'user/' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        if ($httpcode === 200) {
                return $response; //returns the json encoded
            }

        return json_encode(['success' => false, 'message' => "Retrieving the user from the database didn't work."]);
    }

    public function updateUserById($userId, $userData) {
        $curl = curl_init($this->serviceUrl . 'user/' . $userId);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($userData));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg, 'http_code' => $httpcode]);
        }
        
    
        if ($httpcode === 200) {
            return json_encode(['success' => true, 'data' => $response]);
        }        

        return json_encode(['success' => false, 'message' => $response['message']]);
    }

    public function deleteUser($userId) {
        //delete the user's forms
        $curl = curl_init('http://localhost/web/proiect/services/FormService/users-forms/' . $userId);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $responseForms = curl_exec($curl);
        $httpcodeForms = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }

        
        //delete the account
        $curl = curl_init($this->serviceUrl . 'user/' . $userId);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $responseUser = curl_exec($curl);
        $httpcodeUser = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }
    
        if ($httpcodeUser === 200 && $httpcodeForms === 200) {
            return $responseUser; //returns the json encoded
        }

        return json_encode(['success' => false, 'message' => "Deleting the user didn't work as expected."]);
    }
    
    public function sendDeleteAccountLink($email, $token) {
        $resetLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/app/delete-account?token=$token";
        $to = $email;
        $subject = "Delete account";
        $message = "Here is your account deletion link: $resetLink. The link is valid for 1 hour.";
        $headers = "From: contactfeedbackoneverything@gmail.com";
    
        return mail($to, $subject, $message, $headers);
    }

    public function sendResetPasswordLink($email, $token) {
        $resetLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/app/reset-password?token=$token";
        $to = $email;
        $subject = "Password Reset";
        $message = "Here is your password resetting link: $resetLink. The link is valid for 1 hour.";
        $headers = "From: contactfeedbackoneverything@gmail.com";
    
        return mail($to, $subject, $message, $headers);
    }

    public function sendEmailChangeLink($email, $token) {
        $resetLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/app/change-email?token=$token";
        $to = $email;
        $subject = "Email Change";
        $message = "Here is your email change link: $resetLink. The link is valid for 1 hour.";
        $headers = "From: contactfeedbackoneverything@gmail.com";
    
        return mail($to, $subject, $message, $headers);
    }

    public function isDeleteAccountTokenValid($token) {
        $id = $this->getUserIdByDeleteToken($token);
        if(!$id) 
            return false;
        $user = $this->getUserById($id);
        $userDecoded = json_decode($user, true);
        if ($user && $userDecoded['success']) {
            $tokenExpires = $userDecoded['message']['delete_account_token_expires'] ?? null;
            if ($tokenExpires && $token === $userDecoded['message']['delete_account_token']) {
                return strtotime($tokenExpires) > time();
            }
        }
        return false;
    }

    public function isResetPasswordTokenValid($token) {
        $id = $this->getUserIdByResetPasswordToken($token);
        if(!$id) 
            return false;
        $user = $this->getUserById($id);
        $userDecoded = json_decode($user, true);
        if ($user && $userDecoded['success']) {
            $tokenExpires = $userDecoded['message']['reset_password_token_expires'] ?? null;
            if ($tokenExpires && $token === $userDecoded['message']['reset_password_token']) {
                return strtotime($tokenExpires) > time();
            }
        }
        return false;
    }

    public function isChangeEmailTokenValid($token) {
        $id = $this->getUserIdByChangeEmailToken($token);
        if(!$id) 
            return false;
        $user = $this->getUserById($id);
        $userDecoded = json_decode($user, true);
        if ($user && $userDecoded['success']) {
            $tokenExpires = $userDecoded['message']['change_email_token_expires'] ?? null;
            if ($tokenExpires && $token === $userDecoded['message']['change_email_token']) {
                return strtotime($tokenExpires) > time();
            }
        }
        return false;
    }

    public function getUserIdByChangeEmailToken($token) {
        $host = 'localhost';
        $db_name = 'foe_app';
        $username = 'root';
        $password = '';
        $conn = null;
    
        try {
            $conn = new mysqli($host, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $query = "SELECT user_id FROM users WHERE change_email_token = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $token);
                $stmt->execute();
                $stmt->bind_result($userId);
                if ($stmt->fetch()) {
                    $stmt->close();
                    $conn->close();
                    return $userId;
                }
                $stmt->close();
            }
            $conn->close();
            return null;
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
            return null;
        }
    }

    public function getUserIdByDeleteToken($token) {
        $host = 'localhost';
        $db_name = 'foe_app';
        $username = 'root';
        $password = '';
        $conn = null;
    
        try {
            $conn = new mysqli($host, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $query = "SELECT user_id FROM users WHERE delete_account_token = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $token);
                $stmt->execute();
                $stmt->bind_result($userId);
                if ($stmt->fetch()) {
                    $stmt->close();
                    $conn->close();
                    return $userId;
                }
                $stmt->close();
            }
            $conn->close();
            return null;
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
            return null;
        }
    }

    public function getUserIdByResetPasswordToken($token) {
        $host = 'localhost';
        $db_name = 'foe_app';
        $username = 'root';
        $password = '';
        $conn = null;
    
        try {
            $conn = new mysqli($host, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $query = "SELECT user_id FROM users WHERE reset_password_token = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $token);
                $stmt->execute();
                $stmt->bind_result($userId);
                if ($stmt->fetch()) {
                    $stmt->close();
                    $conn->close();
                    return $userId;
                }
                $stmt->close();
            }
            $conn->close();
            return null;
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
            return null;
        }
    }

}

?>