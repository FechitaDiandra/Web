<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Feedback On Everything</title>
    <link rel="stylesheet" type="text/css" href="css/myaccount.css">
</head>
<body>
    <div class="form-container">
        <h2>My Account</h2>
        <p>
        <?php if (isset($_SESSION['message'])): ?>
            <p class="session-message"><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        </p>

        <form id="update-username" method="POST" action="update-username">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $_SESSION['username'] ?? ''; ?>">
            <button type="submit" name="action">Update Username</button>
        </form>

        <form id="update-email" method="POST" action="change-email">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>" readonly>
            <button type="submit" name="action">Change Email</button>
        </form>

        <form id="change-password" method="POST" action="change-password">
            <button type="submit" name="action">Change Password</button>
        </form>

        <form id="delete-account" method="POST" action="delete-account">
            <button type="submit" name="action">Delete Account</button>
        </form>

    </div>
</body>
</html>
