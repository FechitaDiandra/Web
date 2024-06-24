<?php
include 'Database.php';

class AnswerModel {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function addAnswer($formData) {
        if (!isset($formData['form_id'], $formData['content'], $formData['emotion_type'], $formData['users_age'], $formData['gender'], $formData['education_level'], $formData['experience'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }

        $formId = intval($formData['form_id']);
        $age = intval($formData['users_age']);
        $content = htmlspecialchars($formData['content'], ENT_QUOTES, 'UTF-8');
        $emotionType = htmlspecialchars($formData['emotion_type'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($formData['gender'], ENT_QUOTES, 'UTF-8');
        $educationLevel = htmlspecialchars($formData['education_level'], ENT_QUOTES, 'UTF-8');
        $experience = htmlspecialchars($formData['experience'], ENT_QUOTES, 'UTF-8');
        
        if (empty($content) || empty($emotionType) || empty($formId) || empty($age) || empty($gender) || empty($educationLevel) || empty($experience)) {
            return ['success' => false, 'message' => 'All fields must be filled'];
        }

        $validEmotionTypes = ['Joy', 'Trust', 'Fear', 'Sadness', 'Anger', 'Anticipation', 'Surprise', 'Disgust'];
        if (!in_array($emotionType, $validEmotionTypes)) {
            return ['success' => false, 'message' => 'Invalid emotion type'];
        }

        $query = "INSERT INTO answers (form_id, users_age, content, emotion_type, gender, education_level, experience, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("iisssss", $formId, $age, $content, $emotionType, $gender, $educationLevel, $experience);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Answer added successfully!'];
        } else {
            return ['success' => false, 'message' => $stmt->error];
        }
    }


    public function getAnswersByFormId($id) {
        $query = "SELECT * FROM answers WHERE form_id = ? ORDER BY created_at DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $answers = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'message' => $answers];
        } else {
            return  ['success' => false, 'message' => $this->connection->error];
        }
    }

    public function getStatisticsByFormId($id) {
        $formExistsQuery = "SELECT COUNT(*) FROM forms WHERE form_id = ?";
        $stmt = $this->connection->prepare($formExistsQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $formExists = $result->fetch_row()[0];
    
        if (!$formExists) {
            return ['success' => false, 'message' => 'Form does not exist.'];
        }

        
        $statistics = [];
    
        $query = "SELECT emotion_type, COUNT(*) as count FROM answers WHERE form_id = ? GROUP BY emotion_type";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $emotionDistribution = $result->fetch_all(MYSQLI_ASSOC);
            $statistics['emotion_distribution'] = $emotionDistribution;
        }
    
        $query = "SELECT users_age, COUNT(*) as count FROM answers WHERE form_id = ? GROUP BY users_age";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $ageDistribution = $result->fetch_all(MYSQLI_ASSOC);
            $statistics['age_distribution'] = $ageDistribution;
        }
    
        $query = "SELECT gender, COUNT(*) as count FROM answers WHERE form_id = ? GROUP BY gender";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $genderDistribution = $result->fetch_all(MYSQLI_ASSOC);
            $statistics['gender_distribution'] = $genderDistribution;
        }
    
        $query = "SELECT education_level, COUNT(*) as count FROM answers WHERE form_id = ? GROUP BY education_level";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $educationDistribution = $result->fetch_all(MYSQLI_ASSOC);
            $statistics['education_distribution'] = $educationDistribution;
        }
    
        $query = "SELECT experience, COUNT(*) as count FROM answers WHERE form_id = ? GROUP BY experience";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $experienceDistribution = $result->fetch_all(MYSQLI_ASSOC);
            $statistics['experience_distribution'] = $experienceDistribution;
        }
    
        $query = "SELECT COUNT(*) as total_answers FROM answers WHERE form_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalAnswers = $result->fetch_assoc();
            $statistics['total_answers'] = $totalAnswers['total_answers'];
        }
    
        $query = "SELECT AVG(users_age) as average_age FROM answers WHERE form_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $averageAge = $result->fetch_assoc();
            if ($averageAge > 0) $statistics['average_age'] = $averageAge['average_age'];
            else $statistics['average_age'] = 0;
        }
        
        if (empty($statistics)) {
            return ['success' => false, 'message' => 'No statistics available for this form.'];
        }

        return ['success' => true, 'message' => $statistics];
    }
    
}