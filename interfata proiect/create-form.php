<?php
  session_start();
  if ($_SESSION['isLogged']) {
    include 'header2.html'; 
  } else {
      include 'header1.html';
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="create-form.css">
</head>
<body>
  <div class="form-container">
  <form>
    <h1>Feedback Form</h1>
    <p>Create a feedback form</p>

    <label for="feedback-type">Feedback Type</label><br>
    <input type="radio" id="comments" name="feedback-type" value="comments">
    <label for="comments">Comments</label>
    <input type="radio" id="suggestions" name="feedback-type" value="suggestions">
    <label for="suggestions">Suggestions</label>
    <input type="radio" id="questions" name="feedback-type" value="questions">
    <label for="questions">Questions</label><br><br>

    <label for="description">Describe Your Feedback: *</label><br>
    <textarea id ="description"></textarea><br><br>

    <div class ="name-input">
        <input type ="text" placeholder = "First Name"><input type ="text" placeholder = "Last Name"> 
    </div>
    <label for="email">E-mail *</label><br>
    <input type="email" id="email" placeholder="ex: myname@example.com"><br>
    <small>example@example.com</small><br>

  </form>
</div>
</body>
</html>
