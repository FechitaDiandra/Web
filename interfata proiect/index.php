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

    <div class="form-fields">
      <!-- Aici vor fi câmpurile pentru descriere și formular -->
      <input type="text" placeholder="Descriere" class="description-input">
      <textarea placeholder="Introdu formularul aici" class="form-textarea"></textarea>
      <button class="publica-button">Publică</button>
    </div>

  
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="Iconiță utilizator"> Utilizator anonim
      <h2>Titlu formular</h2>
      <p>Descriere formular</p>
      <a href="#">Accesează formularul</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="Iconiță utilizator"> Utilizator anonim
      <h2>Titlu formular</h2>
      <p>Descriere formular</p>
      <a href="#">Accesează formularul</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="Iconiță utilizator"> Utilizator anonim
      <h2>Titlu formular</h2>
      <p>Descriere formular</p>
      <a href="#">Accesează formularul</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="Iconiță utilizator"> Utilizator anonim
      <h2>Titlu formular</h2>
      <p>Descriere formular</p>
      <a href="#">Accesează formularul</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="Iconiță utilizator"> Utilizator anonim
      <h2>Titlu formular</h2>
      <p>Descriere formular</p>
      <a href="#">Accesează formularul</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="Iconiță utilizator"> Utilizator anonim
      <h2>Titlu formular</h2>
      <p>Descriere formular</p>
      <a href="#">Accesează formularul</a>
  </div>
</div>  


</body>
</html>
