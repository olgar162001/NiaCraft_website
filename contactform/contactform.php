<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Make sure this path points to where Composer installed PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Validate inputs
    if (empty($name) || empty($message) || empty($subject) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill out the form completely and use a valid email address.";
        exit;
    }

    // Set up PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings (adjust to match your email server)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'olgar162001@gmail.com'; // SMTP username
        $mail->Password = 'oryd ktxj teby pdsv';          // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587;

        // Set the recipient email address
        $mail->setFrom($email, $name);
        $mail->addAddress('olgar162001@gmail.com'); // Recipient email

        // Set the email subject
        $mail->Subject = "$subject";

        // Build the email content
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        // Send the email
        $mail->send();
        http_response_code(200);
        echo "OK";

    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message. Error: {$mail->ErrorInfo}";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
