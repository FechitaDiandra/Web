<?php

class LogoutController {
    public function index() {
        $_SESSION['isLogged'] = false;
        header("Location: index.php");
        exit;
    }
}
?>
