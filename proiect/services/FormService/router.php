<?php
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

include 'FormController.php';

$formController = new FormController();

$basePath = '/web/proiect/services/FormService/';
$request = str_replace($basePath, '', $request);
$request = trim($request, '/');

switch ($method) {
    case 'POST':
        if ($request === 'form') {
            $formController->createForm();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }   
        break;    
    case 'GET':
        if ($request === 'forms') {
            $formController->getAllForms();
        } else if ($request === 'public-forms') {
            $formController->getPublicAvailableForms();
        } else if ($request === 'reported-forms') {
            $formController->getReportedForms();
        } else if (preg_match('/^form\/(\d+)$/', $request, $matches) && $request === 'form/'.$matches[1]) {
            $id = $matches[1];
            $formController->getFormById($id);
        } else if (preg_match('/^users-forms\/(\d+)$/', $request, $matches) && $request === 'users-forms/'.$matches[1]) {
            $userId = $matches[1];
            $formController->getFormsByUserId($userId);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;
    case 'PUT':
        if (preg_match('/^report-form\/(\d+)$/', $request, $matches) && $request === 'report-form/'.$matches[1]) {
            $formId = $matches[1];
            $formController->reportForm($formId);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;
    case 'DELETE':
        if (preg_match('/^form\/(\d+)$/', $request, $matches) && $request === 'form/'.$matches[1]) {
            $formId = $matches[1];
            $formController->deleteForm($formId);
        } elseif (preg_match('/^users-forms\/(\d+)$/', $request, $matches) && $request === 'users-forms/'.$matches[1]) {
            $userId = $matches[1];
            $formController->deleteFormsByUserId($userId);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['message' => 'Method Not Allowed'], JSON_PRETTY_PRINT);
        break;
}
?>
