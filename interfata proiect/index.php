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

    <div class="form-fields">
      <input type="text" placeholder="Description" class="description-input">
      <textarea placeholder="Enter your form here" class="form-textarea"></textarea>
      <button class="publish-button">Publish</button>
    </div>

  
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="User Icon"> Anonymous User
      <h2>Form Title</h2>
      <p>Form Description</p>
      <a href="#">Access the form</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="User Icon"> Anonymous User
      <h2>Form Title</h2>
      <p>Form Description</p>
      <a href="#">Access the form</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="User Icon"> Anonymous User
      <h2>Form Title</h2>
      <p>Form Description</p>
      <a href="#">Access the form</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="User Icon"> Anonymous User
      <h2>Form Title</h2>
      <p>Form Description</p>
      <a href="#">Access the form</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="User Icon"> Anonymous User
      <h2>Form Title</h2>
      <p>Form Description</p>
      <a href="#">Access the form</a>
  </div>
  <div class="container">
    <div class="feedback-form">
      <img src="profile.jpg" alt="User Icon"> Anonymous User
      <h2>Form Title</h2>
      <p>Form Description</p>
      <a href="#">Access the form</a>
  </div>
</div>  


</body>
</html>
