<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';
include_once('../connection/db.php');

function send_password_mail($get_name, $get_email, $token) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'cf61b70e4ec79f';
        $mail->Password = '49d4fa1555980a';

        // Recipients
        $mail->setFrom('support@brsoftsol.com', 'BRSoftSol');
        $mail->addAddress($get_email, $get_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Notification';
        $mail_template = "
            <h2>Hello, $get_name</h2>
            <h3>You are receiving this email because we received a password reset request for your account.</h3>
            <br><br>
            <a href='http://local.track.com/forgot_password/password_change.php'>Click Me</a>";

        $mail->Body = $mail_template;
        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['submit_reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $email_run = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $email_run_query = mysqli_query($conn, $email_run);

    if (mysqli_num_rows($email_run_query) > 0) {
        $row = mysqli_fetch_array($email_run_query);
        $get_name = $row['name'];
        $get_email = $row['email'];
        

        $update_token = "UPDATE users SET verify_toke_email = '$token' WHERE email = '$get_email' LIMIT 1";
        $update_token_query = mysqli_query($conn, $update_token);

        if ($update_token_query) {
            $_SESSION['reset_email'] = $get_email;
            $_SESSION['reset_token'] = $token;
           
            if (send_password_mail($get_name, $get_email, $token)) {
                $_SESSION['message'] = 'Password reset email sent successfully.';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to send email. Please try again.';
                $_SESSION['message_type'] = 'error';
            }
        } else {
            $_SESSION['message'] = 'Error updating token. Please try again.';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'User does not exist.';
        $_SESSION['message_type'] = 'error';
    }

    header('Location: ../index.php');
    exit();
}
if (isset($_POST['submit_update_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password === $confirm_password) {
        // Verify the token from the database
        $query = "SELECT * FROM users WHERE email = '$email' AND verify_toke_email = '$token' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Hash the new password and update
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $hashed_confirm_password = password_hash($confirm_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password = '$hashed_password', confirm_password = '$hashed_confirm_password', verify_toke_email = '$token' WHERE email = '$email'";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                $_SESSION['message'] = 'Password updated successfully.';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to update password. Please try again.';
                $_SESSION['message_type'] = 'error';
            }
        } else {
            $_SESSION['message'] = 'Invalid token or email.';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Passwords do not match.';
        $_SESSION['message_type'] = 'error';
    }

    header('Location: ../index.php');
    exit();
}

