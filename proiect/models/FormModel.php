<?php
require_once 'entities/Form.php';

class FormModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "database_name"); // Schimbă "database_name" cu numele bazei tale de date
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
        $stmt = $this->mysql->prepare("SELECT * FROM forms WHERE form_id = ?");
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->mysql->error);
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

}
?>
