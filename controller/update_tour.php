<?php
header('Content-Type: application/json');
require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $maTour = isset($_POST['maTour']) ? $_POST['maTour'] : null;
        $isNewTour = empty($maTour);

        // Xử lý upload ảnh nếu có
        $newFileName = null;
        if (isset($_FILES['tour_image']) && $_FILES['tour_image']['error'] == 0) {
            $file = $_FILES['tour_image'];
            $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception('Chỉ chấp nhận file ảnh JPG, JPEG, PNG, GIF');
            }

            $newFileName = 'tour_' . time() . '.' . $fileType;
            $uploadPath = '../assets/image/' . $newFileName;

            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                throw new Exception('Không thể upload file');
            }
        }

        // Chuẩn bị dữ liệu
        $data = [
            'tenTour' => $_POST['tenTour'],
            'price' => $_POST['price'],
            'loaiTour' => $_POST['loaiTour'],
            'tuyenDi' => $_POST['tuyenDi'],
            'ngayMoTour' => $_POST['ngayMoTour'],
            'thoiLuong' => $_POST['thoiLuong'],
            'discount' => $_POST['discount'],
            'max_people' => $_POST['max_people'],
            'isFetured' => isset($_POST['isFetured']) ? 1 : 0,
            'description' => $_POST['description']
        ];

        if ($newFileName) {
            $data['img_url'] = $newFileName;
        }

        if ($isNewTour) {
            // Generate new tour ID
            $maTour = get_next_tour_id();
            $data['maTour'] = $maTour;

            // Thêm tour mới
            $columns = implode(', ', array_keys($data));
            $values = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO tour ($columns) VALUES ($values)";
        } else {
            // Cập nhật tour
            $sets = [];
            foreach (array_keys($data) as $key) {
                $sets[] = "$key = ?";
            }
            $sql = "UPDATE tour SET " . implode(', ', $sets) . " WHERE maTour = ?";
            $data['maTour'] = $maTour;
        }

        if (pdo_execute($sql, ...array_values($data))) {
            echo json_encode([
                'status' => 'success',
                'message' => $isNewTour ? 'Thêm tour thành công' : 'Cập nhật tour thành công'
            ]);
        } else {
            throw new Exception('Không thể ' . ($isNewTour ? 'thêm' : 'cập nhật') . ' tour');
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