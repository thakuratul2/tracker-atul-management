<?php

include_once ('../connection/db.php');

function send_password_mail($get_name, $get_email, $token)
{

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