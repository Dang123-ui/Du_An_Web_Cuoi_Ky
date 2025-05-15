<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .tour-img {
            max-height: 100px;
            object-fit: cover;
        }

        .sort-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }

        .sort-btn.active {
            background-color: #0d6efd;
            color: white;
        }

        th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <h2 class="text-center mb-4">Quản lý Tour</h2>

        <!-- Add Tour Button -->
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tourModal">
                <i class="bi bi-plus-circle"></i> Thêm Tour Mới
            </button>
        </div>
        <div class="row mb-3">
            <div class="col-md-2">
                <select class="form-select" id="rowsPerPage">
                    <option value="5">5 hàng</option>
                    <option value="10">10 hàng</option>
                    <option value="25">25 hàng</option>
                    <option value="50">50 hàng</option>
                    <option value="100">100 hàng</option>
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput"
                            placeholder="Tìm theo mã tour hoặc tên tour...">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <span class="float-end">Tổng số tour: <strong id="totalTours">0</strong></span>
            </div>
        </div>
        <!-- Tour List Table -->
        <table class="table table-bordered table-hover" id="tourTable">
            <thead class="table-light">
                <tr>
                    <th>Mã Tour</th>
                    <th>Tên Tour</th>
                    <th>
                        Giá
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm sort-btn" data-sort="price"
                                data-order="asc">
                                <i class="bi bi-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm sort-btn" data-sort="price"
                                data-order="desc">
                                <i class="bi bi-arrow-down"></i>
                            </button>
                        </div>
                    </th>
                    <th>Loại Tour</th>
                    <th>Ảnh</th>
                    <th>Tuyến đi</th>
                    <th>
                        Ngày mở tour
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm sort-btn" data-sort="date"
                                data-order="asc">
                                <i class="bi bi-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm sort-btn" data-sort="date"
                                data-order="desc">
                                <i class="bi bi-arrow-down"></i>
                            </button>
                        </div>
                    </th>
                    <th>Thời lượng</th>
                    <th>Giảm giá</th>
                    <th>Featured</th>
                    <th>
                        Số người tối đa
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm sort-btn" data-sort="people"
                                data-order="asc">
                                <i class="bi bi-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm sort-btn" data-sort="people"
                                data-order="desc">
                                <i class="bi bi-arrow-down"></i>
                            </button>
                        </div>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../model/database.php';
                $sql = "SELECT * FROM tour ORDER BY ngayMoTour DESC";
                $tours = pdo_query($sql);

                foreach ($tours as $tour) {
                    echo '<tr>';
                    echo '<td>' . $tour['maTour'] . '</td>';
                    echo '<td>' . $tour['tenTour'] . '</td>';
                    echo '<td>' . number_format($tour['price']) . 'đ</td>';
                    echo '<td>' . $tour['loaiTour'] . '</td>';
                    echo '<td><img src="../assets/image/' . $tour['img_url'] . '" class="tour-img"></td>';
                    echo '<td>' . $tour['tuyenDi'] . '</td>';
                    echo '<td>' . date('d/m/Y', strtotime($tour['ngayMoTour'])) . '</td>';
                    echo '<td>' . $tour['thoiLuong'] . '</td>';
                    echo '<td>' . number_format($tour['discount']) . 'đ</td>';
                    echo '<td>' . ($tour['isFetured'] ? 'Yes' : 'No') . '</td>';
                    echo '<td>' . $tour['max_people'] . '</td>';
                    echo '<td>
                            <button class="btn btn-sm btn-primary edit-tour" data-id="' . $tour['maTour'] . '" data-bs-toggle="modal" data-bs-target="#tourModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-tour" data-id="' . $tour['maTour'] . '">
                                <i class="bi bi-trash"></i>
                            </button>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination" id="pagination">
                </ul>
            </nav>
        </div>

        <!-- Tour Modal -->
        <div class="modal fade" id="tourModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tour Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="tourForm" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" id="maTour" name="maTour">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tenTour" class="form-label">Tên Tour</label>
                                    <input type="text" class="form-control" id="tenTour" name="tenTour" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Loại Tour</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="tourTrongNuoc"
                                                name="loaiTour" value="tour-trong-nuoc" required>
                                            <label class="form-check-label" for="tourTrongNuoc">Tour trong nước</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="tourNgoaiNuoc"
                                                name="loaiTour" value="tour-ngoai-nuoc" required>
                                            <label class="form-check-label" for="tourNgoaiNuoc">Tour ngoài nước</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="tour_image" class="form-label">Ảnh Tour</label>
                                    <input type="file" class="form-control" id="tour_image" name="tour_image"
                                        accept="image/*">
                                    <div class="mt-2">
                                        <img id="image_preview" src="" style="max-height: 100px; display: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tuyenDi" class="form-label">Tuyến đi</label>
                                <input type="text" class="form-control" id="tuyenDi" name="tuyenDi" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ngayMoTour" class="form-label">Ngày mở tour</label>
                                    <input type="date" class="form-control" id="ngayMoTour" name="ngayMoTour" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="thoiLuong" class="form-label">Thời lượng (ngày - đêm)</label>
                                    <input type="text" class="form-control" id="thoiLuong" name="thoiLuong" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="discount" class="form-label">Giảm giá</label>
                                    <input type="text" class="form-control" id="discount" name="discount" min="0"
                                        value="0">
                                </div>
                                <div class="col-md-4">
                                    <label for="max_people" class="form-label">Số người tối đa</label>
                                    <input type="number" class="form-control" id="max_people" name="max_people" min="1"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label d-block">Featured</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="isFetured" name="isFetured">
                                        <label class="form-check-label" for="isFetured">Hiển thị ở slide</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/javascript/manage_tour.js"></script>
</body>

</html>