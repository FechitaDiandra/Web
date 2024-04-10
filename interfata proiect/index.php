<?php
session_start(); //sesiunea se creeaza automat cand se acceseaza pagina principala index.html

$_SESSION['isLogged'] = true;
if ($_SESSION['isLogged']) {
    include 'header2.html'; // Includeți antetul pentru utilizatorii autentificați
} else {
    include 'header1.html'; // Includeți antetul pentru utilizatorii neautentificați
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
 
</body>
</html>
