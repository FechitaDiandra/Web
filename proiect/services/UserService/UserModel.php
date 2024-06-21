<?php
include 'Database.php';

class UserModel {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function register($userData) {
        if (!isset($userData['username'], $userData['email'], $userData['password'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }
        //CHECK FIRST IF AN USER WITH THAT EMAIL EXISTS
        $checkQuery = "SELECT * FROM users WHERE email = ?";
        $checkStmt = $this->connection->prepare($checkQuery);
        $checkStmt->bind_param("s", $userData['email']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            return ['success' => false, 'message' => 'User already exists with this email'];
        }

        //PROCEED WITH THE INSERT
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $userData['username'], $userData['email'], $passwordHash);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'User created successfully'];
        } else {
            return ['success' => false, 'message' => $stmt->error];
        }
    }

    public function login($data) {
        if (!isset($data['email'], $data['password'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }
        $email = $data['email'];
        $password = $data['password'];
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return ['success' => true, 'message' => 'Login successful'];
        } else {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user) {
            return ['success' => true, 'message' => $user];
        } else {
            return ['success' => false, 'message' => 'No user found with email ' . $email];
        }
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user) {
            return ['success' => true, 'message' => $user];
        } else {
            return ['success' => false, 'message' => 'No user found with id ' . $id];
        }
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'message' => $users];
        } else {
            return  ['success' => false, 'message' => $this->connection->error];
        }
    }

    public function updateUser($id, $userData) {
        //VERIFY FIRST THAT THE USER WITH THE SPECIFIED ID EXISTS IN THE DATABASE
        $userExistsQuery = "SELECT * FROM users WHERE user_id = ?";
        $userExistsStmt = $this->connection->prepare($userExistsQuery);
        $userExistsStmt->bind_param("i", $id);
        $userExistsStmt->execute();
        $userExistsResult = $userExistsStmt->get_result();
        
        if ($userExistsResult->num_rows == 0) {
            return ['success' => false, 'message' => 'No user found with ID ' . $id];
        }

        //PROCEED WITH THE UPDATE
        $fieldsToUpdate = [];
        $values = [];

        foreach ($userData as $field => $value) {
            //Skip if its not a valid field in the database
            if (!in_array($field, ['username', 'email', 'password', 'delete_account_token', 'delete_account_token_expires',
                               'reset_password_token', 'reset_password_token_expires', 'change_email_token', 'change_email_token_expires', 'remember_me_token'])) {
                continue;
            }

            //make sure username, email, and password fields are not null
            if (in_array($field, ['username', 'email', 'password']) && $value === null) {
                continue;
            }
            
            //hash the password before updating
            if ($field === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }

            //if the field is email, check if there is another existing account with that email
            if($field === 'email') {
                $emailExistsQuery = "SELECT * FROM users WHERE email = ? AND user_id != ?";
                $emailExistsStmt = $this->connection->prepare($emailExistsQuery);
                $emailExistsStmt->bind_param("si", $value, $id);
                $emailExistsStmt->execute();
                $emailExistsResult = $emailExistsStmt->get_result();
            
                if ($emailExistsResult->num_rows > 0) {
                    return ['success' => false, 'message' => 'This email is already in use.'];
                }
            }

            $fieldsToUpdate[] = "$field = ?";
            $values[] = $value;
        }

        if (empty($fieldsToUpdate)) {
            return ['success' => false, 'message' => 'No valid fields provided for update'];
        }

        $values[] = $id;

        $query = "UPDATE users SET " . implode(', ', $fieldsToUpdate) . " WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);

        if ($stmt->execute()) 
            return ['success' => true, 'message' => 'User updated successfully'];

        
        return ['success' => false, 'message' => $stmt->error];
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return ['success' => true, 'message' => 'User deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'No user found with ID ' . $id];
            }
        } else {
            return ['success' => false, 'message' => $this->connection->error];
        }
    }

}