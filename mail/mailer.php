<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// **Fix the paths**: go up one level, then into PHPMailer/
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/smtp.php';
require __DIR__ . '/../PHPMailer/Exception.php';
function sendEmail($to, $subject, $body, $altBody = '') {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = getenv("MAIL_HOST");
        $mail->SMTPAuth   = true;
        $mail->AuthType   = 'PLAIN';
        $mail->Username   = getenv("MAIL_USERNAME");
        $mail->Password   = getenv("MAIL_PASSWORD");
        $mail->SMTPSecure = 'tls';
        $mail->Port       = getenv("MAIL_PORT");

        $mail->setFrom(getenv("MAIL_FROM_EMAIL"), getenv("MAIL_FROM_NAME"));
        $mail->addAddress($to);
        $mail->addReplyTo(getenv("MAIL_FROM_EMAIL"), getenv("MAIL_FROM_NAME"));

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody ?: strip_tags($body);
        error_log("MAIL_HOST=" . getenv("MAIL_HOST"));
error_log("MAIL_USERNAME=" . getenv("MAIL_USERNAME"));
error_log("MAIL_FROM_EMAIL=" . getenv("MAIL_FROM_EMAIL"));

       error_log("📤 Trying to send to: $to | Subject: $subject | Code: $body");
       $mail->send();
       error_log("✅ Mail sent successfully!");

        return true;
    } catch (Exception $e) {
        error_log("❌ Email failed: " . $mail->ErrorInfo);
        return false;
    }
}