<?php
  session_start();
  if ($_SESSION['isLogged']) {
    include 'header2.html';
  } else {
      include 'header1.html';
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Log In</h1>
    <p>Log into your account or <a href="signup.php">Register</a></p>
    <hr>
    <form class="login-form" action="login.php">
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required><br><br>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required><br><br>

      <label>
        <input type="checkbox" checked="checked" name="remember">
        <span class="small-text">Remember me</span>
      </label>
          
      <div class="clearfix">
        <button type="submit" class="submitbutton">Login</button>
      </div>
    </form>
  </div>

</body>
</html>
