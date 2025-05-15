<?php
header('Content-Type: application/json');
require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra dữ liệu gửi lên
    if (!isset($_POST['slide_id']) || !isset($_FILES['slide_image'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Thiếu thông tin cần thiết'
        ]);
        exit;
    }

    $slide_id = $_POST['slide_id'];
    $tieuDe = $_POST['slide_title'];
    $moTa = $_POST['slide_desc'];
    $file = $_FILES['slide_image'];

    // Kiểm tra file ảnh
    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Chỉ chấp nhận file ảnh JPG, JPEG, PNG, GIF'
        ]);
        exit;
    }

    try {
        // Upload file mới
        $newFileName = 'slide_' . time() . '.' . $fileType;
        $uploadPath = '../assets/image/' . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Cập nhật database
            $sql = "UPDATE slide SET TieuDe = ?, MoTa = ?, img_url = ? WHERE id_slide = ?";
            $result = pdo_execute($sql, $tieuDe, $moTa, $newFileName, $slide_id);

            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cập nhật slide thành công'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Không thể cập nhật database'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Lỗi khi upload file'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lỗi: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Method không hợp lệ'
    ]);
}
?>