<head>
    <link rel="stylesheet" href="assets/css/tourList.css?v=<?php echo time(); ?>">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css?v=<?php echo time(); ?>" />

</head>
<!-- PANEL -->
<div class="panner-bgr">
    <img src="assets/image/sandt/pannel.jpg" alt="banner" />
    <div class="overlay">
        <p>TOUR TRONG NƯỚC</p>
    </div>
</div>

<!-- Form tìm kiếm -->
<div class="search-form-wrapper">
    <div class="search-form">
        <form method="get" name="timkiem">
            <div class="row g-3 align-items-center">
                <!-- Trường tìm kiếm tour -->
                <div class="col-12 col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <img src="assets/image/sandt/search.png" alt="Tìm kiếm" style="width: 20px;" />
                        </span>
                        <input type="text" class="form-control" name="search" placeholder="Tìm tour..."
                            aria-label="Tìm tour" />
                    </div>
                </div>

                <!-- Ngày đi -->
                <div class="col-12 col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control flatpickr-input" name="ngaydi" id="ngaydi"
                            aria-label="Ngày đi" placeholder="Ngày đi" />
                        <span class="input-group-text calendar-icon" style="border: none">
                            <i><img src="assets/image/sandt/calendar.png" alt="" style="width: 25px" /></i>
                        </span>
                    </div>
                </div>

                <!-- Ngày về -->
                <div class="col-12 col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control flatpickr-input" id="ngayve" name="ngayve"
                            aria-label="Ngày về" autocomplete="off" placeholder="Ngày về" />
                        <span class="input-group-text calendar-icon" style="border: none">
                            <i><img src="assets/image/sandt/calendar.png" alt="" style="width: 25px" /></i>
                        </span>
                    </div>
                </div>

                <!-- Loại tour -->
                <div class="col-12 col-md-2">
                    <select class="form-control" name="type" aria-label="Loại tour">
                        <option value="all">Tất cả</option>
                        <option value="tour-trong-nuoc">Trong nước</option>
                        <option value="tour-nuoc-ngoai">Ngoài nước</option>
                    </select>
                </div>

                <!-- Nút tìm kiếm -->
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn w-100"
                        style="background-color: orangered; color: white; font-weight: bold;">
                        Tìm kiếm
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Danh sách tour -->
<div class="innerpage-wrapper" style="padding-top: 30px; background-color: whitesmoke">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-xs-8">
                <div class="filter-list-tour">
                    <div class="filter-text">Sắp xếp :</div>
                    <div class="filter-tour">
                        <a class="filter-div <?php echo (!isset($_GET['sort']) || $_GET['sort'] === 'ngaymotour') ? 'active' : ''; ?>"
                            href="?action=sort&sort=ngaymotour&order=DESC&type=<?php echo isset($_GET['type']) ? $_GET['type'] : 'all'; ?>">
                            [ Ngày gần nhất ] </a>
                        <a class="filter-div <?php echo isset($_GET['sort']) && $_GET['sort'] === 'price' ? 'active' : ''; ?>"
                            href="?action=sort&sort=price&order=ASC&type=<?php echo isset($_GET['type']) ? $_GET['type'] : 'all'; ?>"
                            style="color: black"> [ Giá thấp nhất ] </a>
                        <a class="filter-div <?php echo isset($_GET['sort']) && $_GET['sort'] === 'discount' ? 'active' : ''; ?>"
                            href="?action=sort&sort=discount&order=DESC&type=<?php echo isset($_GET['type']) ? $_GET['type'] : 'all'; ?>"
                            style="color: black"> [ Hấp dẫn nhất ] </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="view-list-tour" style="gap: 10px">
                    <i onclick="return viewTour('grid')" class="active"><img src="assets/image/sandt/grid_.png" alt=""
                            style="width: 40px" /></i>
                    <span> | </span>
                    <i onclick="return viewTour('list')"><img src="assets/image/layout.png" alt=""
                            style="width: 20px" /></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tour-list">
    <div class="container">
        <div class="row">
            <?php if (empty($tours)): ?>
                <div class="col-12">
                    <p>Không có tour nào để hiển thị.</p>
                </div>
            <?php else: ?>
                <?php foreach ($tours as $index => $tour): ?>
                    <?php if ($index == 2): ?>
                        <!-- Quảng cáo chèn vào vị trí thứ 3 -->
                        <div class="col-md-4 col-sm-6 col-xs-12 tour-item">
                            <article id="advertisementTour" class="box box-kiritm box-tour advertisements" style="height: 358px">
                                <div class="advertisement-content" style="height: 100%; text-align: center; width: 100%">
                                    <p>
                                        <a href="https://saigontourist.net/trang/gioi-thieu-ung-dung-di-dong-saigontourist-travel"
                                            target="_blank">
                                            <img alt=""
                                                src="https://saigontourist.net/uploads/images/for-mobile/banner-web-tai-App.jpg"
                                                style="width: 95%" />
                                        </a>
                                    </p>
                                </div>
                            </article>
                        </div>
                    <?php endif; ?>

                    <?php if ($index < 9 && $index != 2): ?>
                        <!-- Tour trong nhóm đầu tiên (ngoại trừ quảng cáo ở index 2) -->
                        <div class="col-md-4 col-sm-6 col-xs-12 tour-item">
                            <div class="card" style="height: 100%">
                                <a href="?action=detail&maTour=<?php echo htmlspecialchars($tour['maTour']); ?>"
                                    class="popup-gallery">
                                    <img width="100%" height="250" alt="<?php echo htmlspecialchars($tour['tenTour']); ?>"
                                        src="assets/image/<?php echo htmlspecialchars($tour['img_url']); ?>" />
                                </a>
                                <div class="box-tour-price">
                                    <p class="text">Giá từ</p>
                                    <p class="price"><?php echo number_format($tour['price'], 0, ',', '.'); ?></p>
                                    <p class="info"><?php echo htmlspecialchars($tour['thoiLuong']); ?></p>
                                </div>
                                <div class="details-kiritm">
                                    <?php if ($tour['discount'] > 0): ?>
                                        <div class="promotion-tour">
                                            <div class="text-promotion-tour"
                                                title="Giảm <?php echo number_format($tour['discount'], 0, ',', '.'); ?>đ/1 khách">
                                                Giảm <?php echo number_format($tour['discount'], 0, ',', '.'); ?>đ/1 khách
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="name-tour-detail">
                                        <a href="?action=detail&maTour=<?php echo htmlspecialchars($tour['maTour']); ?>"
                                            data-id="<?php echo htmlspecialchars($tour['maTour']); ?>"
                                            data-name="<?php echo htmlspecialchars($tour['tenTour']); ?>"
                                            data-price="<?php echo $tour['price']; ?>"
                                            data-category="<?php echo htmlspecialchars($tour['category']); ?>"
                                            data-brand="<?php echo htmlspecialchars($tour['loaiTour']); ?>" data-list="List"
                                            data-position="<?php echo $index + 1; ?>" class="GAproductClick"
                                            title="<?php echo htmlspecialchars($tour['tenTour']); ?>">
                                            <?php echo htmlspecialchars($tour['tenTour']); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer bottom-detail">
                                    <div class="info-tour"><?php echo htmlspecialchars($tour['tuyenDi']); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Kết thúc tour list đầu tiên -->

