<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation</title>
    <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>
    <div class="form-container">
        <h1>Thank you for your feedback!</h1>
        <p>Your form has been submitted successfully.</p>
        <p>Redirecting to the home page...</p>
    </div>
    <?php header("refresh:3;url=views/home.php");?>
</body>
</html>
