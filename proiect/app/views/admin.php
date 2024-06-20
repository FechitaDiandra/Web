<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>FeedBack On Everything</title>
  <link rel="stylesheet" type="text/css" href="web/proiect/app/css/admin.css">
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
<h1>Import/Export Data</h1>
    <div>
      <input type="file" id="file-input" style="display:none;">
      <button id="import-csv">Import CSV</button>
      <button id="import-json">Import JSON</button>
      <button id="export-csv">Export CSV</button>
      <button id="export-json">Export JSON</button>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      loadTableData();

      const addRowForm = document.getElementById('add-row-form');
      if (addRowForm) {
        addRowForm.addEventListener('submit', function(event) {
          event.preventDefault();
          const formData = new FormData(this);
          fetch('add_row.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            alert(data.message || 'New record created successfully');
            loadTableData();
          })
          .catch(error => console.error('Error:', error));
        });
      }

      const importCsvButton = document.getElementById('import-csv');
      const importJsonButton = document.getElementById('import-json');
      const fileInput = document.getElementById('file-input');
      const exportCsvButton = document.getElementById('export-csv');
      const exportJsonButton = document.getElementById('export-json');

      if (importCsvButton) {
        importCsvButton.addEventListener('click', function() {
          fileInput.setAttribute('data-type', 'csv');
          fileInput.click();
        });
      }

      if (importJsonButton) {
        importJsonButton.addEventListener('click', function() {
          fileInput.setAttribute('data-type', 'json');
          fileInput.click();
        });
      }

      if (fileInput) {
        fileInput.addEventListener('change', function(event) {
          const fileType = this.getAttribute('data-type');
          const file = this.files[0];
          if (file) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', fileType);

            fetch('import_data.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.message) {
                alert(data.message);
              } else if (data.error) {
                alert(data.error);
              }
              loadTableData();
            })
            .catch(error => {
              console.error('Error:', error);
              alert('An error occurred while importing data.');
            });
          }
        });
      }

      if (exportCsvButton) {
        exportCsvButton.addEventListener('click', function() {
          window.location.href = 'export_data.php?type=csv';
        });
      }

      if (exportJsonButton) {
        exportJsonButton.addEventListener('click', function() {
          window.location.href = 'export_data.php?type=json';
        });
      }

      function loadTableData() {
        fetch('get_rows.php')
        .then(response => response.text())
        .then(data => {
          document.querySelector('#usersTable tbody').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
      }

      function saveToDatabase(editableObj, column, id) {
        const newValue = editableObj.innerText;
        fetch('save_edit.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            'id': id,
            'column': column,
            'editval': newValue
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.message) {
            console.log('Save successfully');
          } else if (data.error) {
            console.error('Error:', data.error);
          }
        })
        .catch(error => console.error('Error:', error));
      }

      window.deleteRow = function(id) {
        if (confirm('Are you sure you want to delete this row?')) {
          fetch('delete_row.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
              'id': id
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.message) {
              loadTableData();  // Refresh the rows after deletion
            } else if (data.error) {
              console.error('Error:', data.error);
            }
          })
          .catch(error => console.error('Error:', error));
        }
      }
    });
  </script>

</body>
</html>
