<?php require_once 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/signup-login.css">
    <script>
    function submitRegistrationForm(event) {
        event.preventDefault();

        var formData = {
            username: document.querySelector('input[name="username"]').value,
            email: document.querySelector('input[name="email"]').value,
            password: document.querySelector('input[name="password"]').value,
            password_repeat: document.querySelector('input[name="password-repeat"]').value,
        };

        var errorContainer = document.getElementById('error-container');
        errorContainer.innerHTML = ''; // Clear previous errors

        var errors = validateFormData(formData);

        if (errors.length > 0) {
            errors.forEach(error => {
                var errorElement = document.createElement('p');
                errorElement.textContent = error;
                errorContainer.appendChild(errorElement);
            });
            return;
        }

        // Send form data to the server
        fetch('http://localhost/web/proiect/app/register', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/web/proiect/app/myaccount'; 
            } else {
                data.message.forEach(error => {
                    var errorElement = document.createElement('p');
                    errorElement.textContent = error;
                    errorContainer.appendChild(errorElement);
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    }

    function validateFormData(formData) {
        var errors = [];

        if (formData.password.length < 8) {
            errors.push("Password must be at least 8 characters long.");
        }

        if (!/[!@#$%^&*(),.?":{}|<>]/.test(formData.password)) {
            errors.push("Password must contain at least one special character.");
        }

        if (formData.password !== formData.password_repeat) {
            errors.push("Passwords do not match.");
        }

        return errors;
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.signup-form').addEventListener('submit', submitRegistrationForm);
    });
</script>

</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <form class="signup-form" action="register.php" method="post">
            <div id="error-container"></div> <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required><br><br>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required><br><br>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required><br><br>

            <label for="password-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="password-repeat" required><br><br>

            <button type="submit" class="submitbutton">Sign Up</button>
        </form>
    </div>
</body>
</html>
