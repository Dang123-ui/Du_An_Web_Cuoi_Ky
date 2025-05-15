<?php

require_once '../model/user.php';

class SignUpController
{
    public function check_Sign_Up($username, $password, $confirmPassword, $email, $phone, $address)
    {
        $fieldErrors = [
            'fullName' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'phone' => '',
            'address' => '',
            'general' => ''
        ];

        if (empty($username)) {
            $fieldErrors['fullName'] = 'Họ và tên là bắt buộc';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fieldErrors['email'] = 'Email không hợp lệ';
        }
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $password)) {
            $fieldErrors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự, bao gồm chữ, số và ký tự đặc biệt';
        }
        if ($password !== $confirmPassword) {
            $fieldErrors['confirmPassword'] = 'Mật khẩu xác nhận không khớp';
        }
        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            $fieldErrors['phone'] = 'Số điện thoại không hợp lệ';
        }
        if (empty($address)) {
            $fieldErrors['address'] = 'Địa chỉ là bắt buộc';
        }

        // Nếu có lỗi
        if (array_filter($fieldErrors)) {
            return [
                'success' => false,
                'fieldErrors' => $fieldErrors
            ];
        }

        try {
            if (empty($fieldErrors['email']) && checkEmailExist($email)) {
                $fieldErrors['email'] = "Email đã tồn tại!";
            }
            if (empty($fieldErrors['phone']) && checkPhoneExists($phone)) {
                $fieldErrors['phone'] = "Số điện thoại đã tồn tại!";
            }
        } catch (Exception $e) {
            $fieldErrors['general'] = "Đã xảy ra lỗi khi kiểm tra thông tin người dùng: " . $e->getMessage();
        }
        if (array_filter($fieldErrors)) {
            return [
                'success' => false,
                'fieldErrors' => $fieldErrors
            ];
        }

        // Không thêm user ở đây, chỉ trả về thành công để gửi OTP
        return [
            'success' => true,
            'message' => 'Hợp lệ, gửi OTP!'
        ];
    }
    public function addUserAfterOtp($fullName, $password, $email, $phone, $address)
    {
        try {
            // Tạo user_id ngẫu nhiên
            $user_id = uniqid('USER_');

            $sql = "INSERT INTO user (user_id, name, email, phone, address, password, role) 
                VALUES (?, ?, ?, ?, ?, ?, 'user')";

            pdo_execute($sql, $user_id, $fullName, $email, $phone, $address, $password);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi thêm người dùng: " . $e->getMessage());
        }
    }
}