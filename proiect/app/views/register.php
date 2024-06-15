<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="css/signup-login.css">
  <script>
    function submitRegistrationForm(event) {
      event.preventDefault();

      var formData = {
        username: document.querySelector('input[name="username"]').value,
        email: document.querySelector('input[name="email"]').value,
        password: document.querySelector('input[name="password"]').value,
        password_repeat: document.querySelector('input[name="password-repeat"]').value,
        remember_me: document.querySelector('input[name="remember_me"]').checked,
        terms: document.querySelector('input[name="terms"]').checked
      };

      if (formData.password !== formData.password_repeat) {
        alert('Passwords do not match.');
        return; 
      }

      //send the form data to the server
      fetch('http://localhost/web/proiect/app/register', {
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
      document.querySelector('.signup-form').addEventListener('submit', submitRegistrationForm);
    });
  </script>
</head>
<body>

  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>
    <form class="signup-form" action="" method="post">
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
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