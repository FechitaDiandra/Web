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
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="aboutus.css">
</head>
<body>
  <div class="container" id ="about-us">
    <h1>Web Tool for Anonymous Feedback</h1>
    <p>Welcome to our web tool for anonymous feedback! Here you can provide feedback on various aspects such as events, people, geographical locations, products, services, artistic artifacts, and much more. The feedback you provide will be expressed through a range of emotions according to the Plutchik model.</p>
    <p>The process is simple:</p>
    <ol>
        <li><strong>Select the thing you want to give feedback on</strong>: You can choose from our diverse list of things we want feedback on.</li>
        <li><strong>Provide the feedback</strong>: Express your emotion towards the selected thing by choosing one of the feedback options based on the Plutchik model.</li>
        <li><strong>Ensure your feedback is anonymous</strong>: You don't need to worry about disclosing your identity. The feedback is completely anonymous.</li>
        <li><strong>Manage your responses</strong>: After providing feedback, you can come back and edit it if necessary. We're here to ensure you accurately express how you feel.</li>
    </ol>
    <p>After the feedback collection period for a particular thing ends, we will generate detailed reports to give you a complete picture of the sentiments expressed regarding that thing. These reports will include relevant statistics for each category of things evaluated according to each recorded emotion. We will also consider multiple criteria such as user group, evaluation period, thing subcategories, and positive/negative features based on the expressed emotion.</p>
    <p>The generated reports will be available in HTML, CSV, and JSON formats to provide you with flexibility in analysis and usage.</p>
    <p>Thank you for choosing to use our web tool for anonymous feedback. We aim to provide you with the best experience and ensure that your voice matters!</p>
  </div>


</body>
</html>
