<?php
  session_start();
  if ($_SESSION['isLogged']) {
    include 'header2.html'; 
  } else {
      include 'header1.html';
  }
  
  if ($_SESSION['isLogged'] == false)  {header("Location: login.php");}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="form.css">
</head>
<body>
  <div class="form-container">
  <form action="answer-form.php" method="POST"  enctype="multipart/form-data">

      <h1>Create your own form!</h1>
      <label for="feedback-type">Feedback Type</label><br>

      <div class="input-box">
        <input type="radio" id="comments" name="feedback-type" value="comments" required>
        <label for="comments">Comments</label>
        <input type="radio" id="suggestions" name="feedback-type" value="suggestions" required>
        <label for="suggestions">Suggestions</label>
        <input type="radio" id="questions" name="feedback-type" value="questions" required>
        <label for="questions">Questions</label><br><br>
      </div>

      <label for="title">Give your form a title:</label><br>
      <textarea id="title" name="title" required></textarea><br><br>

      <label for="description">Describe your requested feedback:</label><br>
      <textarea id="description" name="description" required></textarea><br><br>

      <div class="input-box">
        <label for="duration">How long do you want your form to last? </label><br>
        <input type="date" id="date" name="date" required>
        <input type="time" id="time" name="time" required><br><br>
      </div>

      <div class="input-box">
        <label for="file-upload">File Upload</label><br>
        <input type="file" id="file-upload" name="file-upload"><br>
        <small>You can put a photo here to match your feedback.</small><br>
     </div>

      <input type="submit" value="Create Form">

    </form>
  </div>
</body>

</html>
