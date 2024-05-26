<?php
class FeedbackModel {
    private $mysql;

    public function __construct() {
        $this->mysql = new mysqli('localhost', 'root', '', 'foe_app');
        if (mysqli_connect_errno()) {
            die('Conexiunea a eșuat: ' . mysqli_connect_error());
        }
    }

    public function getFeedbackByFormId($form_id) {
        $stmt = $this->mysql->prepare("SELECT * FROM feedback WHERE form_id = ?");
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->mysql->error);
        }
        $stmt->bind_param("i", $form_id);
        if (!$stmt->execute()) {
            die('A survenit o eroare la obținerea feedback-ului: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $feedbacks = [];
        while ($feedback_data = $result->fetch_assoc()) {
            $feedbacks[] = $feedback_data;
        }
        $stmt->close();
        return $feedbacks;
    }

    public function exportFeedbackToCSV($form_id) {
        $feedbacks = $this->getFeedbackByFormId($form_id);
        if (!$feedbacks) {
            die("No feedback found.");
        }

        $filename = "feedback_form_$form_id.csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, array('Feedback ID', 'Form ID', 'User ID', 'Feedback', 'Emotion', 'Date'));
        foreach ($feedbacks as $feedback) {
            fputcsv($output, $feedback);
        }
        fclose($output);
    }

    public function exportFeedbackToJSON($form_id) {
        $feedbacks = $this->getFeedbackByFormId($form_id);
        if (!$feedbacks) {
            die("No feedback found.");
        }

        $filename = "feedback_form_$form_id.json";
        header('Content-Type: application/json');
        header('Content-Disposition: attachment;filename=' . $filename);

        echo json_encode($feedbacks, JSON_PRETTY_PRINT);
    }

    public function importFromCSV($filePath) {
        $file = fopen($filePath, 'r');
        // Sări peste antet
        fgetcsv($file);
        while (($line = fgetcsv($file)) !== FALSE) {
            $stmt = $this->mysql->prepare("INSERT INTO feedback (form_id, user_id, feedback, emotion, date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisss", $line[0], $line[1], $line[2], $line[3], $line[4]);
            $stmt->execute();
        }
        fclose($file);
    }

    public function importFromJSON($filePath) {
        $data = file_get_contents($filePath);
        $feedbacks = json_decode($data, true);

        foreach ($feedbacks as $feedback) {
            $stmt = $this->mysql->prepare("INSERT INTO feedback (form_id, user_id, feedback, emotion, date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisss", $feedback['form_id'], $feedback['user_id'], $feedback['feedback'], $feedback['emotion'], $feedback['date']);
            $stmt->execute();
        }
    }
}
?>
