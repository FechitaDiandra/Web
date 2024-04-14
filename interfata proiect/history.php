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
    <title>Forms History</title>
    <link rel="stylesheet" type="text/css" href="history.css">
</head>
<body>
    <div class="form-container">
        <h1>Forms History</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>View statistics</th>
                <th>Download statistics</th>
            </tr>
            <tr>
                <td><a href="answer-form#id1.php">Formular #1</a></td>
                <td><a href="view-statistics.php">View statistics</a></td>
                <td>
                    <a href="download.csv">CSV</a> |
                    <a href="download.html">HTML</a> |
                    <a href="download.json">JSON</a>
                </td>
            </tr>
            <tr>
                <td><a href="answer-form#id2.php">Formular #2</a></td>
                <td><a href="view-statistics.php">View statistics</a></td>
                <td>
                    <a href="download.csv">CSV</a> |
                    <a href="download.html">HTML</a> |
                    <a href="download.json">JSON</a>
                </td>
            </tr>
            <tr>
                <td><a href="answer-form#id3.php">Formular #3</a></td>
                <td><a href="view-statistics.php">View statistics</a></td>
                <td>
                    <a href="download.csv">CSV</a> |
                    <a href="download.html">HTML</a> |
                    <a href="download.json">JSON</a>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
