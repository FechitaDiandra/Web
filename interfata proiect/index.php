<?php
session_start(); 
$_SESSION['isLogged'] = true;
if ($_SESSION['isLogged']) {
    include 'header2.html'; 
} else {
    include 'header1.html'; 
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

  <!-- video -->
  <div class="video-container">
    <video autoplay loop muted class="video-bg">
      <source src="video.mp4" type="video/mp4">
    </video>
    <div class="overlay">
      <div class="text_on_video">
        <p style="font-size: 36px; color: white; text-align: center;">FEEDBACK ON EVERYTHING</p>
        <div class="swipe-up-arrow" id="arrow-btn">↑</div>
      </div>
    </div>
  </div>
  <script>  
const swipeUpArrow = document.querySelector('.swipe-up-arrow');
const videoContainer = document.querySelector('.video-container');
const contentContainer = document.querySelector('.container');

swipeUpArrow.addEventListener('click', function() {
  videoContainer.classList.add('fade-out');
  setTimeout(function() {
    window.location.href = 'home.php'; //Redirect
  }, 300);//(milliseconds)
});
</script>

