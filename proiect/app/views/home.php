<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Feedback On Everything</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/homepage.css">
</head>
<body>

  <div class="aboutus-container" id="about-us">
    <h1>Web Tool for Anonymous Feedback</h1>
    <p>Welcome to our feedback collection website! Our platform allows you to create custom feedback forms to gather insights from users on a variety of topics. Whether you're seeking opinions on events, products, services, or any other subject, our tool makes it easy to collect feedback anonymously.</p>
    <p><strong>Here’s what you can do:</strong></p>
    <ol>
        <li><strong>Create feedback forms:</strong> Design personalized forms tailored to your needs and set them up for collecting responses.</li>
        <li><strong>Share the form with others:</strong> You can publish your form on our website to gather responses from a variety of users, or keep the link private if you need to target specific groups for feedback.</li>
        <li><strong>Gather feedback:</strong> Users can anonymously provide feedback using feedback options based on the Plutchik model.</li>
        <li><strong>Answer public forms: </strong> As a user, you can also participate in public forms shared by others, contributing your insights anonymously.</li>
        <li><strong>Generate reports and statistics:</strong> Once the feedback collection period ends, we generate detailed reports. These reports provide insights into sentiments expressed regarding the chosen topic. Explore relevant statistics based on each recorded emotion, user groups, evaluation periods, subcategories, and positive/negative features.</li>
    </ol>
    <p>Our platform ensures anonymity throughout the feedback process, and the generated reports provide a comprehensive overview of the sentiments expressed. Reports are available in multiple formats (HTML, CSV, JSON) for your convenience in analysis and presentation.</p>
    <p>Thank you for choosing to use our web tool for anonymous feedback. We aim to provide you with the best experience and ensure that your voice matters!</p>

    <br><br>
    <h2>Latest Forms</h2>
    <?php if (isset($forms) && is_array($forms) && !empty($forms)) : ?>
    <div class="latest-forms-container">
      <?php
      $formCount = 0;
      foreach ($forms as $form) :
          if ($formCount >= 10) {
              break;
          }
          ?>
          <div class="form-entry">
            <h3><a href="answer-form?id=<?php echo htmlspecialchars($form['form_id']); ?>">
            <?php echo htmlspecialchars($form['title']); ?></a></h3>
            <p><?php echo htmlspecialchars($form['description']); ?></p>
            <p class="response-time">Submit your feedback until: <?php echo htmlspecialchars($form['answer_time']); ?></p>
            <?php if (!empty($form['file_path'])): ?>
              <img src="../user-uploads/<?php echo htmlspecialchars($form['file_path']); ?>" alt="Attached Image" style="max-width: 300px;"><br><br>
            <?php endif; ?>
          </div>
          <?php
          $formCount++;
      endforeach;
      ?>
    </div>
    <?php else : ?>
        <p>There are no public forms yet!</p>
    <?php endif; ?>
</div>

</body>
</html>
