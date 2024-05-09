<?php require_once 'header.php';

if ($_SESSION['isLogged'] == false) {
    header("Location: login.php");
    return;
}
?>

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
            <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='message'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
            ?>
            </p>

            <form id="update-username" method="POST" action="myaccount.php?action=updateUsername">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $_SESSION['username'] ?? ''; ?>">
                <input type="submit" name="action" value="Update Username">
            </form>

            <form id="update-email" method="POST" action="myaccount.php?action=changeEmail">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>" readonly>
                <input type="submit" name="action" value="Change Email">
            </form>

            <form id="change-password" method="POST" action="myaccount.php?action=changePassword">
                <input type="submit" name="action" value="Change Password">
            </form>

            <form id="delete-account" method="POST" action="myaccount.php?action=deleteAccount">
                <input type="submit" name="action" value="Delete Account">
            </form>

        </div> 
    </body> 
</html>