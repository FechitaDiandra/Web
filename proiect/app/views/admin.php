<?php 
require_once 'header.php';

function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    $decoded_result = json_decode($result, true);

    return $decoded_result['message'];
}


$users = fetchData('http://localhost/web/proiect/services/UserService/users');
$forms = fetchData('http://localhost/web/proiect/services/FormService/forms');
$reportedForms = fetchData('http://localhost/web/proiect/services/FormService/reported-forms');

function fetchUserById($userId) {
    $user = fetchData("http://localhost/web/proiect/services/UserService/user/$userId");
    return $user ?? [];
}

function deleteData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    return $result['message'];
}

function putData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    return $result['message'];
}

foreach ($forms ?? [] as &$form) {
    $userDetails = fetchUserById($form['user_id']);
    $form['user_email'] = $userDetails['email'];
}

foreach ($reportedForms ?? [] as &$form) {
    $userDetails = fetchUserById($form['user_id']);
    $form['user_email'] = $userDetails['email'];
}

if (isset($_GET['deleteUserId'])) {
    $deleteUserId = $_GET['deleteUserId'];
    deleteData("http://localhost/web/proiect/services/UserService/user/$deleteUserId");
    header("Location: admin");
    exit;
}

if (isset($_GET['deleteFormId'])) {
    $deleteFormId = $_GET['deleteFormId'];
    deleteData("http://localhost/web/proiect/services/FormService/form/$deleteFormId");
    header("Location: admin");
    exit;
}

if (isset($_GET['cancelReportId'])) {
    $cancelReportId = $_GET['cancelReportId'];
    putData("http://localhost/web/proiect/services/FormService/cancel-report-form/$cancelReportId");
    header("Location: admin");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script>
        function confirmDeletion(message, url) {
            if (confirm(message)) {
                window.location.href = url;
            }
        }
    </script>
</head>
<body>
<br><br>


    <div class="container">
        <h1>Admin Panel</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <p class="session-message"><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
            <br><br>
        <?php endif; ?>

        <div class="container">
            <form action="export-database" method="get">
                <button type="submit">Export Database</button>
            </form>

        </div><br><br>
        <div class="container">
            <form class="import-form" action="import-database" method="post" enctype="multipart/form-data">
                <label for="sql_file">Import Database:</label>
                <input type="file" name="sql_file" id="sql_file" accept=".sql">
                <button type="submit">Import</button>
            </form>
        </div>

        <br><br>
        <div class="container">
            <h2>Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Delete Account</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users ?? [] as $user): ?>
                    <tr>
                        <td><a href="view-profile?id=<?= $user['user_id'] ?>"><?= $user['username'] ?></a></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td><a href="javascript:void(0)" onclick="confirmDeletion('Are you sure you want to delete this user?', 'admin?deleteUserId=<?= $user['user_id'] ?>')" class="button">Delete Account</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <br><br>
        <div class="container">
            <h2>Forms</h2>
            <table>
                <thead>
                    <tr>
                        <th>User Email</th>
                        <th>Title</th>
                        <th>View Form</th>
                        <th>Statistics</th>
                        <th>Delete Form</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($forms ?? [] as $form): ?>
                    <tr>
                        <td><a href="view-profile?id=<?= $form['user_id'] ?>"><?= $form['user_email'] ?></a></td>
                        <td><?= $form['title'] ?></td>
                        <td><a href="view-form?id=<?= $form['form_id'] ?>" class="button">View Form</a></td>
                        <td><a href="view-statistics?id=<?= $form['form_id'] ?>" class="button">View Statistics</a></td>
                        <td><a href="javascript:void(0)" onclick="confirmDeletion('Are you sure you want to delete this form?', 'admin?deleteFormId=<?= $form['form_id'] ?>')" class="button">Delete Form</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <br><br>
        <div class="container">
            <h2>Reported Forms</h2>
            <table>
                <thead>
                    <tr>
                        <th>User Email</th>
                        <th>Title</th>
                        <th>View Form</th>
                        <th>Cancel Report</th>
                        <th>Delete Form</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportedForms ?? [] as $form): ?>
                    <tr>
                        <td><a href="view-profile?id=<?= $form['user_id'] ?>"><?= $form['user_email'] ?></a></td>
                        <td><?= $form['title'] ?></td>
                        <td><a href="view-form?id=<?= $form['form_id'] ?>" class="button">View Form</a></td>
                        <td><a href="javascript:void(0)" onclick="confirmDeletion('Are you sure you want to cancel the report?', 'admin?cancelReportId=<?= $form['form_id'] ?>')" class="button">Cancel Report</a></td>
                        <td><a href="javascript:void(0)" onclick="confirmDeletion('Are you sure you want to delete this form?', 'admin?deleteFormId=<?= $form['form_id'] ?>')" class="button">Delete Form</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div><br><br>
    </div>
    <br><br>
</body>
</html>
