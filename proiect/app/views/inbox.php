<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Inbox</title>
    <link rel="stylesheet" type="text/css" href="css/inbox.css">
    <script>
        function toggleResponseForm(index) {
            var formId = 'response-form-' + index;
            var form = document.getElementById(formId);
            var messageBody = form.previousElementSibling;

            var isHidden = messageBody.style.display === 'none' || messageBody.style.display === '';
            messageBody.style.display = isHidden ? 'block' : 'none';
            form.style.display = isHidden ? 'block' : 'none';

            var allForms = document.querySelectorAll('.response-form');
            allForms.forEach(function(otherForm) {
                if (otherForm.id !== formId) {
                    otherForm.style.display = 'none';
                    otherForm.previousElementSibling.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body>

    <div class="container">
        <h2>Inbox</h2>

        <?php if (is_array($messages) && array_key_exists('success', $messages) && !$messages['success']): ?>
            <p class="error-message"><?php echo isset($messages['message']) ? htmlspecialchars($messages['message']) : 'Error fetching messages.'; ?></p>
        <?php elseif (empty($messages) || is_string($messages)): ?>
            <p>No messages available.</p>
        <?php else: ?>
            <?php foreach ($messages as $index => $message): ?>
                <?php if (is_array($message) && isset($message['message'])): ?>
                    <div class="message">
                        <div class="message-header">
                            <h3>Error</h3>
                        </div>
                        <div class="message-body">
                            <div class="message-content"><?= htmlspecialchars($message['message']) ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="message">
                        <div class="message-header" onclick="toggleResponseForm(<?= $index ?>)">
                            <h3><?= isset($message['Subject']) ? htmlspecialchars($message['Subject']) : 'No Subject' ?></h3>
                            <div class="message-details">
                                <span>Date: <?= isset($message['Date']) ? htmlspecialchars($message['Date']) : 'Unknown Date' ?></span>
                                <span>Name: <?= isset($message['Name']) ? htmlspecialchars($message['Name']) : 'Unknown Name' ?></span>
                                <span>Email: <?= isset($message['Email']) ? htmlspecialchars($message['Email']) : 'Unknown Email' ?></span>
                            </div>
                        </div>
                        <div class="message-body">
                            <div class="message-content"><?= isset($message['Message']) ? htmlspecialchars($message['Message']) : 'No Message' ?></div>
                        </div>
                        <div id="response-form-<?= $index ?>" class="response-form">
                            <form id="response-form" method="post" action="send-response">
                                <textarea name="response" placeholder="Enter your response"></textarea><br>
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <input type="hidden" name="email" value="<?= isset($message['Email']) ? htmlspecialchars($message['Email']) : '' ?>">
                                <input type="submit" value="Send">
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>
