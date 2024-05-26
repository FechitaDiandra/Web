<?php
require_once '../header.php';
require_once '../models/FeedbackModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file-upload'])) {
    $file = $_FILES['file-upload'];
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

    $feedbackModel = new FeedbackModel();

    if ($fileType === 'csv') {
        $feedbackModel->importFromCSV($file['tmp_name']);
    } elseif ($fileType === 'json') {
        $feedbackModel->importFromJSON($file['tmp_name']);
    } else {
        die("Invalid file type.");
    }

    header("Location: feedback-imported.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Import Feedback</title>
    <link rel="stylesheet" type="text/css" href="../css/import-feedback.css">
</head>
<body>
    <div class="form-container">
        <h1>Import Feedback</h1>
        <form action="import-feedback.php" method="post" enctype="multipart/form-data">
            <label for="file-upload">Import CSV/JSON:</label>
            <input type="file" name="file-upload" id="file-upload" required>
            <button type="submit">Import</button>
        </form>
    </div>
</body>
</html>
