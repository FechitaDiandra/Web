<?php 
require_once 'header.php';
if (isset($_GET['token'])) {  $_SESSION['change_email_token'] = $_GET['token']; }
$token = $_SESSION['change_email_token'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>

  <div class="container">
    <h1>Change Email</h1>
    <p>Please enter your new email address.</p>
    <hr>
    <form class="form-container" action="confirm-change-email" method="post">
      <?php if (isset($_SESSION['message'])): ?>
        <p class="session-message"><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
      <br><br>
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
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
