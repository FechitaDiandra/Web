<?php require_once 'header.php'; ?>
<?php
if ($_SESSION['isLogged'] == false) {
    header("Location: login.php");
    exit;
}

// Simulează obținerea datelor formularului
$forms = [
    ['id' => 1, 'title' => 'Formular #1'],
    ['id' => 2, 'title' => 'Formular #2'],
    ['id' => 3, 'title' => 'Formular #3']
];
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
                    echo "<td><a href='answer-form#id{$form['id']}.php'>{$form['title']}</a></td>";
                    echo "<td><a href='view-statistics.php?id={$form['id']}'>View statistics</a></td>";
                    echo "<td>
                        <a href='download.csv?id={$form['id']}'>CSV</a> |
                        <a href='download.html?id={$form['id']}'>HTML</a> |
                        <a href='download.json?id={$form['id']}'>JSON</a>
                    </td>";
                    echo "<td>
                        <form method='post' action='../delete-form.php' onsubmit='return confirm(\"Are you sure you want to delete this form?\");'>
                            <input type='hidden' name='form_id' value='{$form['id']}'>
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
    </div>
</body>
</html>
