<?php
session_start();
require_once '../model/database.php';
require_once '../model/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra user đã đăng nhập
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../index.php?act=login');
        exit;
    }

    // Lấy dữ liệu từ form
    $user_id = $_SESSION['user_id'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    try {
        // Kiểm tra mật khẩu cũ
        $user = getUserByEmail($_SESSION['user']);
        if (!$user) {
            $_SESSION['error'] = "Người dùng không tồn tại!";
            header('Location: ../index.php?act=profile');
            exit;
        }
        if ($user['password'] !== $oldPassword) {
            $_SESSION['error'] = "Mật khẩu cũ không đúng!";
            header('Location: ../index.php?act=profile');
            exit;
        }

        // Kiểm tra mật khẩu mới và xác nhận mật khẩu
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
            header('Location: ../index.php?act=profile');
            exit;
        }

        // Kiểm tra độ dài mật khẩu mới
        if (strlen($newPassword) < 6) {
            $_SESSION['error'] = "Mật khẩu mới phải có ít nhất 6 ký tự!";
            header('Location: ../index.php?act=profile');
            exit;
        }

        // Cập nhật mật khẩu mới
        updatePassword($user_id, $newPassword);

        $_SESSION['success'] = "Đổi mật khẩu thành công!";
        header('Location: ../index.php?act=profile');
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Có lỗi xảy ra: " . $e->getMessage();
        header('Location: ../index.php?act=profile');
        exit;
    }
} else {
    // Nếu không phải POST request, chuyển về trang profile
    header('Location: ../index.php?act=profile');
    exit;
}
?>