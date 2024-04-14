<?php
session_start();
if ($_SESSION['isLogged']) {
    include 'header2.html';
} else {
    include 'header1.html';
}

$formId = uniqid();
$formUrl = "http://" . $_SERVER['HTTP_HOST'] . "/answer-form.php?id=" . $formId;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation</title>
    <link rel="stylesheet" type="text/css" href="created-form-confirmation.css">
</head>
<body>
    <div class="form-container">
        <h1>This is a CONFIRMATION. Your form is ready to share!!</h1>
        <p>Here is the link to your form: <a href="<?php echo $formUrl; ?>" id="formLink"><?php echo $formUrl; ?></a></p>
        <button id="new" onclick="copyToClipboard()">Copy Link</button>
    </div>

    <script>
    function copyToClipboard() {
        var copyText = document.getElementById("formLink");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
    }
    </script>
</body>
</html>
