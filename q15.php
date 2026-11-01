<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username = 'your-email@gmail.com';

    $mail->Password = 'YOUR_APP_PASSWORD';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom(
        'your-email@gmail.com',
        'My Website'
    );

    $mail->addAddress('user@example.com');

    $mail->Subject = 'Registration Confirmation';

    $mail->Body = 'Welcome! Your registration was successful.';

    $mail->send();

    echo "Email sent successfully";

} catch(Exception $e) {

    error_log($mail->ErrorInfo);

    echo "Email could not be sent";
}
?>