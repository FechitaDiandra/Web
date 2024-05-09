<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Confirm Account Deletion</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
</head>
<body>

  <div class="container">
    <h1>Confirm Account Deletion</h1>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <hr>
    <form class="account-deletion-form" action="" method="post">
      <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        if (isset($errorMessage)) {
            echo "<div class='error-message'>" . $errorMessage . "</div>";
        }
      ?>

      <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

      <div class="clearfix">
        <button type="submit" class="submitbutton">Delete My Account</button>
      </div>
    </form>
  </div>

</body>
</html>
