<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
  <script>
    function submitLoginForm(event) {
      event.preventDefault();
     
      var formData = {
        email: document.querySelector('input[name="email"]').value,
        password: document.querySelector('input[name="password"]').value,
        remember_me: document.querySelector('input[name="remember_me"]').checked
      };

      //send the form data to the server
      fetch('http://localhost/web/proiect/app/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = '/web/proiect/app/myaccount'; //redirect to myaccount page
        } else {
          alert(data.message); //display error message
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      document.querySelector('.login-form').addEventListener('submit', submitLoginForm);
    });
  </script>

</head>
<body>

  <div class="container">
    <h1>Log In</h1>
    <p>Log into your account or <a href="register">Register</a></p>
    <hr>
    <form class="login-form" action="" method="post">
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
      <br><br>
      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required value><br><br>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required value><br><br>

      <label>
        <input type="checkbox" name="remember_me">
        <span class="small-text">Remember me</span>
      </label>

      <p class="small-text">
        <a href="forgot-password">Forgot Password?</a>
      </p>
          
      <div class="clearfix">
        <button type="submit" class="submitbutton" name="login_button">Login</button>
      </div>
    </form>
  </div>

</body>
</html>
