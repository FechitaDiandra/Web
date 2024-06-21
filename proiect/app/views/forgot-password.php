<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>

  <div class="container">
    <h1>Reset Password</h1>
    <p>Please enter your email address in order to receive a link for resetting your password.</p>
    <hr>
    <form class="form-container" action="reset-password-form" method="post">
    <?php if (isset($_SESSION['message'])): ?>
      <p class="session-message"><?php echo $_SESSION['message']; ?></p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
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
