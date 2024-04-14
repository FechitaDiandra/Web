<?php
    session_start();
    if ($_SESSION['isLogged']) {
        include 'header2.html';
    } else {
        include 'header1.html';
    }

    //vor trebui actualizate si in baza de date
    if (!isset($_SESSION['name'])) {
        $_SESSION['name'] = '';
    }
    
    if (!isset($_SESSION['email'])) {
        $_SESSION['email'] = '';
    }
    //verifica daca s-a trimis un formular pentru actualizarea datelor
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['name'])) {
            //actualizeaza numele
            $_SESSION['name'] = $_POST['name'];
        }

        if (isset($_POST['email'])) {
            $_SESSION['email'] = $_POST['email'];
        }

        //redirectioneaza catre pagina My Account actualizata
        header('Location: myaccount.php');
        exit();
    }
?>
