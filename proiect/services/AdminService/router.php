<?php
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

include 'AdminController.php';

$adminController = new AdminController();

$basePath = '/web/proiect/services/AdminService/';
$request = str_replace($basePath, '', $request);
$request = trim($request, '/');

switch ($method) {
    case 'POST':
       
        break;    
    case 'GET':
        
        break;
    case 'PUT':
       
        break;
    case 'DELETE':
        
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['message' => 'Method Not Allowed'], JSON_PRETTY_PRINT);
        break;
}
?>
