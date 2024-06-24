<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>View User Profile</title>
    <link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>
    <div class="container">
        <form>
            <h1>User Profile Details</h1>
            <br><br>

            <div class="input-box">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
            </div>

            <div class="input-box">
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>

            <div class="input-box">
                <label for="role">Role:</label><br>
                <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" readonly>
            </div>

            <br><br>

            <?php if (!empty($forms) && is_array($forms)): ?>
                <h2>User's Forms:</h2>

                <?php foreach ($forms as $form): ?>
                    <div class="form-details">

                        <?php if (!empty($form['file_path'])): ?>
                            <div class="input-box">
                                <label for="file"><h3>Form: <?php echo htmlspecialchars($form['title']); ?></h3></label><br><br>
                                <img src="../user-uploads/<?php echo htmlspecialchars($form['file_path']); ?>" alt="Attached Image" style="max-width: 300px;"><br><br>
                                <a href="view-form?id=<?php echo htmlspecialchars($form['form_id']); ?>">View Form Details</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <p>No forms found for this user.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
