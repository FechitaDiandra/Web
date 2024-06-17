<?php 
require_once 'header.php';
if (isset($_GET['token'])) {  $_SESSION['reset_password_token'] = $_GET['token']; }
$token = $_SESSION['reset_password_token'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
  <script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.change-password-form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();

    var password = document.querySelector('input[name="password"]').value;
    var passwordRepeat = document.querySelector('input[name="password-repeat"]').value;
    var errors = [];

    if (password !== passwordRepeat) {
      errors.push("Passwords do not match.");
    }
    if (password.length < 8) {
      errors.push("Password must be at least 8 characters long.");
    }
    if (!/[A-Z]/.test(password)) {
      errors.push("Password must contain at least one uppercase letter.");
    }
    if (!/[a-z]/.test(password)) {
      errors.push("Password must contain at least one lowercase letter.");
    }
    if (!/\d/.test(password)) {
      errors.push("Password must contain at least one number.");
    }
    if (!/[\'^£$%&*()}{#~?><>,|=_+¬-]/.test(password)) {
      errors.push("Password must contain at least one special character.");
    }

    if (errors.length > 0) {
      alert(errors.join("\n"));
      return;
    }

    // If all validations are passed, submit the form
    form.submit();
  });
});
</script>

</head>
<body>

  <div class="container">
    <h1>Update password</h1>
    <p></p>
    <hr>
    <form class="change-password-form" action="confirm-reset-password" method="post">
      <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
      ?>
      <br><br>
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required><br><br>

      <label for="password-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="password-repeat" required><br><br>

      <div class="clearfix">
        <button type="submit" class="submitbutton">Change password</button>
      </div>
    </form>
  </div>

  
</body>
</html>