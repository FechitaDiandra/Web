<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inițiază sesiunea doar dacă nu este deja activă
}
require_once 'header.php';
require_once 'models/FormModel.php';

if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == false) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    // Dacă `user_id` nu este setat, setează-l manual
    require_once '../models/UserModel.php';
    $userModel = new UserModel();
    $_SESSION['user_id'] = $userModel->getUserIdByEmail($_SESSION['email']);
    if (!isset($_SESSION['user_id'])) {
        die("User ID is not set in the session.");
    }
}

$formModel = new FormModel();
$forms = $formModel->getAllFormsByUserId($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forms History</title>
    <link rel="stylesheet" type="text/css" href="css/form-history.css">
</head>
<body>
    <div class="form-container">
        <h1>Forms History</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>View statistics</th>
                <th>Download statistics</th>
                <th>Delete</th>
            </tr>
            <?php
            if (!empty($forms) && is_array($forms)) {
                foreach ($forms as $form) {
                    echo "<tr>";
                    echo "<td><a href='answer-form.php?id={$form->getFormId()}'>{$form->getTitle()}</a></td>";
                    echo "<td><a href='view-statistics.php?id={$form->getFormId()}'>View statistics</a></td>";
                    echo "<td>
                        <a href='export-feedback.php?form_id={$form->getFormId()}&format=csv'>CSV</a> |
                        <a href='export-feedback.php?form_id={$form->getFormId()}&format=json'>JSON</a>
                    </td>";
                    echo "<td>
                        <form method='post' action='delete-form.php' onsubmit='return confirm(\"Are you sure you want to delete this form?\");'>
                            <input type='hidden' name='form_id' value='{$form->getFormId()}'>
                            <button type='submit' class='delete-button'>Delete</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No forms available.</td></tr>";
            }
            ?>
        </table>
        <div class="import-button">
            <form action="import-feedback.php" method="post" enctype="multipart/form-data">
                <label for="file-upload">Import CSV/JSON:</label>
                <input type="file" name="file-upload" id="file-upload" required>
                <button type="submit" id="import">Import</button>
            </form>
        </div>
    </div>
</body>
</html>
