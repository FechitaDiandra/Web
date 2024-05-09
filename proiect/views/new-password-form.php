<?php require_once 'header.php';?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Update password</h1>
    <p></p>
    <hr>
    <form class="change-password-form" action="reset-password.php" method="post">
      <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
      ?>
      <br><br>

      <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
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