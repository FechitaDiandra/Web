<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>My Account</title>
  <link rel="stylesheet" type="text/css" href="css/myaccount.css">
</head>
<body>
  <div class="form-container">
    <h2>My Account</h2>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['profile_picture']) && !empty($_SESSION['profile_picture'])): ?>
        <div class="profile-picture-container">
            <img src="<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture">
        </div>
    <?php else: ?>
        <p>No profile picture available.</p>
    <?php endif; ?>

    <form id="update-username" method="POST" action="update-username">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $_SESSION['username'] ?? ''; ?>">
        <input type="submit" name="action" value="Update Username">
    </form>

    <form id="update-email" method="POST" action="change-email">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>" readonly>
        <input type="submit" name="action" value="Change Email">
    </form>

    <form id="change-password" method="POST" action="change-password">
        <input type="submit" name="action" value="Change Password">
    </form>

    <form id="delete-account" method="POST" action="delete-account">
        <input type="submit" name="action" value="Delete Account">
    </form>

    <form id="update-profile-picture" method="POST" action="update-profile-picture" enctype="multipart/form-data">
        <label for="profile_picture">Update Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*" required><br><br>
        <input type="submit" value="Update Profile Picture">
    </form>

  </div>
</body>
</html>
