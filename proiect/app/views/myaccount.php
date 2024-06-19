<?php
if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) {
    header('Location: login');
    exit;
}
require_once 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback On Everything</title>
    <link rel="stylesheet" type="text/css" href="/web/proiect/app/css/myaccount.css">
</head>
<body>
    <div class="form-container">
        <h2>My Account</h2>
        
        <p>
        <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='message'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
            }
        ?>
        </p>

        <div class="profile-picture-container">
            <?php if (isset($_SESSION['profile_picture']) && !empty($_SESSION['profile_picture'])): ?>
                <img src="<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture">
            <?php else: ?>
                <p>No profile picture available.</p>
            <?php endif; ?>
        </div>

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
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            <input type="submit" name="action" value="Update Profile Picture">
        </form>
    </div>
</body>
</html>
