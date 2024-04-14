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
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>
    <form class="signup-form" action="signup.php">
      <label for="firstname"><b>First Name</b></label>
      <input type="text" placeholder="Enter First Name" name="firstname" required><br><br>

      <label for="lastname"><b>Last Name</b></label>
      <input type="text" placeholder="Enter Last Name" name="lastname" required><br><br>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required><br><br>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required><br><br>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required><br><br>

      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>

      <label>
        <input type="checkbox" checked="checked" name="terms">
        <span class="small-text">By creating an account you agree to our</span>
        <a href="#" style="color:dodgerblue" class="small-text">Terms & Privacy</a>.
      </label>

      <div class="clearfix">
        <button type="submit" class="submitbutton">Sign Up</button>
      </div>
    </form>
  </div>
</body>
</html>