<?php
header('Content-Type: application/json');
require_once '../model/database.php';

if (isset($_GET['id'])) {
    $tourId = $_GET['id'];

    try {
        $sql = "SELECT * FROM tour WHERE maTour = ?";
        $tour = pdo_query_one($sql, $tourId);

        if ($tour) {
            echo json_encode($tour);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không tìm thấy tour'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lỗi database: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu mã tour'
    ]);
}
?>