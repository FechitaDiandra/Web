<?php
  session_start();
  if ($_SESSION['isLogged']) {
    include 'header2.html'; // Include the header for logged-in users
  } else {
      include 'header1.html'; // Include the header for non-logged-in users
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

  <div class="container">
    <h1>Log In</h1>
    <hr>
    <form class="signup-form">
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px">
        <span class="small-text">Remember me</span>
      </label>
          
      <div class="clearfix">
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </form>
  </div>

</body>
</html>
