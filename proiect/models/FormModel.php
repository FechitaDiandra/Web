<?php
require_once 'entities/Form.php';

class FormModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "foe_app");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Crearea unui formular nou
    public function createForm($user_id, $title, $description, $is_published, $delete_form_token, $delete_form_token_expires) {
        $sql = "INSERT INTO forms (user_id, title, description, is_published, delete_form_token, delete_form_token_expires) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->conn->error);
        }
        $stmt->bind_param("ississ", $user_id, $title, $description, $is_published, $delete_form_token, $delete_form_token_expires);
        return $stmt->execute();
    }

    // Ștergerea unui formular după ID
    public function deleteForm($form_id) {
        $sql = "DELETE FROM forms WHERE form_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->conn->error);
        }
        $stmt->bind_param("i", $form_id);
        return $stmt->execute();
    }

    // Obținerea unui formular după ID
    public function getFormById($form_id) {
        $stmt = $this->conn->prepare("SELECT * FROM forms WHERE form_id = ?");
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->conn->error);
        }
        $stmt->bind_param("i", $form_id);
        if (!$stmt->execute()) {
            die('A survenit o eroare la obținerea formularului: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $form_data = $result->fetch_assoc();
        $stmt->close();

        if ($form_data) {
            return new Form(
                $form_data['form_id'],
                $form_data['user_id'],
                $form_data['title'],
                $form_data['description'],
                $form_data['is_published'],
                $form_data['created_at'],
                $form_data['delete_form_token'],
                $form_data['delete_form_token_expires']
            );
        } else {
            return null;
        }
    }

    // Obținerea tuturor formularelor după user_id
    public function getAllFormsByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM forms WHERE user_id = ?");
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->conn->error);
        }
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            die('A survenit o eroare la obținerea formularelor: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $forms = [];
        while ($form_data = $result->fetch_assoc()) {
            $forms[] = new Form(
                $form_data['form_id'],
                $form_data['user_id'],
                $form_data['title'],
                $form_data['description'],
                $form_data['is_published'],
                $form_data['created_at'],
                $form_data['delete_form_token'],
                $form_data['delete_form_token_expires']
            );
        }
        $stmt->close();
        return $forms;
    }
}
?>
