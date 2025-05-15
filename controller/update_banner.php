<?php
// Thêm error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Đảm bảo không có output nào trước header
header('Content-Type: application/json');

// Log để debug
error_log('POST: ' . print_r($_POST, true));
error_log('FILES: ' . print_r($_FILES, true));
require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banner_id = $_POST['banner_id'];

    if (isset($_FILES['banner_image'])) {
        $file = $_FILES['banner_image'];
        $fileName = $file['name'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Kiểm tra loại file
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Chỉ chấp nhận file ảnh JPG, JPEG, PNG, GIF'
            ]);
            exit;
        }

        // Tạo tên file mới
        $newFileName = 'banner_' . time() . '.' . $fileType;
        $uploadPath = '../assets/image/' . $newFileName;

        try {
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Lấy tên file ảnh cũ
                $sql = "SELECT img_url FROM banner WHERE id_Banner = ?";
                $oldImage = pdo_query_one($sql, $banner_id);

                // Debug
                error_log("Banner ID: " . $banner_id);
                error_log("New filename: " . $newFileName);

                // Cập nhật database
                $sql = "UPDATE banner SET img_url = ? WHERE id_Banner = ?";
                try {
                    $result = pdo_execute($sql, $newFileName, $banner_id);
                    error_log("SQL result: " . var_export($result, true));

                    if ($result) {
                        // Xóa file cũ nếu tồn tại
                        if (
                            $oldImage && !empty($oldImage['img_url']) &&
                            file_exists('../assets/image/' . $oldImage['img_url'])
                        ) {
                            unlink('../assets/image/' . $oldImage['img_url']);
                        }

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Cập nhật banner thành công'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Không thể cập nhật database'
                        ]);
                    }
                } catch (PDOException $e) {
                    error_log("Database Error: " . $e->getMessage());
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Lỗi database: ' . $e->getMessage()
                    ]);
                }
            } else {
                error_log("Upload failed: " . error_get_last()['message']);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Lỗi khi upload file'
                ]);
            }
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Không tìm thấy file upload'
        ]);
    }
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method'
]);
?>