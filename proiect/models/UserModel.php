<?php

class UserModel {

function create_user($username, $email, $password) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    //protect data against SQL injection
    $username = $mysql->real_escape_string($username);
    $email = $mysql->real_escape_string($email);
    $password = $mysql->real_escape_string($password);

    //check if the email already exists
    $checkEmailQuery = "SELECT email FROM users WHERE email = '$email'";
    $result = $mysql->query($checkEmailQuery);
    if ($result && $result->num_rows > 0) {
        $mysql->close();
        return false;
    }

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (!$mysql->query($query)) {
        die('A survenit o eroare la adăugarea utilizatorului: ' . $mysql->error);
        return false;
    }

    $mysql->close();
    return true;
}



public function invalidate_reset_pasword_token($token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }

    $token = $mysql->real_escape_string($token);
    $query = "UPDATE users SET reset_password_token=NULL, reset_password_token_expires=NULL WHERE reset_password_token='$token'";

    if (!$mysql->query($query)) {
        die('A survenit o eroare la invalidarea tokenului: ' . $mysql->error);
        return false;
    }

    $mysql->close();
    return true;
}


public function invalidate_delete_account_token($token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }

    $token = $mysql->real_escape_string($token);
    $query = "UPDATE users SET delete_account_token=NULL, delete_account_token_expires=NULL WHERE delete_account_token='$token'";

    if (!$mysql->query($query)) {
        die('A survenit o eroare la invalidarea tokenului: ' . $mysql->error);
        return false;
    }

    $mysql->close();
    return true;
}



public function invalidate_change_email_token($token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }

    $token = $mysql->real_escape_string($token);
    $query = "UPDATE users SET change_email_token=NULL, change_email_token_expires=NULL WHERE change_email_token='$token'";

    if (!$mysql->query($query)) {
        die('A survenit o eroare la invalidarea tokenului: ' . $mysql->error);
        return false;
    }

    $mysql->close();
    return true;
}



public function update_password($token, $newPassword) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $token = $mysql->real_escape_string($token);
    $newPassword = $mysql->real_escape_string($newPassword);
    $query = "UPDATE users SET password='$newPassword' WHERE reset_password_token='$token'";
    if (!$mysql->query($query)) {
        die('A survenit o eroare la actualizarea parolei: ' . $mysql->error);
        return false;
    }
    $mysql->close();
    return true;
}



function email_exists($email) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $email = $mysql->real_escape_string($email);
    $query = "SELECT email FROM users WHERE email='$email'";
    $result = $mysql->query($query);
    $exists = $result && $result->num_rows > 0;
    $mysql->close();
    return $exists;
}



function verify_login($email, $password) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $email = $mysql->real_escape_string($email);
    $password = $mysql->real_escape_string($password);
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $mysql->query($query);
    if ($result && $result->num_rows > 0) {
        $mysql->close();
        return true;
    } else {
        $mysql->close();
        return false;
    }
}



function get_email_by_remember_me_token($token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $token = $mysql->real_escape_string($token);
    $query = "SELECT email FROM users WHERE remember_me_token='$token'";
    $result = $mysql->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $mysql->close();
        return $email;
    } else {
        $mysql->close();
        return false;
    }
}



function get_password_by_email($email) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $email = $mysql->real_escape_string($email);

    $query = "SELECT password FROM users WHERE email='$email'";
    $result = $mysql->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row['password'];
        $mysql->close();
        return $password;
    } else {
        $mysql->close();
        return false;
    }
}


function get_username_by_email($email) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $email = $mysql->real_escape_string($email);

    $query = "SELECT username FROM users WHERE email='$email'";
    $result = $mysql->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $mysql->close();
        return $username;
    } else {
        $mysql->close();
        return false;
    }
}


function store_remember_me_token($email, $token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $email = $mysql->real_escape_string($email);
    $query = $token === 'NULL' ? "UPDATE users SET remember_me_token=NULL WHERE email='$email'" : "UPDATE users SET remember_me_token='$token' WHERE email='$email'";
    if (!$mysql->query($query)) {
        die('A survenit o eroare la stocarea tokenului: ' . $mysql->error);
        return false;
    }
    $mysql->close();
    return true;
}


function store_reset_password_token($email, $token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $expires = new DateTime('now');
    $expires->add(new DateInterval('PT1H')); // Adds 1 hour
    $expiresFormatted = $expires->format('Y-m-d H:i:s');
    $email = $mysql->real_escape_string($email);
    $token = $mysql->real_escape_string($token);
    // Update the query to include the expiration time
    $query = "UPDATE users SET reset_password_token='$token', reset_password_token_expires='$expiresFormatted' WHERE email='$email'";
    if (!$mysql->query($query)) {
        die('A survenit o eroare la stocarea tokenului: ' . $mysql->error);
        return false;
    }
    $mysql->close();
    return true;
}


function store_change_email_token($email, $token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }

    $expires = new DateTime('now');
    $expires->add(new DateInterval('PT1H')); // Adds 1 hour
    $expiresFormatted = $expires->format('Y-m-d H:i:s');
    $email = $mysql->real_escape_string($email);
    $token = $mysql->real_escape_string($token);
    // Update the query to include the expiration time
    $query = "UPDATE users SET change_email_token='$token', change_email_token_expires='$expiresFormatted' WHERE email='$email'";

    if (!$mysql->query($query)) {
        die('A survenit o eroare la stocarea tokenului: ' . $mysql->error);
        return false;
    }

    $mysql->close();
    return true;
}


