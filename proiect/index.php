<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$_SESSION['isLogged'] = $_SESSION['isLogged'] ?? false;
require_once 'controllers/Router.php';

$router = Router::getInstance();
$router->route();
?>
