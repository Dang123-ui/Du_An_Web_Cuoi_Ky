<!-- filepath: c:\xampp\htdocs\Lap_Trinh_Web\Web_du_lich\view\reset-password.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'model/database.php';

$error = '';
$success = '';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Kiểm tra mật khẩu nhập lại có khớp không
        if ($new_password !== $confirm_password) {
            $error = 'Mật khẩu xác nhận không khớp.';
        } else {
            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET password = ?, otp = NULL WHERE email = ?";
            pdo_execute($sql, $new_password, $email);

            // Xóa session email và otp
            unset($_SESSION['email']);
            unset($_SESSION['otp']);

            $success = 'Mật khẩu của bạn đã được đặt lại thành công.';
            header('Location: index.php?act=login');
            exit;
        }
    }
} else {
    // Nếu không có email trong session, chuyển hướng về trang quên mật khẩu
    header('Location: index.php?act=forgot-password');
    exit;
}
?>

<head>
    <link rel="stylesheet" href="assets/css/login.css?v=<?php echo time(); ?>">
</head>
<div class="container-fluid">
    <main class="bg-login">
        <article class="box-login" style="width: 30%; height: 50%;">
            <h3>Đặt lại mật khẩu</h3>
            <br><br>
            <p>Vui lòng nhập mật khẩu mới của bạn.</p>
            <form action="index.php?act=reset-password" method="post">
                <div class="mb-3">
                    <input type="password" class="form-control" id="new_password" name="new_password"
                        placeholder="Mật khẩu mới" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Xác nhận mật khẩu mới" required>
                </div>
                <div class="form-group">
                    <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    if (!empty($success)) {
                        echo "<div class='alert alert-success'>$success</div>";
                    }
                    ?>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <input type="submit" class="btn btn-primary px-5" value="Đặt lại mật khẩu">
                    <a href="index.php?act=login" class="btn btn-danger px-5" style="color: #fff;">Hủy</a>
                </div>
            </form>
        </article>
    </main>
    <br>
</div>