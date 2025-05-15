<?php
ob_start(); // khắc phục lỗi chuyển hướng header
session_start();
// Gọi file Database vào sử dụng
require_once 'database.php';
// Gọi thư viện login Google
require_once '../login-google/vendor/autoload.php';
// Gọi file function
require_once 'function.php';
// client
$client = clientGoogle();
// Tạo ra 1 biến mới để lấy thông tin người dùng
$service = new Google_Service_Oauth2($client);
// Kiểm tra xem có $_GET['code'] không. nếu không thì trở về login còn không thì tiếp tục xử lý
if (isset($_GET['code'])) {
    // Kiểm tra mã code có hợp lệ hay không
    $check = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    // Mã code sẽ phát sinh trong lần request đầu tiên, lần phát sinh sau sẽ lỗi.
    // Và mã code sẽ sinh ra 1 đoạn array có các key là: error (mã lỗi), error_description (Thông báo lỗi)
    if (isset($check['error'])) {
        echo $check['error_description'];
    } else {
        // Thông tin người dùng
        $user = $service->userinfo->get();
        // Lấy thông tin người dùng
        $info = checkThongTin($user->email); // lấy token bằng hàm getAccessToken
        if (!$info) {
            // Nếu không có tài khoản thì thêm 1 tài khoản mới
            $email = $user->email; // var_dump($user) ra xem
            $name = $user->name; // lấy tên người dùng
            $password = $user->id;
            $googleId = $user->id; // lấy id của google
            insertUser($googleId, $name, $email, $password); // thêm người dùng vào nè
            // SET SESSION['id'] và trở về trang chủ
            $_SESSION['user_id'] = $info['user_id'];
            $_SESSION['user'] = $name;

        } else {
            // Nếu đã có tài khoản thì set SESSION['id'] và trở về lại trang chủ
            $_SESSION['user_id'] = $info['user_id'];
            $_SESSION['user'] = $info['name'];
        }
        header('location: ../index.php');
    }
} else {
    header('location: ../index.php');
}
?>