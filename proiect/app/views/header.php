<?php
  if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] === 'admin') {
    include 'header_admin.html';
  }
  else if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] != 'admin') {
    include 'header_logged.html';
  } else {
      include 'header_not_logged.html';
  }
?>