<?php
  session_start();
  if ($_SESSION['isLogged']) {
    include 'header2.html'; // Include header for logged-in users
  } else {
      include 'header1.html'; // Include header for non-logged-in users
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="create.css">
</head>
<body>
<div class="container">
        <h1>New Users</h1>
        <form id="addUserForm">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="role">Role:</label><br>
            <select id="role" name="role">
                <option value="user">User</option>
                <option value="admin">Administrator</option>
                <!-- Add more roles here if needed -->
            </select><br>
            <input type="submit" value="Add User">
        </form>

        <table id="usersTable">
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </table>
    
    <h1>User Reports</h1>
    <div class="container">
        <form id="addUserForm">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="formname">Form Name:</label><br>
            <input type="text" id="formname" name="formname"><br>
            <label for="report">Report:</label><br>
            <textarea id="report" name="report"></textarea><br>
            <input type="submit" value="Add User">
        </form>
    <table id="reportsTable">
        <tr>
            <th>User</th>
            <th>Form</th>
            <th>Report</th>
        </tr>
    </table>
    <button id="loadReportsButton">Load Reports</button>
</div>
<h1>Activity Log</h1>
    <div class="container">
        <table id="activityLogTable">
            <tr>
                <th>Time</th>
                <th>User</th>
                <th>Activity</th>
            </tr>
        </table>
    </div>
    <h1>Notifications</h1>
    <div class="container">
        <div id="notifications">
        </div>
    </div>
    <script>
var users = [
    {username: "User1", role: "Administrator"},
    {username: "User2", role: "User"},
    {username: "User3", role: "User"},
    {username: "User4", role: "Administrator"},
    // add more users here
];

var table = document.getElementById("usersTable");
for (var i = 0; i < users.length; i++) {
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.innerHTML = users[i].username;
    cell2.innerHTML = users[i].role;
    cell3.innerHTML = '<button>Edit</button> <button>Delete</button>'; // Add edit and delete buttons
}
</script>
    <script>
document.getElementById('loadReportsButton').addEventListener('click', function() {
    var reports = [
        {user: "User1", form: "Form1", report: "Report1"},
        {user: "User2", form: "Form2", report: "Report2"},
        {user: "User3", form: "Form3", report: "Report3"},
        {user: "User4", form: "Form4", report: "Report4"},
        {user: "User5", form: "Form5", report: "Report5"},
        {user: "User6", form: "Form6", report: "Report6"},
        {user: "User7", form: "Form7", report: "Report7"},
        {user: "User8", form: "Form8", report: "Report8"},
        // add more reports here
    ];

    var table = document.getElementById("reportsTable");
    for (var i = 0; i < reports.length; i++) {
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        cell1.innerHTML = reports[i].user;
        cell2.innerHTML = reports[i].form;
        cell3.innerHTML = reports[i].report;
    }
});
</script>
<script>
var reports = [
    {user: "User1", form: "Form1", report: "Report1"},
    {user: "User2", form: "Form2", report: "Report2"},
    {user: "User3", form: "Form3", report: "Report3"},
    {user: "User4", form: "Form4", report: "Report4"},
    // add more reports here
];

var table = document.getElementById("reportsTable");
for (var i = 0; i < reports.length; i++) {
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.innerHTML = reports[i].user;
    cell2.innerHTML = reports[i].form;
    cell3.innerHTML = reports[i].report;
}
</script>
<script>
var notifications = [
    "User1 received a feedback response.",
    "User2 received a feedback response.",
    // add more notifications here
];

var notificationsDiv = document.getElementById("notifications");
for (var i = 0; i < notifications.length; i++) {
    var p = document.createElement("p");
    p.innerHTML = notifications[i];
    notificationsDiv.appendChild(p);
}
</script>
</body>
</html>
