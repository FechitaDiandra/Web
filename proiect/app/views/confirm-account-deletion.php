<?php 
require_once 'header.php';
if (isset($_GET['token'])) {  $_SESSION['delete_account_token'] = $_GET['token']; }
$token = $_SESSION['delete_account_token'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Confirm Account Deletion</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>

  <div class="container">
    <h1>Confirm Account Deletion</h1>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <hr>
    <form class="form-container" action="confirm-account-deletion" method="post">
    <?php if (isset($_SESSION['message'])): ?>
      <p class="session-message"><?php echo $_SESSION['message']; ?></p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <br><br>

    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

    <div class="clearfix">
      <button type="submit" class="submitbutton">Delete My Account</button>
    </div>
  </form>
  </div>

</body>
</html>
