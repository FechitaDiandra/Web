<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Add your feedback!</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>
  <div class="form-container">
    <form action="submited-feedback.php" method="POST" enctype="multipart/form-data">

      <h1>Add your feedback!</h1>

      <div class="input-box">
        <h2>Title:</h2>
        <p><?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?></p>
      </div>

      <div class="input-box">
        <h2>Feedback Type:</h2>
        <p><?php echo isset($_POST['feedback-type']) ? htmlspecialchars($_POST['feedback-type']) : ''; ?></p>
      </div>

      <div class="input-box">
        <h2>Requested Feedback Description:</h2>
        <p><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></p>
      </div>

      <?php
        if (isset($_FILES['file-upload']) && $_FILES['file-upload']['error'] === UPLOAD_ERR_OK) {
          $file = $_FILES['file-upload'];
          $fileTmpName = $file['tmp_name'];
          
          // Move the uploaded file to a temporary location
          $tempPath = 'user-uploads/' . basename($file['name']);
          move_uploaded_file($fileTmpName, $tempPath);
          
          // Display the uploaded file
          echo '<div class="input-box">';
          echo '<img src="' . $tempPath . '" alt="Uploaded Image">';
          echo '</div>';
        }
      ?>

      <?php
        if (isset($_GET['id'])) {
            $formId = $_GET['id'];
            echo '<input type="hidden" name="form_id" value="' . htmlspecialchars($formId) . '">';
        } else {
            echo "No form ID provided.";
        }
      ?>

      <div class="input-box">
        <h2>Form Expiry Date and Time:</h2>
        <p>Date: <?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : ''; ?></p>
        <p>Time: <?php echo isset($_POST['time']) ? htmlspecialchars($_POST['time']) : ''; ?></p>
      </div>

      <div class="input-box">
        <h2>Please provide us your age:</h2>
        <input type="number" name="age" required>
      </div>

      <div class="input-box">
        <h2>Are you related to this field?</h2>
        <label><input type="radio" name="relation" value="yes" required>Yes</label> <br>
        <label><input type="radio" name="relation" value="no" required>No</label>
      </div>

      <div class="input-box">
        <h2>Your Feedback:</h2>
        <textarea name="feedback" rows="5" cols="40" required></textarea>
      </div>

      <label for="emotion-bar">How do you feel about this?</label>
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

      <input type="submit" value="Submit Feedback">
      <button id="report" type="button" onclick="reportForm()">Report Form</button>
    </form>

    <script>
        var emotions = document.querySelectorAll('.emotion');
        emotions.forEach(function(emotion) {
            emotion.addEventListener('click', function() {
                document.getElementById('selected-emotion').innerText = 'The selected emotion is: ' + this.getAttribute('data-emotion');
            });
        });

        function reportForm() {
            alert('Form has been reported.');
        }
    </script>
  </div>
</body>
</html>
