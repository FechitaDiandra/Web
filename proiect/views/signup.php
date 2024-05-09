<?php require_once 'header.php';
  if ($_SESSION['isLogged'] == true)  {header("Location: myaccount.php");}
?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>
    <form class="signup-form" action="" method="post">
      <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
      ?>
      <br><br>

      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required><br><br>

      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required><br><br>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required><br><br>

      <label for="password-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="password-repeat" required><br><br>

      <label>
        <input type="checkbox" name="remember_me"> Remember me
      </label>

      <label>
        <input type="checkbox" name="terms" required>
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