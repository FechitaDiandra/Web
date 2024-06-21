<?php
require_once 'BaseController.php';
require_once 'models/AnswerModel.php';

class AnswerController extends BaseController {
    private $answerModel;

    public function __construct() {
        $this->answerModel = new AnswerModel();
    }
    
    public function answerForm($formId){
        if (!isset($_POST['age'], $_POST['feedback'], $_POST['selected_emotion'], $_POST['gender'], $_POST['education_level'], $_POST['experience'])) {
            $_SESSION['message'] = 'All fields are required.';
            $this->redirect("answer-form?id=$formId");
        }
    
        $age = intval($_POST['age']);
        $feedback = htmlspecialchars($_POST['feedback'], ENT_QUOTES, 'UTF-8');
        $selectedEmotion = htmlspecialchars($_POST['selected_emotion'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
        $educationLevel = htmlspecialchars($_POST['education_level'], ENT_QUOTES, 'UTF-8');
        $experience = htmlspecialchars($_POST['experience'], ENT_QUOTES, 'UTF-8');

        if (empty($age) || empty($feedback) || empty($selectedEmotion) || empty($gender) || empty($educationLevel) || empty($experience)) {
            $_SESSION['message'] = 'All fields must be filled.';
            $this->redirect("answer-form?id=$formId");
        }
    
        $feedbackData = [
            'form_id' => $formId,
            'users_age' => $age,
            'content' => $feedback,
            'emotion_type' => $selectedEmotion,
            'gender' => $gender,
            'education_level' => $educationLevel,
            'experience' => $experience
        ];
        error_log('Feedback Data: ' . print_r($feedbackData, true));

        $response = $this->answerModel->answerForm($feedbackData);
        $responseDecoded = json_decode($response, true);
        error_log('responseDecoded ' . print_r($responseDecoded, true));


        if ($responseDecoded['success']) {
                $_SESSION['message'] = "Thank you! Your feedback was successfully submitted.";
        } else {
            $_SESSION['message'] = 'Error submitting your feedback: ' . $responseDecoded['message'];
        }

        $this->redirect("answer-form?id=$formId");
    }

    public function getAnswersByFormId($id){
        $response = $this->answerModel->getAnswersByFormId($id);
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            return $responseDecoded['message'];
        }

        return "Error retrieving the answers for your form.";
    }

    public function getStatisticsByFormId($id){
        $response = $this->answerModel->getStatisticsByFormId($id);
        
        $responseDecoded = json_decode($response, true);
        
        if($responseDecoded['success']) {
            return $responseDecoded['message'];
        }

        return "Error retrieving the answers for your form.";
    }

    public function exportStatistics($statistics, $formId, $type) {
        $answers = $this->getAnswersByFormId($formId);
        switch ($type) {
            case 'csv':
                $csv = $this->generateCsvExport($statistics, $answers);
                return $csv;
                break;
            case 'json':
                return json_encode(['statistics' => $statistics, 'answers' => $answers]);
                break;
            case 'html':
                $html = $this->generateHtmlExport($statistics, $answers);
                return $html;
                break;
            default:
                return false;
        }

    }

    private function generateCsvExport($statistics, $answers) {
        ob_start();
        $output = fopen('php://output', 'w');
        
        fputcsv($output, ['Category', 'Value', 'Count']);
        
        foreach ($statistics['emotion_distribution'] as $emotion) {
            fputcsv($output, ['Emotion', $emotion['emotion_type'], $emotion['count']]);
        }
    
        foreach ($statistics['age_distribution'] as $age) {
            fputcsv($output, ['Age', $age['users_age'], $age['count']]);
        }
    
        foreach ($statistics['gender_distribution'] as $gender) {
            fputcsv($output, ['Gender', $gender['gender'], $gender['count']]);
        }
    
        foreach ($statistics['education_distribution'] as $education) {
            fputcsv($output, ['Education Level', $education['education_level'], $education['count']]);
        }
    
        foreach ($statistics['experience_distribution'] as $experience) {
            fputcsv($output, ['Experience', $experience['experience'], $experience['count']]);
        }
    
        fputcsv($output, ['Total Answers', '', $statistics['total_answers']]);
        fputcsv($output, ['Average Age', '', $statistics['average_age']]);
    
        fputcsv($output, []);
        fputcsv($output, ['Individual Answers']);
        fputcsv($output, ['Age', 'Feedback', 'Selected Emotion', 'Gender', 'Education Level', 'Experience', 'Created At']);

        foreach ($answers as $answer) {
            fputcsv($output, [
                $answer['users_age'],
                $answer['content'],
                $answer['emotion_type'],
                $answer['gender'],
                $answer['education_level'],
                $answer['experience'],
                $answer['created_at']
            ]);
        };
    
        fclose($output);
        return ob_get_clean();
    }
    
    
    private function generateHtmlExport($statistics, $answers) {
        ob_start();
        echo "<html><head><title>Statistics Export</title></head><body>";
        
        echo "<h2>Emotion Distribution</h2>";
        echo "<ul>";
        foreach ($statistics['emotion_distribution'] as $emotion) {
            echo "<li>{$emotion['emotion_type']}: {$emotion['count']}</li>";
        }
        echo "</ul>";
    
        echo "<h2>Age Distribution</h2>";
        echo "<ul>";
        foreach ($statistics['age_distribution'] as $age) {
            echo "<li>Age {$age['users_age']}: {$age['count']}</li>";
        }
        echo "</ul>";
    
        echo "<h2>Gender Distribution</h2>";
        echo "<ul>";
        foreach ($statistics['gender_distribution'] as $gender) {
            echo "<li>Gender {$gender['gender']}: {$gender['count']}</li>";
        }
        echo "</ul>";
    
        echo "<h2>Education Level Distribution</h2>";
        echo "<ul>";
        foreach ($statistics['education_distribution'] as $education_level) {
            echo "<li>Education Level {$education_level['education_level']}: {$education_level['count']}</li>";
        }
        echo "</ul>";
    
        echo "<h2>Experience Distribution</h2>";
        echo "<ul>";
        foreach ($statistics['experience_distribution'] as $experience) {
            echo "<li>Experience {$experience['experience']}: {$experience['count']}</li>";
        }
        echo "</ul>";
    
        echo "<h2>Total Answers</h2>";
        echo "<p>{$statistics['total_answers']}</p>";
    
        echo "<h2>Average Age</h2>";
        echo "<p>{$statistics['average_age']}</p>";
    
        echo "<h2>Individual Answers</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Age</th><th>Feedback</th><th>Selected Emotion</th><th>Gender</th><th>Education Level</th><th>Experience</th><th>Created At</th></tr>";
    
        foreach ($answers as $answer) {
            echo "<tr>";
            echo "<td>{$answer['users_age']}</td>";
            echo "<td>{$answer['content']}</td>";
            echo "<td>{$answer['emotion_type']}</td>";
            echo "<td>{$answer['gender']}</td>";
            echo "<td>{$answer['education_level']}</td>";
            echo "<td>{$answer['experience']}</td>";
            echo "<td>{$answer['created_at']}</td>";
            echo "</tr>";
        }
    
        echo "</table>";
        echo "</body></html>";
    
        return ob_get_clean();
    }
    
    
    
}
?>