<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Reset Password</h1>
    <p>Please enter your email address to receive a link to reset your password.</p>
    <hr>
    <form class="reset-form" action="reset-password.php" method="post">
      <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
      ?>
      <br><br>
      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required><br><br>

      <div class="clearfix">
        <button type="submit" class="submitbutton">Send Reset Link</button>
      </div>
    </form>
  </div>

</body>
</html>
