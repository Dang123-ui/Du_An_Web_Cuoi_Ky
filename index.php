<?php
ob_start();
session_start();
include 'config/config.php';
include 'model/user.php';

require_once 'model/database.php';
require_once 'login-google/vendor/autoload.php';
require_once 'model/function.php';
require_once 'model/TourModel.php';
require_once 'controller/tourController.php';

include 'view/header.php';

$act = "home";
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}
switch ($act) {
    case 'home':
        include 'view/home.php';
        break;
    case 'login':
        if (isset($_POST['login-btn'])) {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            if (CheckLogin($email, $pass)) {
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = getUserByEmail($email)['user_id'];
                header('Location: index.php?act=home');
                exit;
            } else if (isset($_SESSION['user_id'])) {
                include 'view/home.php';
            } else {
                $error = 'Tài khoản hoặc mật khẩu không đúng';
                include 'view/login.php';
            }
        }
        include 'view/login.php';
        break;
    case 'forgot-password':
        if (isset($_POST['email'])) {
            $_SESSION['email'] = $_POST['email'];
        }
        if (isset($_POST['otp'])) {
            $_SESSION['otp'] = $_POST['otp'];
        }
        include 'view/forgot-password.php';
        break;
    case 'reset-password':
        include 'view/reset-password.php';
        break;
    case 'logout':
        unset($_SESSION['user_id']);
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php');
        exit;
    case 'profile':
        include 'view/profile.php';
        break;
    case 'contact':
        include 'view/contact.php';
        break;
    case 'about':
        include 'view/about.php';
        break;
    case 'tour':
        $tourController = new TourController();
        $data = $tourController->index();
        extract($data);
        include 'view/tourList.php';
        break;
    default:
        include 'view/home.php';
        break;
}
include 'view/footer.php';

ob_end_flush();
?>