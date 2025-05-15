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
    $name = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    try {
        // Kiểm tra email mới có trùng với email của user khác không
        $currentUser = getUserById($user_id);
        if ($currentUser['email'] !== $email) {
            if (checkEmailExist($email)) {
                $_SESSION['error'] = "Email đã tồn tại trong hệ thống!";
                header('Location: ../index.php?act=profile');
                exit;
            }
        }

        // Cập nhật thông tin
        updateUser($user_id, $name, $email, $phone, $address, $dob, $gender);

        // Cập nhật session email nếu email thay đổi
        if ($currentUser['email'] !== $email) {
            $_SESSION['user'] = $email;
        }

        $_SESSION['success'] = "Cập nhật thông tin thành công!";
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