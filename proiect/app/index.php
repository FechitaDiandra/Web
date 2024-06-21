<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Bucharest'); 

session_start();

$session_timeout = 600; //10 min
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    session_unset();
    session_destroy();
} else {
    $_SESSION['LAST_ACTIVITY'] = time();
}

if (!isset($_SESSION['isLogged'])) {
    $_SESSION['isLogged'] = false;
}

require_once 'router.php';
require_once 'addRoutes.php';

?>
