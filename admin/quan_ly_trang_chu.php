<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Danh sách sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        td {
            vertical-align: middle;
        }

        img {
            max-height: 100px;
        }
    </style>
</head>

<body>
    <div id="alertMessage" class="alert" style="display: none;"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-10">
                <h3 class="my-4 text-center">Banner List</h3>

                <table class="table-bordered table table-hover text-center">
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    require_once '../model/database.php';
                    $sql = "SELECT * FROM banner";

                    $results = pdo_query($sql);

                    if (isset($results) && count($results) > 0) {
                        foreach ($results as $result) {
                            echo '<tr class="item">';
                            echo '<td class="align-middle">' . $result['id_Banner'] . '</td>';
                            echo '<td class="align-middle"><img src="../assets/image/' . $result['img_url'] . '"></td>';
                            echo '<td class="align-middle">
                                        <button class="btn btn-sm btn-primary edit-btn" 
                                            data-id="' . $result['id_Banner'] . '" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center">No products found</td></tr>';
                    }
                    ?>
                </table>
                <p class="text-right">Total banner: <strong><?= count($results) ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Edit Confirm Modal -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateBannerForm" method="POST" enctype="multipart/form-data"> <!-- Bỏ thuộc tính action -->
                    <div class="modal-body">
                        <input type="hidden" id="banner_id" name="banner_id">
                        <div class="form-group">
                            <label for="banner_image">Chọn ảnh mới</label>
                            <input type="file" class="form-control" id="banner_image" name="banner_image"
                                accept="image/*" required>
                        </div>
                        <div class="preview-image mt-3" style="max-width: 100%;">
                            <img id="image_preview" src="" style="max-width: 100%; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Slide Management Table -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col col-md-10">
                <h3 class="my-4 text-center">Slide List</h3>

                <table class="table-bordered table table-hover text-center">
                    <tr>
                        <th>Id</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM slide";
                    $slides = pdo_query($sql);

                    if (isset($slides) && count($slides) > 0) {
                        foreach ($slides as $slide) {
                            echo '<tr class="item">';
                            echo '<td class="align-middle">' . $slide['id_slide'] . '</td>';
                            echo '<td class="align-middle">' . $slide['TieuDe'] . '</td>';
                            echo '<td class="align-middle">' . $slide['MoTa'] . '</td>';
                            echo '<td class="align-middle"><img src="../assets/image/' . $slide['img_url'] . '" class="slide-img"></td>';
                            echo '<td class="align-middle">
                                    <button class="btn btn-sm btn-primary edit-slide-btn" 
                                        data-id="' . $slide['id_slide'] . '" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editSlideModal">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center">No slides found</td></tr>';
                    }
                    ?>
                </table>
                <p class="text-right">Total slides: <strong><?= isset($slides) ? count($slides) : 0 ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Edit Slide Modal -->
    <div id="editSlideModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateSlideForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="slide_id" name="slide_id">
                        <div class="form-group mb-3">
                            <label for="slide_title">Tiêu đề</label>
                            <input type="text" class="form-control" id="slide_title" name="slide_title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="slide_desc">Mô tả</label>
                            <textarea class="form-control" id="slide_desc" name="slide_desc" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="slide_image">Chọn ảnh mới</label>
                            <input type="file" class="form-control" id="slide_image" name="slide_image" accept="image/*"
                                required>
                        </div>
                        <div class="preview-image mt-3">
                            <img id="slide_preview" src="" style="max-width: 100%; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add CSS for slide images -->
    <style>
        .slide-img {
            max-height: 100px;
            object-fit: cover;
        }
    </style>

    <!-- ...existing scripts... -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/javascript/update_banner.js"></script>
    <script src="../assets/javascript/update_slide.js"></script>


</body>

</html>