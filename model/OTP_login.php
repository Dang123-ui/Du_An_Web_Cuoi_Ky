<?php
include_once 'model/database.php';
require_once 'model/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function checkEmail($email)
{
    $sql = "SELECT * FROM user WHERE email = ?";
    $result = pdo_query($sql, $email);
    if (count($result) > 0) {
        return true; // Email exists
    } else {
        return false; // Email does not exist
    }
}

function sendOtpToEmail($email, $otp)
{
    $mail = new PHPMailer(true);
    $user = "Khách hàng";
    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'azan100an3@gmail.com'; // Email của bạn
        $mail->Password = 'xxqjtgjrztfeprso'; // Mật khẩu email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Cấu hình email
        $mail->setFrom('azan100an3@gmail.com', 'WebDuLich');
        $mail->addAddress($email, $user); // Gửi đến email người dùng
        $mail->isHTML(true);
        $mail->Subject = 'OTP to reset password';
        $mail->Body = "Vui lòng nhập mã OTP để khôi phục mật khẩu. Mã OTP của bạn là: <strong>$otp</strong>";

        $mail->send();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function verifyOtp($email, $otp)
{
    $sql = "SELECT * FROM user WHERE email = ? AND otp = ?";
    $result = pdo_query($sql, $email, $otp);
    if (count($result) > 0) {
        return true; // OTP is valid
    } else {
        return false; // OTP is invalid
    }
}
?>