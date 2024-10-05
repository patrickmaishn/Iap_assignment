<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 

class OTPHelper {
    public static function generateOTP() {
        return rand(100000, 999999); 
    }

    public static function sendOTP($email, $otp) {
        session_start();  // Start the session
        $_SESSION['otp'] = $otp;  // Store OTP in session
        
        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'patricknmaina0@gmail.com';
            $mail->Password = 'vxjj bdbt tlij aoqg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Email Settings
            $mail->setFrom('patricknmaina0@gmail.com', 'IAP');
            $mail->addAddress($email);
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Your OTP code is: {$otp}";
    
            // Send email
            $mail->send();
    
            // Redirect to OTP verification page after sending
            header("Location: otp_verification.php?email=" . urlencode($email));
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
}
?>
