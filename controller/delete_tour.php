<?php

header('Content-Type: application/json');
require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['maTour'])) {
            throw new Exception('Thiếu mã tour');
        }

        $maTour = $data['maTour'];

        // Lấy thông tin ảnh trước khi xóa
        $sql = "SELECT img_url FROM tour WHERE maTour = ?";
        $tour = pdo_query_one($sql, $maTour);

        // Xóa tour từ database
        $sql = "DELETE FROM tour WHERE maTour = ?";
        if (pdo_execute($sql, $maTour)) {
            // Xóa file ảnh nếu tồn tại
            if ($tour && !empty($tour['img_url'])) {
                $imagePath = '../assets/image/' . $tour['img_url'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Xóa tour thành công'
            ]);
        } else {
            throw new Exception('Không thể xóa tour');
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Method không hợp lệ'
    ]);
}
?>