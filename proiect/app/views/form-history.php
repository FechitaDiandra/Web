<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms History</title>
    <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>
    <div class="container">
    <h1>Forms History</h1>
    <?php if (isset($_SESSION['message'])): ?>
      <p class="session-message"><?php echo $_SESSION['message']; ?></p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <br><br>
        <?php if (isset($forms) && is_array($forms) && !empty($forms)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Collecting Feedback Until</th>
                        <th>Feedback Type</th>
                        <th>Public</th>
                        <th>View Statistics</th>
                        <th>Delete Form</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($forms as $form) : ?>
                        <tr>
                            <td><a href="view-form?id=<?= $form['form_id']; ?>"><?= htmlspecialchars($form['title']); ?></a>
                            </td>
                            <td><?= htmlspecialchars($form['created_at']); ?></td>
                            <td><?= htmlspecialchars($form['answer_time']); ?></td>
                            <td><?= htmlspecialchars($form['feedback_type']); ?></td>
                            <td><?= $form['is_published'] ? 'Yes' : 'No'; ?></td>
                            <td><a href="view-statistics?id=<?= $form['form_id']; ?>">View</a></td>
                            <td><a href="delete-form?id=<?= $form['form_id']; ?>" onclick="return confirm('Are you sure you want to delete this form?')">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No forms found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
