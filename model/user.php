<?php

require_once 'database.php';

// Function thêm user mới
function addUser($name, $email, $sdt, $dia_chi, $NgaySinh, $GioiTinh, $password)
{
    $sql = "INSERT INTO user(name, email, sdt, dia_chi, NgaySinh, GioiTinh, password) 
            VALUES(?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $name, $email, $sdt, $dia_chi, $NgaySinh, $GioiTinh, $password);
}
function addUser_signUp($username, $password, $email, $phone, $address)
{
    if (checkEmailExist($email)) {
        throw new Exception("Email đã tồn tại!");
    }
    if (checkPhoneExists($phone)) {
        throw new Exception("Số điện thoại đã tồn tại!");
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (name, password, email, sdt, dia_chi) VALUES (?, ?, ?, ?, ?)";
    pdo_execute($sql, $username, $hashedPassword, $email, $phone, $address);
    return true;
}
// Function cập nhật thông tin user
function updateUser($user_id, $name, $email, $sdt, $dia_chi, $NgaySinh, $GioiTinh)
{
    $sql = "UPDATE user SET name=?, email=?, phone=?, address=?, birthday=?, gender=? 
            WHERE user_id=?";
    pdo_execute($sql, $name, $email, $sdt, $dia_chi, $NgaySinh, $GioiTinh, $user_id);
}

// Function cập nhật mật khẩu
function updatePassword($user_id, $new_password)
{
    $sql = "UPDATE user SET password=? WHERE user_id=?";
    pdo_execute($sql, $new_password, $user_id);
}

// Function xóa user
function deleteUser($user_id)
{
    $sql = "DELETE FROM user WHERE user_id=?";
    pdo_execute($sql, $user_id);
}

// Function lấy thông tin user theo ID
function getUserById($user_id)
{
    $sql = "SELECT * FROM user WHERE user_id=?";
    return pdo_query_one($sql, $user_id);
}

// Function lấy thông tin user theo email
function getUserByEmail($email)
{
    $sql = "SELECT * FROM user WHERE email=?";
    return pdo_query_one($sql, $email);
}

// Function kiểm tra email đã tồn tại chưa
function checkEmailExist($email)
{
    $sql = "SELECT COUNT(*) FROM user WHERE email=?";
    return pdo_query_value($sql, $email) > 0;
}


// Function lấy danh sách tất cả user
function getAllUsers()
{
    $sql = "SELECT * FROM user";
    return pdo_query($sql);
}

// Function kiểm tra đăng nhập
function CheckLogin($email, $pass)
{
    $DBH = connect();
    $query = "
    SELECT * FROM user
    where email='$email'
    AND password='$pass'
    ";
    $STH = $DBH->query($query);
    $rows_affected = $STH->rowCount();
    if ($rows_affected == 0) {
        return false;
    }
    return true;
}

function checkPhoneExists($phone)
{
    $sql = "SELECT * FROM user WHERE phone = ?";
    $stmt = pdo_query($sql, $phone);
    return !empty($stmt);
}
?>