<?php
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

include 'UserController.php';

$userController = new UserController();

$basePath = '/web/proiect/services/UserService/';
$request = str_replace($basePath, '', $request);
$request = trim($request, '/');

switch ($method) {
    case 'POST':
        if ($request === 'register') {
            $userController->registerUser();
        } elseif ($request === 'login') {
            $userController->loginUser();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;
    case 'GET':
        if ($request === 'users') {
            $userController->getAllUsers();
        } elseif (preg_match('/^user\/(\d+)$/', $request, $matches) && $request === 'user/'.$matches[1]) {
            $id = $matches[1];
            $userController->getUserById($id);
        } elseif (preg_match('/^user\/([^\/]+)$/', $request, $matches) && $request === 'user/'.$matches[1]) {
            $email = $matches[1];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $userController->getUserByEmail($email);
            } else {
                header("HTTP/1.0 404 Not Found");
                echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;
    case 'PUT':
        if (preg_match('/^user\/(\d+)$/', $request, $matches) && $request === 'user/'.$matches[1]) {
            $userId = $matches[1];
            $userController->updateUser($userId);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Not Found'], JSON_PRETTY_PRINT);
        }
        break;
    case 'DELETE':
        if (preg_match('/^user\/(\d+)$/', $request, $matches) && $request === 'user/'.$matches[1]) {
            $userId = $matches[1];
            $userController->deleteUser($userId);
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
