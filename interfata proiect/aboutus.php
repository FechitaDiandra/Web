<?php
session_start();
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
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="aboutus.css">
  <style>
    /* Adăugați stilurile CSS necesare aici */
  </style>
</head>
<body>
  <div class="video-container">
    <video autoplay loop muted class="video-bg">
      <source src="video.mp4" type="video/mp4">
    </video>
    <div class="overlay">
      <div class="container_video">
        <p style="font-size: 36px; color: white; text-align: center;">FEEDBACK ON EVERYTHING</p>
        <div class="swipe-up-arrow" id="arrow-btn">↑</div>
      </div>
    </div>
  </div>

  <div class="container" id ="about-us">
    <h1>Instrument Web pentru Feedback Anonim</h1>
    <p>Bine ați venit în instrumentul nostru web pentru feedback anonim! Aici puteți oferi feedback pentru diverse aspecte, cum ar fi evenimente, persoane, locuri geografice, produse, servicii, artefacte artistice și multe altele. Feedback-ul pe care îl oferiți va fi exprimat printr-o gamă de emoții conform modelului Plutchik.</p>
    <p>Procesul este simplu:</p>
    <ol>
        <li><strong>Selectați lucrul de care doriți să oferiți feedback</strong>: Puteți alege din lista noastră variată de lucruri pentru care dorim să primim feedback.</li>
        <li><strong>Oferiți feedback-ul</strong>: Exprimați-vă emoția față de lucrul respectiv selectând una dintre opțiunile de feedback bazate pe modelul Plutchik.</li>
        <li><strong>Asigurați-vă că feedback-ul este anonim</strong>: Nu trebuie să vă faceți griji cu privire la dezvăluirea identității dvs. Feedback-ul este complet anonim.</li>
        <li><strong>Gestionați-vă răspunsurile</strong>: După ce ați oferit feedback, puteți reveni și să-l editați, dacă este necesar. Suntem aici pentru a asigura că exprimați corect ceea ce simțiți.</li>
    </ol>
    <p>După încheierea perioadei de colectare a feedback-ului pentru un anumit lucru, vom genera rapoarte detaliate pentru a vă oferi o imagine completă a sentimentelor exprimate în legătură cu acel lucru. Aceste rapoarte vor include statistici relevante pentru fiecare categorie de lucruri evaluate conform fiecărei emoții înregistrate. De asemenea, vor fi luate în considerare criterii multiple, cum ar fi grupul de utilizatori, perioada de timp în care s-a realizat evaluarea, subcategoriile de lucruri și caracteristicile considerate pozitive/negative pe baza emoției exprimate.</p>
    <p>Rapoartele generate vor fi disponibile în formatele HTML, CSV și JSON, pentru a vă oferi flexibilitate în analiză și utilizare.</p>
    <p>Vă mulțumim că ați ales să utilizați instrumentul nostru web pentru feedback anonim. Ne dorim să vă oferim cea mai bună experiență și să vă asigurăm că vocea dvs. contează!</p>
  </div>
  <script src="script.js"></script>
  <script>

// JavaScript pentru a ascunde videoul când faceți clic pe săgeată și arătați conținutul principal// JavaScript pentru a ascunde videoul când faceți clic pe săgeată și arătați conținutul principal cu o tranziție frumoasă
const swipeUpArrow = document.querySelector('.swipe-up-arrow');
const videoContainer = document.querySelector('.video-container');
const contentContainer = document.querySelector('.container');

swipeUpArrow.addEventListener('click', function() {
  // Adăugăm o clasă pentru a declanșa tranziția de fading
  videoContainer.classList.add('fade-out');
  // Folosim un eveniment care se declanșează după ce tranziția s-a terminat pentru a ascunde videoul și a arăta conținutul
  videoContainer.addEventListener('transitionend', function() {
    videoContainer.style.display = 'none'; // Ascunde videoul
    contentContainer.style.display = 'block'; // Afișează conținutul
  });
});

  </script>

</body>
</html>