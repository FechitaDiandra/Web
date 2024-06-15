
<?php
require_once 'entities/Answer.php';

class AnswerModel {

    private $mysql;

    public function __construct() {
        $this->mysql = new mysqli('localhost', 'root', '', 'foe_app');
        if (mysqli_connect_errno()) {
            die('Conexiunea a eșuat: ' . mysqli_connect_error());
        }
    }

    // Crearea unui răspuns nou
    public function createAnswer($form_id, $user_id, $response) {
        $stmt = $this->mysql->prepare("INSERT INTO answers (form_id, user_id, response) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->mysql->error);
        }
        $stmt->bind_param("iis", $form_id, $user_id, $response);
        if (!$stmt->execute()) {
            die('A survenit o eroare la crearea răspunsului: ' . $stmt->error);
        }
        $stmt->close();
    }

    // Obținerea unui răspuns după ID (opțional, dacă este necesar)
    public function getAnswerById($answer_id) {
        $stmt = $this->mysql->prepare("SELECT * FROM answers WHERE answer_id = ?");
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->mysql->error);
        }
        $stmt->bind_param("i", $answer_id);
        if (!$stmt->execute()) {
            die('A survenit o eroare la obținerea răspunsului: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $answer_data = $result->fetch_assoc();
        $stmt->close();

        if ($answer_data) {
            return new Answer(
                $answer_data['answer_id'],
                $answer_data['form_id'],
                $answer_data['user_id'],
                $answer_data['response'],
                $answer_data['created_at']
            );
        } else {
            return null;
        }
    }
}
?>
