<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/login-register.css">
  <script>
    function submitRegistrationForm(event) {
      event.preventDefault();

      var formData = {
        username: document.querySelector('input[name="username"]').value,
        email: document.querySelector('input[name="email"]').value,
        password: document.querySelector('input[name="password"]').value,
        password_repeat: document.querySelector('input[name="password-repeat"]').value
      };

      if (formData.password !== formData.password_repeat) {
        displayErrorMessage('Passwords do not match.');
        return;
      }

      if (formData.password.length < 8) {
        displayErrorMessage('Password must be at least 8 characters long.');
        return;
      }

      var specialCharacters = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
      if (!specialCharacters.test(formData.password)) {
        displayErrorMessage('Password must contain at least one special character.');
        return;
      }

      clearErrorMessage();

      document.querySelector('.form-container').submit();
    }

    function displayErrorMessage(message) {
      var errorElement = document.getElementById('error-message');
      errorElement.textContent = message;
      errorElement.style.display = 'block';
    }

    function clearErrorMessage() {
      var errorElement = document.getElementById('error-message');
      errorElement.textContent = '';
      errorElement.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
      document.querySelector('.form-container').addEventListener('submit', submitRegistrationForm);
    });
  </script>

</head>
<body>

  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>
    <form class="form-container" action="register" method="post">

    <?php if (isset($_SESSION['message'])): ?>
      <p class="session-message"><?php echo $_SESSION['message']; ?></p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required><br>

    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" required><br>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required><br>

    <label for="password-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="password-repeat" required>

    <br><br>
    <div class="checkbox-container">
        <label for="terms" class="checkbox-label">
            <input type="checkbox" name="terms" id="terms" required>
            <span class="small-text">By creating an account you agree to our <a href="#">Terms & Privacy</a>.</span>
        </label>
    </div>

    <div id="error-message" style="display: none; color: red; margin-top: 10px;"></div>
    <div class="clearfix">
      <button type="submit" class="submitbutton">Sign Up</button>
    </div>
    </form>
  </div>
</body>
</html>