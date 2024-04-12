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
  <script src="script.js"></script>
  <script>


const swipeUpArrow = document.querySelector('.swipe-up-arrow');
const videoContainer = document.querySelector('.video-container');
const contentContainer = document.querySelector('.container');

swipeUpArrow.addEventListener('click', function() {
  videoContainer.classList.add('fade-out');
  videoContainer.addEventListener('transitionend', function() {
    videoContainer.style.display = 'none'; 
    contentContainer.style.display = 'block'; 
  });
});

  </script>
</body>
</html>