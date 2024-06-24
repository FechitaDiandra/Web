<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="css/login-register.css">
</head>

<body>
  <div class="container">
    <h1>Log In</h1>
    <p>Log into your account or <a href="register">Register</a></p>
    <hr>
    <form class="form-container" action="login" method="post">
    <?php if (isset($_SESSION['message'])): ?>
      <p class="session-message"><?php echo $_SESSION['message']; ?></p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <br><br>

    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" required value><br><br>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required value>

    <div class="checkbox-container">
        <label for="remember_me" class="checkbox-label">
            <input type="checkbox" name="remember_me" id="remember_me">
            <span class="small-text">Remember me</span>
        </label>
    </div>

    <p class="small-text">
      <a href="forgot-password">Forgot Password?</a>
    </p>
   
    <div id="error-message" style="display: none; color: red; margin-top: 10px;"></div>
    <div class="clearfix">
      <button type="submit" class="submitbutton" name="login_button">Login</button>
    </div>
    </form>
  </div>

</body>
</html>