<!-- Bắt đầu container slider -->
<div class="container-fluid container-slider">
    <div class="slider">
        <?php foreach ($featuredTours as $featuredIndex => $featuredTour): ?>
            <div class="item">
                <div class="card" style="height: 100%">
                    <a href="?action=detail&maTour=<?php echo htmlspecialchars($featuredTour['maTour']); ?>"
                        class="popup-gallery">
                        <img width="100%" heightViệt Nam" height="250"
                            alt="<?php echo htmlspecialchars($featuredTour['tenTour']); ?>"
                            src="assets/image/<?php echo htmlspecialchars($featuredTour['img_url']); ?>">
                    </a>
                    <div class="box-tour-price">
                        <p class="text">Giá từ</p>
                        <p class="price"><?php echo number_format($featuredTour['price'], 0, ',', '.'); ?></p>
                        <p class="info"><?php echo htmlspecialchars($featuredTour['thoiLuong']); ?></p>
                    </div>
                    <div class="details-kiritm">
                        <?php if ($featuredTour['discount'] > 0): ?>
                            <div class="promotion-tour">
                                <div class="text-promotion-tour"
                                    title="Giảm <?php echo number_format($featuredTour['discount'], 0, ',', '.'); ?>đ/1 khách">
                                    Giảm <?php echo number_format($featuredTour['discount'], 0, ',', '.'); ?>đ/1 khách
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="name-tour-detail">
                            <a href="?action=detail&maTour=<?php echo htmlspecialchars($featuredTour['maTour']); ?>"
                                data-url="?action=detail&maTour=<?php echo htmlspecialchars($featuredTour['maTour']); ?>"
                                data-id="<?php echo htmlspecialchars($featuredTour['maTour']); ?>"
                                data-name="<?php echo htmlspecialchars($featuredTour['tenTour']); ?>"
                                data-price="<?php echo $featuredTour['price']; ?>"
                                data-category="<?php echo htmlspecialchars($featuredTour['category']); ?>"
                                data-brand="<?php echo htmlspecialchars($featuredTour['loaiTour']); ?>" data-list="Featured"
                                data-position="<?php echo $featuredIndex + 10; ?>" class="GAproductClick"
                                title="<?php echo htmlspecialchars($featuredTour['tenTour']); ?>">
                                <?php echo htmlspecialchars($featuredTour['tenTour']); ?>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bottom-detail">
                        <div class="info-tour"><?php echo htmlspecialchars($featuredTour['tuyenDi']); ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button id="prev">&lt;</button>
    <button id="next">&gt;</button>
