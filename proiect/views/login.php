<?php require_once 'header.php';
  if ($_SESSION['isLogged'] == true)  {
    header("Location: myaccount.php");
    exit;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Log In</h1>
    <p>Log into your account or <a href="signup.php">Register</a></p>
    <hr>
    <form class="login-form" action="" method="post">
      <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
      ?>
      <br><br>
      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required value="<?php echo isset($_COOKIE['remember_me_token']) ? $_SESSION['email'] : ''; ?>"><br><br>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required value="<?php echo isset($_COOKIE['remember_me_token']) ? $_SESSION['password'] : ''; ?>"><br><br>

      <label>
        <input type="checkbox" name="remember_me">
        <span class="small-text">Remember me</span>
      </label>

      <p class="small-text">
        <a href="reset-password.php">Forgot Password?</a>
      </p>
          
      <div class="clearfix">
        <button type="submit" class="submitbutton" name="login_button">Login</button>
      </div>
    </form>
  </div>

</body>
</html>
