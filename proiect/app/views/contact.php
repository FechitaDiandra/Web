<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>

<div class="container">
<h1>Contact Us</h1>
<p>Feel free to reach out to us with any questions or inquiries.</p>
<hr>
    <form class="form-container" action="send-email" method="post">
    <?php if (isset($_SESSION['message'])): ?>
      <p class="session-message"><?php echo $_SESSION['message']; ?></p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <br><br>

    <label for="name"><b>Name</b></label>
    <input type="text" placeholder="Enter Your name" name="name" required><br><br>

    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Your Email" name="email" required><br><br>

    <label for="message"><b>Your Message</b></label>
    <textarea name="message" id="message" rows="5" cols="40" placeholder="Enter your message here..."></textarea>

    <div class="clearfix">
      <button type="submit" class="submitbutton" name="button">Send Message</button>
    </div>
    </form>
  </div>

</body>
</html>
