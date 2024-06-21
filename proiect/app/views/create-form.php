<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <style>
    .error-message {
      color: red;
      margin-top: 5px;
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const dateInput = document.getElementById('date');
      const timeInput = document.getElementById('time');

      document.querySelector('form').addEventListener('submit', function(event) {
        const selectedDate = new Date(dateInput.value + 'T' + timeInput.value);
        const currentDate = new Date();

        if (selectedDate < currentDate) {
          alert('Please select a date and time later than the current time.');
          event.preventDefault();
        }
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('file').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
          document.getElementById('previewImage').src = e.target.result;
          document.getElementById('previewImage').style.display = 'block';
        };
        
        reader.readAsDataURL(file);
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const titleTextarea = document.getElementById('title');
      const descriptionTextarea = document.getElementById('description');
      const form = document.querySelector('form');

      const titleError = document.createElement('div');
      titleError.className = 'error-message';
      titleTextarea.parentNode.insertBefore(titleError, titleTextarea.nextSibling);

      const descriptionError = document.createElement('div');
      descriptionError.className = 'error-message';
      descriptionTextarea.parentNode.insertBefore(descriptionError, descriptionTextarea.nextSibling);

      const maxLength = 100; // Define maxLength for title and description

      titleTextarea.addEventListener('input', function() {
        if (titleTextarea.value.length > maxLength) {
          titleError.textContent = 'Title must be 100 characters or less.';
        } else {
          titleError.textContent = '';
        }
      });

      descriptionTextarea.addEventListener('input', function() {
        if (descriptionTextarea.value.length > maxLength) {
          descriptionError.textContent = 'Description must be 100 characters or less.';
        } else {
          descriptionError.textContent = '';
        }
      });

      form.addEventListener('submit', function(event) {
        let hasError = false;

        if (titleTextarea.value.length > maxLength) {
          titleError.textContent = 'Title must be 100 characters or less.';
          hasError = true;
        }

        if (descriptionTextarea.value.length > maxLength) {
          descriptionError.textContent = 'Description must be 100 characters or less.';
          hasError = true;
        }

        if (hasError) {
          event.preventDefault();
        }
      });
    });
  </script>
</head>
<body>
  <div class="container">
  <form action="create-form" method="POST"  enctype="multipart/form-data">

      <h1>Create your own personalized form!</h1>

      <?php if (isset($_SESSION['message'])): ?>
        <p class="session-message"><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
      <br><br>

      <div class="input-box">
        <label for="feedback_type">Feedback Type</label><br>
        <div class="radio-group">
            <label><input type="radio" id="comments" name="feedback_type" value="comments" required>Comments</label>
            <label><input type="radio" id="suggestions" name="feedback_type" value="suggestions" required>Suggestions</label>
            <label><input type="radio" id="questions" name="feedback_type" value="questions" required>Questions</label>
        </div>
      </div>

      <div class="input-box">
          <label for="title">Give your form a title:</label><br>
          <textarea id="title" name="title" required></textarea>
      </div>

      <div class="input-box">
          <label for="description">Describe your requested feedback:</label><br>
          <textarea id="description" name="description" required></textarea>
      </div>

      <div class="input-box">
          <label for="duration">How long do you want your form to last?</label><br>
          <input type="date" id="date" name="date" required>
          <input type="time" id="time" name="time" required>
      </div>

      <div class="input-box">
        <label for="file">Add a photo that matches your feedback request:</label><br><br>
        <input type="file" id="file" name="file" accept=".jpg, .jpeg, .png" ><br>
        <img id="previewImage" src="#" alt="Image preview" style="display: none;">
      </div>

      <div class="input-box">
        <label for="publish-form">Do you want this form to be published on our website?<br></label>
        <div class="radio-group">
          <label><input type="radio" name="public" value="yes" required>Yes</label>
          <label><input type="radio" name="public" value="no" required>No</label>
        </div>
      </div>

      <div class="button-container">
      <input type="submit" value="Create your form">
     </div>

    </form>
  </div>

</body>
</html>