</div>
<!-- Kết thúc slider -->

<!-- Tour list mới cho các tour còn lại (tours[9+]) -->
<?php if (count($tours) > 9): ?>
    <div class="tour-list">
        <div class="container">
            <div class="row">
                <?php foreach ($tours as $index => $tour): ?>
                    <?php if ($index > 8): ?>
                        <div class="col-md-4 col-sm-6 col-xs-12 tour-item">
                            <div class="card" style="height: 100%">
                                <a href="?action=detail&maTour=<?php echo htmlspecialchars($tour['maTour']); ?>"
                                    class="popup-gallery">
                                    <img width="100%" height="250" alt="<?php echo htmlspecialchars($tour['tenTour']); ?>"
                                        src="assets/image/<?php echo htmlspecialchars($tour['img_url']); ?>" </a>
                                    <div class="box-tour-price">
                                        <p class="text">Giá từ</p>
                                        <p class="price"><?php echo number_format($tour['price'], 0, ',', '.'); ?></p>
                                        <p class="info"><?php echo htmlspecialchars($tour['thoiLuong']); ?></p>
                                    </div>
                                    <div class="details-kiritm">
                                        <?php if ($tour['discount'] > 0): ?>
                                            <div class="promotion-tour">
                                                <div class="text-promotion-tour"
                                                    title="Giảm <?php echo number_format($tour['discount'], 0, ',', '.'); ?>đ/1 khách">
                                                    Giảm <?php echo number_format($tour['discount'], 0, ',', '.'); ?>đ/1 khách
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="name-tour-detail">
                                            <a href="?action=detail&maTour=<?php echo htmlspecialchars($tour['maTour']); ?>"
                                                data-id="<?php echo htmlspecialchars($tour['maTour']); ?>"
                                                data-name="<?php echo htmlspecialchars($tour['tenTour']); ?>"
                                                data-price="<?php echo $tour['price']; ?>"
                                                data-category="<?php echo htmlspecialchars($tour['category']); ?>"
                                                data-brand="<?php echo htmlspecialchars($tour['loaiTour']); ?>" data-list="List"
                                                data-position="<?php echo $index + 1; ?>" class="GAproductClick"
                                                title="<?php echo htmlspecialchars($tour['tenTour']); ?>">
                                                <?php echo htmlspecialchars($tour['tenTour']); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-footer bottom-detail">
                                        <div class="info-tour"><?php echo htmlspecialchars($tour['tuyenDi']); ?></div>
                                    </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Phân trang động -->
<div class="row">
    <div class="col-xs-12">
        <div class="paginationCenter">
            <ul class="pagination">
                <?php
                // Lấy tất cả các tham số hiện tại trên URL (GET) để tái sử dụng
                $queryString = $_GET;

                // Nút "Trước" nếu không ở trang đầu
                if ($page > 1) {
                    $queryString['page'] = $page - 1; // Giảm số trang đi 1
                    $prevUrl = '?' . http_build_query($queryString); // Tạo URL mới
                    echo '<li><a href="' . htmlspecialchars($prevUrl) . '" aria-label="Previous">&larr; Trước</a></li>';
                }

                // Vòng lặp tạo các số trang
                for ($i = 1; $i <= $totalPages; $i++) {
                    $queryString['page'] = $i; // Gán số trang hiện tại vào query
                    $pageUrl = '?' . http_build_query($queryString); // Tạo URL
                    $active = ($i == $page) ? 'active' : ''; // Kiểm tra nếu là trang hiện tại
                    echo '<li class="' . $active . '"><a href="' . htmlspecialchars($pageUrl) . '">' . $i . '</a></li>';
                }

                // Nút "Tiếp" nếu chưa ở trang cuối
                if ($page < $totalPages) {
                    $queryString['page'] = $page + 1; // Tăng số trang lên 1
                    $nextUrl = '?' . http_build_query($queryString); // Tạo URL mới
                    echo '<li><a href="' . htmlspecialchars($nextUrl) . '" aria-label="Next">Tiếp &rarr;</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>
</div>

<script src="assets/javascript/gsap.min.js?v=<?php echo time(); ?>"></script>
<script src="assets/javascript/ScrollTrigger.min.js?v=<?php echo time(); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="assets/javascript/tourList.js?v=<?php echo time(); ?>"></script>