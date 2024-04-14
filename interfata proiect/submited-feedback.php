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
    <title>Confirmation</title>
    <link rel="stylesheet" type="text/css" href="form.css">
</head>
<body>
    <div class="form-container">
        <h1>Thank you for your feedback!</h1>
        <p>Your form has been submitted successfully.</p>
        <p>Redirecting to the home page...</p>
    </div>
    <?php header("refresh:3;url=index.php");?>
</body>
</html>
