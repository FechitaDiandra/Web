<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Change Email</h1>
    <p>Please enter your new email address.</p>
    <hr>
    <form class="change-email-form" action="change-email.php" method="post">
      <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
      ?>
      <br><br>

      <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

      <label for="new-email"><b>New Email</b></label>
      <input type="email" placeholder="Enter email" name="new-email" required><br><br>

      <label for="confirm-new-email"><b>Confirm New Email</b></label>
      <input type="email" placeholder="Confirm email" name="confirm-new-email" required><br><br>

      <div class="clearfix">
        <button type="submit" class="submitbutton">Update Email</button>
      </div>
    </form>
  </div>

</body>
</html>
