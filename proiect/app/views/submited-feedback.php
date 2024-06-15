<?php
require_once 'header.php';
require_once 'models/AnswerModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formId = isset($_POST['form_id']) ? intval($_POST['form_id']) : null;
    $age = isset($_POST['age']) ? intval($_POST['age']) : null;
    $relation = isset($_POST['relation']) ? $_POST['relation'] : '';
    $feedback = isset($_POST['feedback']) ? trim($_POST['feedback']) : '';

    // Verificăm dacă datele necesare sunt prezente
    if ($formId && $age && !empty($relation) && !empty($feedback)) {
        $userId = $_SESSION['user_id']; // Presupunând că user_id este salvat în sesiune
        $answerModel = new AnswerModel();
        $answerModel->createAnswer($formId, $userId, $feedback);
        header("Location: thank-you.php");
        exit;
    } else {
        echo "Please provide valid feedback.";
    }
}
?>
