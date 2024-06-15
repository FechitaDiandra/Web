<?php
class BaseController {

    protected function render($view, $data = []) {
        if (!is_array($data)) {
            $data = [];
        }
        extract($data);
        require_once "views/{$view}.php";
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

}
?>
