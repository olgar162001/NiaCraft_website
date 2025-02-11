<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($message) || empty($subject) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill out the form completely and use a valid email address.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'mail.niacraftsolutions.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@niacraftsolutions.com';
        $mail->Password = 'O4g$45XVYC&Z';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 465;

        $mail->setFrom($email, $name);
        $mail->addAddress('info@niacraftsolutions.com', 'Niacraft Solutions');

        $mail->Subject = $subject;
        $mail->isHTML(true);
    
        // Email body with inline styling
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Email from NiaCraft Solutions</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .email-container {
                    background-color: #ffffff;
                    margin: 20px auto;
                    padding: 20px;
                    border-radius: 8px;
                    max-width: 600px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                }
                .header {
                    background-color: #00aa01;
                    color: #ffffff;
                    padding: 10px 20px;
                    border-radius: 8px 8px 0 0;
                    text-align: center;
                    font-size: 20px;
                }
                .content {
                    padding: 20px;
                    line-height: 1.6;
                    color: #333333;
                }
                .content p {
                    margin: 10px 0;
                }
                .footer {
                    margin-top: 20px;
                    text-align: center;
                    font-size: 12px;
                    color: #999999;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header'>Message from NiaCraft Solutions</div>
                <div class='content'>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Message:</strong></p>
                    <p>$message</p>
                </div>
                <div class='footer'>
                    <p>This email was sent from the contact form on NiaCraft Solutions.</p>
                    <p>&copy; 2025 NiaCraft Solutions. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";


        $mail->send();
        http_response_code(200);
        echo "OK";

    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Something went wrong. Error: {$mail->ErrorInfo}";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
