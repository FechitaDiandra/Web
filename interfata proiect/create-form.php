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
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="create-form.css">
</head>
<body>
  <div class="form-container">
  <form>
    <h1>Feedback Form</h1>
    <p>Create your form</p>
    <label for="feedback-type">Feedback Type</label>
    <br> 
    <div class="input-box">
      
      <input type="radio" id="comments" name="feedback-type" value="comments">
      <label for="comments">Comments</label>
      <input type="radio" id="suggestions" name="feedback-type" value="suggestions">
      <label for="suggestions">Suggestions</label>
      <input type="radio" id="questions" name="feedback-type" value="questions">
      <label for="questions">Questions</label><br><br>
    </div>

    <label for="description">Describe Your Feedback: *</label><br>
    <textarea id ="description"></textarea><br><br>

    <label for="email">E-mail *</label><br>
    <input type="email" id="email" placeholder="ex: myname@example.com"><br>
    <label for="domain">Are you in domain? *</label><br>
    <div class="input-box">
  <input type="radio" id="yes" name="domain" value="yes">
  <label for="yes">Yes</label>
  <input type="radio" id="other" name="domain" value="other">
  <label for="other">Other</label><br><br>
</div>

<div class="input-box">
      <label for="duration">How long do you want your form to last? *</label><br>
      <input type="date" id="date" name="date">
      <input type="time" id="time" name="time"><br><br>
    </div>
    <div class="input-box">
      <label for="file-upload">File Upload</label><br>
      <input type="file" id="file-upload" name="file-upload"><br>
      <small>You can put a photo here to match your feedback.</small><br>
    </div>
    <label for="emotion-bar">How are you feeling today?</label>
    <div class="emotion-bar">
    <div class="emotion joy" data-emotion="Joy"></div>
    <div class="emotion trust" data-emotion="Trust"></div>
    <div class="emotion fear" data-emotion="Fear"></div>
    <div class="emotion sadness" data-emotion="Sadness"></div>
    <div class="emotion anger" data-emotion="Anger"></div>
    <div class="emotion anticipation" data-emotion="Anticipation"></div>
    <div class="emotion acceptance" data-emotion="Acceptance"></div>
    <div class="emotion disgust" data-emotion="Disgust"></div>
  </div>
  <div id="selected-emotion"></div>
  <input type="submit" value="Create Form">
  </form>
 <script>
var emotions = document.querySelectorAll('.emotion');
emotions.forEach(function(emotion) {
  emotion.addEventListener('click', function() {
   
    document.getElementById('selected-emotion').innerText = 'The selected emotion is: ' + this.getAttribute('data-emotion');
  });
});



</script>

</div>
</body>
</html>
