<?php
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

include 'AnswerController.php';

$answerController = new AnswerController();

$basePath = '/web/proiect/services/AnswerService/';
$request = str_replace($basePath, '', $request);
$request = trim($request, '/');

switch ($method) {
    case 'POST':
        if ($request === 'answer') {
            $answerController->addAnswer();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;    
    case 'GET':
        if (preg_match('/^answers\/(\d+)$/', $request, $matches) && $request === 'answers/'.$matches[1]) {
            $id = $matches[1];
            $answerController->getAnswersByFormId($id);
        } else if (preg_match('/^get-statistics\/(\d+)$/', $request, $matches) && $request === 'get-statistics/'.$matches[1]) {
            $id = $matches[1];
            $answerController->getStatisticsByFormId($id);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;
    case 'PUT':
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        break;
    case 'DELETE':
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['message' => 'Method Not Allowed'], JSON_PRETTY_PRINT);
        break;
}
?>
