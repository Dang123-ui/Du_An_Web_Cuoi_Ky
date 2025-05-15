<?php
require_once '../model/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOtp($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'dang0582366729@gmail.com';
        $mail->Password = 'pgbk dmps xvow veao';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('dang0582366729@gmail.com', 'Saigon Tourist');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Mã xác nhận OTP - Saigon Tourist';
        $mail->Body = "
            <h3>Xin chào quý khách,</h3>
            <p>Cảm ơn bạn đã đăng ký tài khoản tại <b>Saigon Tourist</b>.</p>
            <p>Mã OTP của bạn là: <b style='font-size:18px;color:#e74c3c;'>$otp</b></p>
            <p>Mã này có hiệu lực trong 5 phút.</p>
            <br>
            <p>Trân trọng,<br>Đội ngũ Saigon Tourist</p>
        ";
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>