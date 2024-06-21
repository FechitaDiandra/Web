<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>View Form</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const shareLinkInput = document.getElementById('shareLink');
      const feedbackMessage = document.getElementById('feedbackMessage');

      function copyToClipboard() {
        shareLinkInput.select();
        document.execCommand('copy');
        feedbackMessage.style.display = 'block'
      }

      shareLinkInput.addEventListener('click', copyToClipboard);
    });
  </script>
</head>
<body>
  <div class="container">
    <form>
      <h1>View Form Details</h1>
      <br><br>

      <?php if (isset($_SESSION['message'])): ?>
        <p class="session-message"><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
        <br><br>
      <?php endif; ?>

      <p>Click the link below to copy it and share the form with your friends or targeted users:</p>
      <input type="text" id="shareLink" value="http://localhost/web/proiect/app/answer-form?id=<?php echo htmlspecialchars($form['form_id']) ?>" readonly>
      <div id="feedbackMessage" style="display: none;">Copied to clipboard!</div><br><br>

      <div class="input-box">
        <label for="feedback_type">Feedback Type</label><br>
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
        <label for="answer_time">Collecting Feedback Until:</label><br>
        <input type="text" id="answer_time" name="answer_time" value="<?php echo htmlspecialchars($form['answer_time']); ?>" readonly>
      </div>

      <div class="input-box">
        <label for="is_published">Public:</label><br>
        <input type="text" id="is_published" name="is_published" value="<?php echo $form['is_published'] ? 'Yes' : 'No'; ?>" readonly>
      </div>
      <br>

      <div class="button-container">
        <a href="create-form" class="button">Create Another Form</a>
      </div>

      <?php if (isset($answers) && !empty($answers)): ?>
        <br><br><br>
        <h2>Answers:</h2>

        <table class="answer-table">
          <thead>
            <tr>
              <th>Age</th>
              <th>Gender</th>
              <th>Education Level</th>
              <th>Experience</th>
              <th>Feedback</th>
              <th>Emotion</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($answers as $answer): ?>
              <tr>
                <td><?php echo htmlspecialchars($answer['users_age']); ?></td>
                <td><?php echo htmlspecialchars($answer['gender']); ?></td>
                <td><?php echo htmlspecialchars($answer['education_level']); ?></td>
                <td><?php echo htmlspecialchars($answer['experience']); ?></td>
                <td><?php echo htmlspecialchars($answer['content']); ?></td>
                <td><?php echo htmlspecialchars($answer['emotion_type']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      <?php endif; ?>

    </form>
  </div>
</body>
</html>
