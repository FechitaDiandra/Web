<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Statistics</title>
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container">
    <h1>Form Statistics</h1>

    <?php if (isset($statistics) && is_array($statistics) && !empty($statistics)) : ?>
    <div class="export-buttons">
        <a href="export?type=csv&id=<?php echo $form['form_id']; ?>" class="export-button" target="_blank">Export as CSV</a>
        <a href="export?type=json&id=<?php echo $form['form_id']; ?>" class="export-button" target="_blank">Export as JSON</a>
        <a href="export?type=html&id=<?php echo $form['form_id']; ?>" class="export-button" target="_blank">Export as HTML</a>
    </div>

      <div class="statistics-section">
        <h2>Emotion Distribution</h2>
        <canvas id="emotionChart"></canvas>
        <script>
          var ctx = document.getElementById('emotionChart').getContext('2d');
          var emotionChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: [<?php echo implode(', ', array_map(function($emotion) {
                return '"' . htmlspecialchars($emotion['emotion_type']) . '"';
              }, $statistics['emotion_distribution'])); ?>],
              datasets: [{
                label: 'Emotion Distribution',
                data: [<?php echo implode(', ', array_map(function($emotion) {
                  return htmlspecialchars($emotion['count']);
                }, $statistics['emotion_distribution'])); ?>],
                backgroundColor: '#4CAF50'
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>
      </div>

      <div class="statistics-section">
        <h2>Age Distribution</h2>
        <canvas id="ageChart"></canvas>
        <script>
          var ctx = document.getElementById('ageChart').getContext('2d');
          var ageChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: [<?php echo implode(', ', array_map(function($age) {
                return '"Age ' . htmlspecialchars($age['users_age']) . '"';
              }, $statistics['age_distribution'])); ?>],
              datasets: [{
                label: 'Age Distribution',
                data: [<?php echo implode(', ', array_map(function($age) {
                  return htmlspecialchars($age['count']);
                }, $statistics['age_distribution'])); ?>],
                backgroundColor: '#4CAF50'
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>
      </div>

      <div class="statistics-section">
        <h2>Gender Distribution</h2>
        <canvas id="genderChart"></canvas>
        <script>
          var ctx = document.getElementById('genderChart').getContext('2d');
          var genderChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: [<?php echo implode(', ', array_map(function($gender) {
                return '"' . htmlspecialchars($gender['gender']) . '"';
              }, $statistics['gender_distribution'])); ?>],
              datasets: [{
                label: 'Gender Distribution',
                data: [<?php echo implode(', ', array_map(function($gender) {
                  return htmlspecialchars($gender['count']);
                }, $statistics['gender_distribution'])); ?>],
                backgroundColor: '#4CAF50'
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>
      </div>

      <div class="statistics-section">
        <h2>Education Level Distribution</h2>
        <canvas id="educationChart"></canvas>
        <script>
          var ctx = document.getElementById('educationChart').getContext('2d');
          var educationChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: [<?php echo implode(', ', array_map(function($education) {
                return '"' . htmlspecialchars($education['education_level']) . '"';
              }, $statistics['education_distribution'])); ?>],
              datasets: [{
                label: 'Education Level Distribution',
                data: [<?php echo implode(', ', array_map(function($education) {
                  return htmlspecialchars($education['count']);
                }, $statistics['education_distribution'])); ?>],
                backgroundColor: '#4CAF50'
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>
      </div>

      <div class="statistics-section">
        <h2>Experience Distribution</h2>
        <canvas id="experienceChart"></canvas>
        <script>
          var ctx = document.getElementById('experienceChart').getContext('2d');
          var experienceChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: [<?php echo implode(', ', array_map(function($experience) {
                return '"' . htmlspecialchars($experience['experience']) . '"';
              }, $statistics['experience_distribution'])); ?>],
              datasets: [{
                label: 'Experience Distribution',
                data: [<?php echo implode(', ', array_map(function($experience) {
                  return htmlspecialchars($experience['count']);
                }, $statistics['experience_distribution'])); ?>],
                backgroundColor: '#4CAF50'
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>
      </div>

      <div class="statistics-section">
        <h2>Average Age</h2>
        <p>The average age of the users is <?php echo htmlspecialchars($statistics['average_age'] ?? '0'); ?>.</p>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>