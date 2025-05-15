<?php
function clientGoogle()
{
    // Lấy những giá trị này từ https://console.google.com
    $client_id = '61267516297-gd63ag3a9s1ojq6hihjefu3ato5g5k7u.apps.googleusercontent.com'; // Client ID
    $client_secret = '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'; // Client secret
    $redirect_uri = 'http://localhost:8080/Lap_Trinh_Web/Web_du_lich/model/xulyGoogle.php'; // URL tại Authorised redirect URIs
    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->addScope("email");
    $client->addScope("profile");

    $client->setPrompt("select_account");
    return $client;
}

function checkThongTin($email, $rule = '')
{
    // nếu rỗng thì kiểm tra theo username
    if ($rule == '') {
        $sql = 'SELECT * FROM `user` WHERE `email` = ?';
    } else {
        $sql = 'SELECT * FROM `user` WHERE `user_id` = ?';
    }
    return pdo_query_one($sql, $email);
}
// Thêm người dùng
function insertUser($userId, $username, $email, $password)
{
    $sql = 'INSERT INTO `user`(`user_id`,`name`,`email`,`password`)VALUES(?, ?, ?, ?)';
    pdo_execute($sql, $userId, $username, $email, $password);
}
?>