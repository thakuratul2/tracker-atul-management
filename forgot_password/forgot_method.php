<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
include_once ('../connection/db.php');

function send_password_mail($get_name, $get_email, $token)
{
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'cf61b70e4ec79f';                     //SMTP username
    $mail->Password   = '49d4fa1555980a';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('pratapsinghatul111@gmail.com', $get_name);
    $mail->addAddress($get_email);     //Add a recipient
      //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Password Notification';
    $mail_template = 
    ""

    $mail->send();
    echo 'Message has been sent';


}

if(isset($_POST['submit_reset_password']))
{
    $email = $_POST['email'];

    $queryEmail = mysqli_real_escape_string($conn, $email);

    $token = md5(rand());

    $email_run = "SELECT * FROM users WHERE email = '$queryEmail' LIMIT 1";

    $email_run_query = mysqli_query($conn, $email_run);

    if(mysqli_num_rows($email_run_query) > 0)
    {
        $row = mysqli_fetch_array($email_run_query);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_toke_email = '$token' WHERE email = '$get_email' LIMIT 1";

        $update_token_query = mysqli_query($conn, $update_token);

        if($update_token_query)

        {

            send_password_mail($get_email, $get_name, $token);

            echo "Check your email to reset your password";
            header("Location: forgot_password.php");
            exit(0);
        }
        else
        {
            echo "Error: " . $update_token_query->error;
            header("Location: forgot_password.php");
            exit(0);
        }
    }
    else
    {
        echo "Email not found";
        header("Location: forgot_password.php");
        exit(0);
    }
}