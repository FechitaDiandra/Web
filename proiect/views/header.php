<?php
  if ($_SESSION['isLogged']) {
    include 'header2.html';
  } else {
      include 'header1.html';
  }
?>