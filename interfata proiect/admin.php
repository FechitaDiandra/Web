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
  <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
<div class="container">
        <h1>New Users</h1>
        <form id="addUserForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="user">User</option>
                <option value="admin">Administrator</option>
            </select>
            <input type="submit" value="Add User">
        </form>
        <br><br>

        <table id="usersTable">
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </table>
    
    <h1>User Reports</h1>
    <div class="container">
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
];

var table = document.getElementById("usersTable");
for (var i = 0; i < users.length; i++) {
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    cell1.innerHTML = users[i].username;
    cell2.innerHTML = users[i].role;
    cell3.innerHTML = '<button>Edit</button> <button>Delete</button>';
}
</script>
    <script>
document.getElementById('loadReportsButton').addEventListener('click', function() {
    var reports = [
        {user: "User1", form: "Form1", report: "Report1"},
        {user: "User2", form: "Form2", report: "Report2"},
        {user: "User3", form: "Form3", report: "Report3"},
        {user: "User4", form: "Form4", report: "Report4"},
        {user: "User5", form: "Form5", report: "Report5"}
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
];

var notificationsDiv = document.getElementById("notifications");
for (var i = 0; i < notifications.length; i++) {
    var p = document.createElement("p");
    p.innerHTML = notifications[i];
    notificationsDiv.appendChild(p);
}
</script>
<script>
var users = ["User1", "User2", "User3", "User4", "User5"];

var activities = ["Logged in", "Created an account", "Shared a form", "Complete a form", "Logged out"];

function getRandomIndex(arrayLength) {
    return Math.floor(Math.random() * arrayLength);
}

function getRandomTimestamp() {
    var date = new Date();
    date.setHours(Math.random() * 24);
    date.setMinutes(Math.random() * 60);
    date.setSeconds(Math.random() * 60);
    return date.toTimeString().split(' ')[0];
}

function addActivity() {

    var user = users[getRandomIndex(users.length)];
    var activity = activities[getRandomIndex(activities.length)];
    var time = getRandomTimestamp();

    var table = document.getElementById("activityLogTable");

    var row = table.insertRow(-1);
    var timeCell = row.insertCell(0);
    var userCell = row.insertCell(1);
    var activityCell = row.insertCell(2);

    timeCell.innerHTML = time;
    userCell.innerHTML = user;
    activityCell.innerHTML = activity;
}

setInterval(addActivity, 20000);//adauga la activity log o informatie noua la fiecare 20 sec

</script>
</body>
</html>