function store_delete_account_token($email, $token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }

    $expires = new DateTime('now');
    $expires->add(new DateInterval('PT1H')); // Adds 1 hour
    $expiresFormatted = $expires->format('Y-m-d H:i:s');
    $email = $mysql->real_escape_string($email);
    $token = $mysql->real_escape_string($token);
    // Update the query to include the expiration time
    $query = "UPDATE users SET delete_account_token='$token', delete_account_token_expires='$expiresFormatted' WHERE email='$email'";

    if (!$mysql->query($query)) {
        die('A survenit o eroare la stocarea tokenului: ' . $mysql->error);
        return false;
    }

    $mysql->close();
    return true;
}


function is_reset_password_token_valid($token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $token = $mysql->real_escape_string($token);
    $query = "SELECT reset_password_token_expires FROM users WHERE reset_password_token='$token'";
    if ($result = $mysql->query($query)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $expires = new DateTime($row['reset_password_token_expires']);
            $now = new DateTime('now');

            if ($now < $expires) {
                // Token is valid
                $result->free();
                $mysql->close();
                return true;
            } else {
                // Token has expired
                $result->free();
                $mysql->close();
                return false;
            }
        } else {
            // Token does not exist
            $result->free();
            $mysql->close();
            return false;
        }
    } else {
        die('A survenit o eroare la verificarea tokenului: ' . $mysql->error);
        return false;
    }
}


function is_delete_account_token_valid($token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $token = $mysql->real_escape_string($token);
    $query = "SELECT delete_account_token_expires FROM users WHERE delete_account_token='$token'";
    if ($result = $mysql->query($query)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $expires = new DateTime($row['delete_account_token_expires']);
            $now = new DateTime('now');

            if ($now < $expires) {
                // Token is valid
                $result->free();
                $mysql->close();
                return true;
            } else {
                // Token has expired
                $result->free();
                $mysql->close();
                return false;
            }
        } else {
            // Token does not exist
            $result->free();
            $mysql->close();
            return false;
        }
    } else {
        die('A survenit o eroare la verificarea tokenului: ' . $mysql->error);
        return false;
    }
}


function is_change_email_token_valid($token) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $token = $mysql->real_escape_string($token);
    $query = "SELECT change_email_token_expires FROM users WHERE change_email_token='$token'";
    if ($result = $mysql->query($query)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $expires = new DateTime($row['change_email_token_expires']);
            $now = new DateTime('now');

            if ($now < $expires) {
                // Token is valid
                $result->free();
                $mysql->close();
                return true;
            } else {
                // Token has expired
                $result->free();
                $mysql->close();
                return false;
            }
        } else {
            // Token does not exist
            $result->free();
            $mysql->close();
            return false;
        }
    } else {
        die('A survenit o eroare la verificarea tokenului: ' . $mysql->error);
        return false;
    }
}


public function update_username_by_email($email, $newUsername) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $email = $mysql->real_escape_string($email);
    $newUsername = $mysql->real_escape_string($newUsername);
    $query = "UPDATE users SET username='$newUsername' WHERE email='$email'";

    if (!$mysql->query($query)) {
        die('A survenit o eroare la actualizarea numelui de utilizator: ' . $mysql->error);
        return false;
    }
    $mysql->close();
    return true;
}


public function update_email_by_token($token, $newEmail) {
    $mysql = new mysqli('localhost', 'root', '', 'foe_app');
    if (mysqli_connect_errno()) {
        die('Conexiunea a eșuat: ' . mysqli_connect_error());
        return false;
    }
    $token = $mysql->real_escape_string($token);
    $newEmail = $mysql->real_escape_string($newEmail);
    $query = "UPDATE users SET email='$newEmail' WHERE change_email_token='$token'";

    if (!$mysql->query($query)) {
        die('A survenit o eroare la actualizarea emailului: ' . $mysql->error);
        return false;
    }
    $mysql->close();
    return true;
}


function send_password_reset_email($email, $token) {
    $resetLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/reset-password.php?token=$token";
    $to = $email;
    $subject = "Password Reset";
    $message = "Here is your password reset link: $resetLink. The link is valid for 1 hour.";
    $headers = "From: contactfeedbackoneverything@gmail.com";

    return mail($to, $subject, $message, $headers);
}


function send_change_email_link($email, $token) {
    $resetLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/change-email.php?token=$token";
    $to = $email;
    $subject = "Change email";
    $message = "Here is your email change link: $resetLink. The link is valid for 1 hour.";
    $headers = "From: contactfeedbackoneverything@gmail.com";

    return mail($to, $subject, $message, $headers);
}


function send_delete_account_link($email, $token) {
    $resetLink = "http://" . $_SERVER['SERVER_NAME'] . "/web/proiect/delete-account.php?token=$token";
    $to = $email;
    $subject = "Delete account";
    $message = "Here is your account deletion link: $resetLink. The link is valid for 1 hour.";
    $headers = "From: contactfeedbackoneverything@gmail.com";

    return mail($to, $subject, $message, $headers);
}


function delete_account_by_token($token) {
        $mysql = new mysqli('localhost', 'root', '', 'foe_app');
        if (mysqli_connect_errno()) {
            die('Conexiunea a eșuat: ' . mysqli_connect_error());
            return false;
        }

        $token = $mysql->real_escape_string($token);
        $query = "DELETE FROM users WHERE delete_account_token='$token'";

        if ($mysql->query($query)) {
            if ($mysql->affected_rows > 0) {
                $mysql->close();
                return true;
            } else {
                $mysql->close();
                return false;
            }
        } else {
            die('Error deleting account: ' . $mysql->error);
            return false;
        }
}


function generate_token() {
    $token = bin2hex(random_bytes(32));
    return $token;
}

}

?>