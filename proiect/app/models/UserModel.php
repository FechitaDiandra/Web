<?php
class UserModel {
    private $serviceUrl;
    private $db;
    private $host = 'localhost';
    private $db_name = 'foe_app';
    private $username = 'root';
    private $password = '';
    public function __construct() {
        $this->serviceUrl = 'http://localhost/web/proiect/services/UserService/';
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    function customLog($message) {
        $logFile = __DIR__ . '/../custom_log.txt';
        $currentTime = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$currentTime] $message" . PHP_EOL, FILE_APPEND);
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
    public function register($username, $email, $password, $rememberMe) {
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

        if ($httpcode === 200) {
            if ($rememberMe) {
                //set a cookie that expires in 30 days
                // $token = $this->generateRememberMeToken($authenticatedUser->id);
                // setcookie('remember_me_token', $token, time() + (30 * 24 * 60 * 60), '/');
            }
        } 
        
        return $response; //returns the json encoded from the service call
    }

    
    private function isValidPassword($password) {
        // Verificare minim 8 caractere, cel puțin o literă mare, o literă mică, un număr și un caracter special
        $isValid = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
        error_log("Password validation result for '$password': " . ($isValid ? 'valid' : 'invalid'));
        return $isValid;
    }

    public function updateProfilePicture($userId, $filePath) {
        $sql = "UPDATE users SET file_path = ? WHERE user_id = ?";
    
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param('si', $filePath, $userId);
    
            if ($stmt->execute()) {
                error_log("Profile picture updated successfully for user ID: $userId");
                return json_encode(['success' => true]);
            } else {
                error_log("Database error: " . $stmt->error);
                return json_encode(['success' => false, 'message' => 'Database error.']);
            }
    
            $stmt->close();
        } else {
            error_log("Database error: " . $this->db->error);
            return json_encode(['success' => false, 'message' => 'Database error.']);
        }
    }
    

    public function updateUserById($userId, $userData) {
        $setPart = [];
        $params = [];
        $types = '';
    
        foreach ($userData as $key => $value) {
            $setPart[] = "$key = ?";
            $params[] = $value;
            $types .= 's';
        }
        $params[] = $userId;
        $types .= 'i';
    
        $sql = "UPDATE users SET " . implode(', ', $setPart) . " WHERE user_id = ?";
    
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param($types, ...$params);
    
            if ($stmt->execute()) {
                return json_encode(['success' => true]);
            } else {
                error_log("Database error: " . $stmt->error);
                return json_encode(['success' => false, 'message' => 'Database error.']);
            }
    
            $stmt->close();
        } else {
            error_log("Database error: " . $this->db->error);
            return json_encode(['success' => false, 'message' => 'Database error.']);
        }
    }
    

    public function deleteUser($userId) {
        $curl = curl_init($this->serviceUrl . 'user/' . $userId);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);

        if (isset($error_msg)) {
            return json_encode(['success' => false, 'message' => $error_msg]);
        }
    
        if ($httpcode === 200) {
            return $response; //returns the json encoded
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