<?php
session_start();
if ($_SESSION['isLogged']) {
    include 'header2.html';
} else {
    include 'header1.html';
}
?>
<!DOCTYPE html> 
<html> 
    <head> 
        <title>Feedback On Everything</title> 
        <link rel="stylesheet" type="text/css" href="myaccount.css"> 
    </head> 
    <body> 
        <div class="form-container"> 
            <h2>My Account</h2> 
            <form id="update-name" method="POST" action="update-name.php"> 
                <label for="name">Username:</label> 
                <input type="text" id="name" name="name" value="<?php echo $_SESSION['name'] ?? ''; ?>"> 
                <input type="submit" value="Update Username"> </form> <form id="update-email" method="POST" action="change-email.php"> 
                    <label for="email">Email:</label> 
                    <input type="text" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>"> 
                    <input type="submit" value="Change Email"> </form> <form id="change-password" method="POST" action="change-password.php"> 
                        <input type="submit" value="Change Password"> </form> <form id="delete-account" method="POST" action="delete-account.php"> 
                            <input type="submit" value="Delete Account"> 
                        </form> 
                    </div> 
                </body> 
                </html>

