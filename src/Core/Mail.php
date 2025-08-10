<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{

    public static function send($to, $subject, $htmlContent, $attachments = []): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = SMTP;                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = SMTP_username;               // SMTP username
            $mail->Password   = SMTP_password;                        // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
            $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Recipients
            $mail->setFrom(SMTP_email_from, SERVICE_NAME);
            $mail->addAddress($to);     // Add a recipient

            // Optional: Add CC or BCC
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // Optional: Add attachments
            // foreach ($attachments as $attachment) {
            //     $mail->addAttachment($attachment);         // Add attachments
            // }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $htmlContent;
            $mail->AltBody = strip_tags($htmlContent);           // Plain text version for non-HTML email clients

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log error or display it (in production, don't display errors to users)
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
