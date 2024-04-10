<?php
  session_start();
  if ($_SESSION['isLogged']) {
    include 'header2.html'; // Includeți antetul pentru utilizatorii autentificați
  } else {
      include 'header1.html'; // Includeți antetul pentru utilizatorii neautentificați
  }
  ?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="create-form.css">
</head>
<body>
  
</body>
</html>