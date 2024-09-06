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
            <a href='http://local.track.com/forgot_password/password_change.php?email=$get_email&token=$token'>Click Me</a>";

        $mail->Body = $mail_template;
        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['submit_reset_password'])) {
    $email = $_POST['email'];
    $queryEmail = mysqli_real_escape_string($conn, $email);
    $token = md5(rand());

    $email_run = "SELECT * FROM users WHERE email = '$queryEmail' LIMIT 1";
    $email_run_query = mysqli_query($conn, $email_run);

    if (mysqli_num_rows($email_run_query) > 0) {
        $row = mysqli_fetch_array($email_run_query);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_toke_email = '$token' WHERE email = '$get_email' LIMIT 1";
        $update_token_query = mysqli_query($conn, $update_token);

        if ($update_token_query) {
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

    // Redirect to the index page
    header('Location: ../index.php');
    exit();
}
