<?php require_once 'header.php';
  if ($_SESSION['isLogged'] == false)  {header("Location: login.php");}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forms History</title>
    <link rel="stylesheet" type="text/css" href="css/view-statistics.css">
</head>
<body>
<div class="form-container"> 
  <h1>Form 1</h1> 

  <h2>Age Statistics</h2>
  <p>18-25: 30%<div id="bar18-25" class="bar"></div></p>
  <p>26-35: 40%<div id="bar26-35" class="bar"></div></p>
  <p>36-45: 20%<div id="bar36-45" class="bar"></div></p>
  <p>46+: 10%<div id="bar46+" class="bar"></div></p>


  <h2>Domain Statistics</h2>
  <p>Yes: 60%</p>
  <div id="barYes" class="bar"></div>
  <p>No: 40%</p>
  <div id="barNo" class="bar"></div>

  <h2>Emotion Statistics</h2>
  <p>Joy: 25%</p>
  <div id="barJoy" class="bar"></div>
  <p>Trust: 15%</p>
  <div id="barTrust" class="bar"></div>
  <p>Fear: 10%</p>
  <div id="barFear" class="bar"></div>
  <p>Sadness: 20%</p>
  <div id="barSadness" class="bar"></div>
  <p>Anger: 15%</p>
  <div id="barAnger" class="bar"></div>
  <p>Anticipation: 10%</p>
  <div id="barAnticipation" class="bar"></div>
  <p>Acceptance: 5%</p>
  <div id="barAcceptance" class="bar"></div>
  <p>Disgust: 2%</p>
  <div id="barDisgust" class="bar"></div>
</div>

<script> 
var domainStats = {yes: 60, no: 40}; 
var emotionStats = {joy: 25, trust: 15, fear: 10, sadness: 20, anger: 15, anticipation: 10, acceptance: 5, disgust: 2}; 
var ageStats = {'18-25': 30, '26-35': 40, '36-45': 20, '46+': 10};
document.getElementById('bar18-25').style.width = ageStats['18-25'] + '%';
document.getElementById('bar26-35').style.width = ageStats['26-35'] + '%';
document.getElementById('bar36-45').style.width = ageStats['36-45'] + '%';
document.getElementById('bar46+').style.width = ageStats['46+'] + '%';
document.getElementById('barYes').style.width = domainStats.yes + '%'; 
document.getElementById('barNo').style.width = domainStats.no + '%';
document.getElementById('barJoy').style.width = emotionStats.joy + '%'; 
document.getElementById('barTrust').style.width = emotionStats.trust + '%'; 
document.getElementById('barFear').style.width = emotionStats.fear + '%'; 
document.getElementById('barSadness').style.width = emotionStats.sadness + '%'; 
document.getElementById('barAnger').style.width = emotionStats.anger + '%'; 
document.getElementById('barAnticipation').style.width = emotionStats.anticipation + '%'; 
document.getElementById('barAcceptance').style.width = emotionStats.acceptance + '%'; 
document.getElementById('barDisgust').style.width = emotionStats.disgust + '%'; 
</script>
</body> 
</html>