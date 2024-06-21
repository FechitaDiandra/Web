<?php 
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add your feedback!</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <style>
    .button {
      padding: 5px 12px;
      font-size: 12px;
    }
  </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const emotionDivs = document.querySelectorAll('.emotion');
      const selectedEmotionInput = document.getElementById('selectedEmotion');
      const selectedEmotionDisplay = document.getElementById('selected-emotion');
      const feedbackTextarea = document.querySelector('textarea[name="feedback"]');
      const feedbackError = document.createElement('div');
      feedbackError.className = 'error-message';
      feedbackTextarea.parentNode.insertBefore(feedbackError, feedbackTextarea.nextSibling);

      emotionDivs.forEach(emotionDiv => {
        emotionDiv.addEventListener('click', function() {
          const selectedEmotion = emotionDiv.getAttribute('data-emotion');
          selectedEmotionInput.value = selectedEmotion;
          selectedEmotionDisplay.textContent = `Selected emotion: ${selectedEmotion}`;
        });
      });

      feedbackTextarea.addEventListener('input', function() {
        if (feedbackTextarea.value.length > 100) {
          feedbackError.textContent = 'Feedback must be 100 characters or less.';
        } else {
          feedbackError.textContent = '';
        }
      });

      document.querySelector('form').addEventListener('submit', function(event) {
        if (feedbackTextarea.value.length > 100) {
          event.preventDefault();
          feedbackError.textContent = 'Feedback must be 100 characters or less.';
        }
      });
    });
  </script>
  <style>
    .error-message {
        color: red;
    }
    </style>
</head>
<body>
  <div class="container">
    <form action="submit-feedback" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="form_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
      <h1>Add your feedback!</h1><br><br>

      <?php if (isset($_SESSION['message'])): ?>
        <p class="session-message"><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
        <br><br>
      <?php endif; ?>

      <div class="input-box">
        <h2>Feedback Type:</h2>
        <input type="text" id="feedback_type" name="feedback_type" value="<?php echo htmlspecialchars($form['feedback_type']); ?>" readonly>
      </div>

      <div class="input-box">
        <label for="title">Form Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($form['title']); ?>"readonly>
      </div>

      <div class="input-box">
        <label for="description">Form Description:</label><br>
        <input type="text" name="description" value="<?php echo htmlspecialchars($form['description']); ?>"readonly>
      </div>
      
      <?php if (!empty($form['file_path'])): ?>
      <div class="input-box">
        <label for="file">Attached File:</label><br><br>
          <img src="../user-uploads/<?php echo htmlspecialchars($form['file_path']); ?>" alt="Attached Image" style="max-width: 300px;"><br><br>
      </div>
      <?php endif; ?>

      <div class="input-box">
        <h2>Add your feedback until:</h2>
        <input type="text" id="answer_time" name="answer_time" value="<?php echo htmlspecialchars($form['answer_time']); ?>" readonly>
      </div>

      <div class="input-box">
        <h2>Please provide us your age:</h2>
        <input type="number" name="age" required>
      </div>

      <div class="input-box">
        <h2>Your Gender:</h2>
        <div class="radio-group">
          <label><input type="radio" name="gender" value="male" required> Male</label>
          <label><input type="radio" name="gender" value="female"> Female</label>
          <label><input type="radio" name="gender" value="other"> Other</label>
        </div>
      </div>

      <div class="input-box">
      <h2>Your Education Level:</h2>
      <select name="education_level">
        <option value="middle_school">Middle School (1-8)</option>
        <option value="high_school">High School</option>
        <option value="college_undergraduate">College Undergraduate</option>
        <option value="faculty">Faculty/University</option>
        <option value="masters_degree">Master's Degree</option>
        <option value="phd">Ph.D. or Doctorate</option>
        <option value="other">Other</option>
      </select>
    </div>

      <div class="input-box">
        <h2>Frequency of Use/Experience:</h2>
        <div class="radio-group">
          <label><input type="radio" name="experience" value="daily"> Daily</label>
          <label><input type="radio" name="experience" value="weekly"> Weekly</label>
          <label><input type="radio" name="experience" value="monthly"> Monthly</label>
          <label><input type="radio" name="experience" value="yearly"> Yearly</label>
          <label><input type="radio" name="experience" value="first_time"> First Time</label>
          <label><input type="radio" name="experience" value="never"> Never</label>
        </div>
    </div>

      <div class="input-box">
        <h2>Your Feedback:</h2>
        <textarea name="feedback" rows="5" cols="40" required></textarea>
      </div>

      <div class="input-box">
        <h2>How do you feel about this?</h2>
        <div class="emotion-bar">
          <div class="emotion joy" data-emotion="Joy"></div>
          <div class="emotion trust" data-emotion="Trust"></div>
          <div class="emotion fear" data-emotion="Fear"></div>
          <div class="emotion sadness" data-emotion="Sadness"></div>
          <div class="emotion anger" data-emotion="Anger"></div>
          <div class="emotion anticipation" data-emotion="Anticipation"></div>
          <div class="emotion surprise" data-emotion="Surprise"></small></div>
          <div class="emotion disgust" data-emotion="Disgust"></div>
        </div>
        <input type="hidden" id="selectedEmotion" name="selected_emotion">
        <div id="selected-emotion"></div>
      </div>

      <input type="submit" value="Submit Feedback">
      <a href="report-form?id=<?php echo htmlspecialchars($form['form_id']); ?>" class="button" onclick="return confirm('Are you sure you want to report this form?')">Report Form</a>
    </form>
  </div>

</body>
</html>
