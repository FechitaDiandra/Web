<?php
require_once 'views/header.php';
require_once 'models/FormModel.php';

if ($_SESSION['isLogged'] == false) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_id'])) {
    $formId = intval($_POST['form_id']);
    $formModel = new FormModel();

    if ($formModel->deleteForm($formId)) {
        header("Location: views/form-history.php?status=success");
        exit;
    } else {
        echo "Eroare la ștergerea formularului.";
    }
} else {
    echo "Cerere invalidă.";
}
?>
