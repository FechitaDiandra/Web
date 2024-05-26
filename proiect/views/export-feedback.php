<?php
require_once '../models/FeedbackModel.php';

$formId = isset($_GET['form_id']) ? intval($_GET['form_id']) : null;
$format = isset($_GET['format']) ? $_GET['format'] : 'csv';

if ($formId) {
    $feedbackModel = new FeedbackModel();
    if ($format === 'csv') {
        $feedbackModel->exportFeedbackToCSV($formId);
    } elseif ($format === 'json') {
        $feedbackModel->exportFeedbackToJSON($formId);
    } else {
        die("Invalid format.");
    }
} else {
    die("No form ID provided.");
}
?>
