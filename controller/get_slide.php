<?php
header('Content-Type: application/json');
require_once '../model/database.php';

if (isset($_GET['id'])) {
    $slide_id = $_GET['id'];

    try {
        // Lấy thông tin slide từ database
        $sql = "SELECT * FROM slide WHERE id_slide = ?";
        $slide = pdo_query_one($sql, $slide_id);

        if ($slide) {
            // Trả về dữ liệu slide dạng JSON
            echo json_encode([
                'status' => 'success',
                'TieuDe' => $slide['TieuDe'],
                'MoTa' => $slide['MoTa'],
                'img_url' => $slide['img_url']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không tìm thấy slide với ID: ' . $slide_id
            ]);
        }
    } catch (PDOException $e) {
        // Log lỗi để debug
        error_log("Database Error: " . $e->getMessage());

        echo json_encode([
            'status' => 'error',
            'message' => 'Lỗi khi truy vấn database'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu ID slide'
    ]);
}
?>