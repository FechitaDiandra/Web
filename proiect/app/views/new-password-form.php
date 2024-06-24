<?php 
require_once 'header.php';
if (isset($_GET['token'])) {  $_SESSION['reset_password_token'] = $_GET['token']; }
$token = $_SESSION['reset_password_token'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything - Update Password</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <script>
    function submitResetPasswordForm(event) {
      event.preventDefault();

      var password = document.querySelector('input[name="password"]').value;
      var passwordRepeat = document.querySelector('input[name="password-repeat"]').value;

      if (password.length < 8) {
        displayErrorMessage('Password must be at least 8 characters long.');
        return;
      }

      var specialCharacters = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
      if (!specialCharacters.test(password)) {
        displayErrorMessage('Password must contain at least one special character.');
        return;
      }

      if (password !== passwordRepeat) {
        displayErrorMessage('Passwords do not match.');
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
      document.querySelector('.form-container').addEventListener('submit', submitResetPasswordForm);
    });
  </script>
</head>
<body>

  <div class="container">
    <h1>Update password</h1>
    <p></p>
    <hr>
    <form class="form-container" action="confirm-reset-password" method="post">
      <?php if (isset($_SESSION['message'])): ?>
        <p class="session-message"><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
      <br><br>
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required><br><br>

      <label for="password-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="password-repeat" required><br><br>

      <div id="error-message"></div>

      <div class="clearfix">
        <button type="submit" class="submitbutton">Change password</button>
      </div>
    </form>
  </div>

  
</body>
</html>