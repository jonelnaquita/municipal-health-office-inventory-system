<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'db_connect.php';
$response = [];

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

        if ($query) {
            // Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_OFF; // No debugging
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'tiaongmunicipalhealthoffice@gmail.com'; // SMTP username
                $mail->Password = 'kkpsaulplpldihav'; // SMTP password
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('tiaongmunicipalhealthoffice@gmail.com', 'Municipal Health Office');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Reset Password';
                $mail->Body = 'Here is the verification link: <b><a href="http://localhost/pharmacy/change_password.php?reset=' . $code . '">http://localhost/pharmacy/change_password.php?reset=' . $code . '</a></b>';

                $mail->send();

                $_SESSION['success'] = "We've sent a verification link to your email address.";
                $response['success'] = true;
            } catch (Exception $e) {
                $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $response['error'] = $e->getMessage();
            }
        }
    } else {
        $_SESSION['error'] = "This email address cannot be found.";
        $response['error'] = "Email not found.";
    }
}

header('Content-Type: application/json');
echo json_encode($response);

?>
