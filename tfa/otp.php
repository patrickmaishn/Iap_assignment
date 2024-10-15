<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';  

class OTPHelper {
    public static function generateOTP() {
        return rand(100000, 999999);  
    }

    public static function sendOTP($email, $otp) {
        $mail = new PHPMailer(true);
        try {
           
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'patricknmaina0@gmail.com';
            $mail->Password = 'vxjj bdbt tlij aoqg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            
            $mail->setFrom('patricknmaina0@gmail.com', 'IAP');
            $mail->addAddress($email);

           
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Your OTP code is: {$otp}";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
