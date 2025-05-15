<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Chỉ khởi động session nếu chưa được khởi động
}
include_once 'model/OTP_login.php';
include_once 'model/database.php';

$error = '';
$error_otp = '';
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    if (!checkEmail($email)) {
        $error = 'Email không tồn tại trong hệ thống';
    } else {
        if (isset($_SESSION['otp'])) {
            $otp = $_SESSION['otp'];
            if (verifyOtp($email, $otp)) {
                // OTP is valid, proceed to reset password
                header('Location: index.php?act=reset-password');
                exit;
            } else {
                $error_otp = 'Mã OTP không hợp lệ';
            }
        } else {
            $otp = rand(100000, 999999);
            $sql = "UPDATE user SET otp = ? WHERE email = ?";
            pdo_execute($sql, $otp, $email);
            // Send OTP to email
            sendOtpToEmail($email, $otp);
        }
    }
}

?>


<head>
    <link rel="stylesheet" href="assets/css/login.css?v=<?php echo time(); ?>">
</head>
<div class="container-fluid">
    <main class="bg-login">
        <article class="box-login" style="width: 35%; height: 50%;">
            <h3>Quên mật khẩu</h3>
            <br><br>
            <p>Vui lòng nhập email của bạn </p>
            <form action="index.php?act=forgot-password" method="post">
                <?php if (isset($_SESSION['email']) && empty($error)): ?>
                    <div class="mb-3"></div>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo $_SESSION['email']; ?>" readonly>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Nhập mã OTP" required>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn"
                            required>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    if (!empty($error_otp)) {
                        echo "<div class='alert alert-danger'>$error_otp</div>";
                    }
                    ?>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <?php if (isset($_SESSION['otp'])): ?>
                        <input type="submit" class="btn btn-primary px-5" name="send-otp" value="Xác nhận OTP"></input>
                    <?php else: ?>
                        <input type="submit" class="btn btn-primary px-5" name="send-otp" value="Gửi mã OTP"></input>
                        <a href="index.php?act=login" class="btn btn-danger px-5" style="color: #fff;">Hủy</a>
                    <?php endif; ?>
                </div>
            </form>
        </article>
    </main>
    <br>
</div>