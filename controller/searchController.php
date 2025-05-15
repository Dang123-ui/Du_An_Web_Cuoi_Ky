<?php
require_once 'database.php';
require_once '../model/TourModel.php';

class SearchController
{
    private $tourModel;

    public function __construct()
    {
        $this->tourModel = new TourModel();
    }

    public function search()
    {
        $keyword = isset($_POST['search']) ? trim($_POST['search']) : '';
        $ngaydi = isset($_POST['ngaydi']) ? trim($_POST['ngaydi']) : '';
        $ngayve = isset($_POST['ngayve']) ? trim($_POST['ngayve']) : '';
        $loaiTour = isset($_POST['type']) ? $_POST['type'] : 'all';
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        $perPage = 20;
        $sortBy = isset($_POST['sort']) ? $_POST['sort'] : 'ngaymotour';
        $order = isset($_POST['order']) ? $_POST['order'] : 'DESC';

        if (!in_array($loaiTour, ['all', 'tour-trong-nuoc', 'tour-nuoc-ngoai'])) {
            $loaiTour = 'all';
        }

        // Xây dựng câu truy vấn
        $whereClause = $loaiTour === 'all' ? '' : 'WHERE loaiTour = ?';
        $params = $loaiTour === 'all' ? [] : [$loaiTour];

        if (!empty($keyword)) {
            $whereClause .= ($whereClause ? ' AND ' : 'WHERE ') . '(tenTour LIKE ? OR tuyenDi LIKE ? OR category LIKE ?)';
            $keywordParam = "%$keyword%";
            $params[] = $keywordParam;
            $params[] = $keywordParam;
            $params[] = $keywordParam;
        }

        if (!empty($ngaydi)) {
            $whereClause .= ($whereClause ? ' AND ' : 'WHERE ') . 'ngayMoTour >= ?';
            $params[] = $ngaydi;
        }

        if (!empty($ngayve)) {
            $whereClause .= ($whereClause ? ' AND ' : 'WHERE ') . 'ngayMoTour <= ?';
            $params[] = $ngayve;
        }

        // Lấy tổng số tour để phân trang
        $countSql = "SELECT COUNT(*) FROM tour $whereClause";
        $totalTours = empty($params) ? pdo_query_value($countSql) : pdo_query_value($countSql, ...$params);
        pdo_query_value($countSql, ...$params);
        $totalPages = ceil($totalTours / $perPage);
        $page = max(1, min($page, $totalPages));

        // Lấy tour cho trang hiện tại
        $offset = ($page - 1) * $perPage;
        $orderByClause = $this->tourModel->buildOrderByClause($sortBy, $order);
        $sql = "SELECT * FROM tour $whereClause $orderByClause LIMIT $perPage OFFSET $offset";
        $tours = empty($params) ? pdo_query($sql) : pdo_query($sql, ...$params);
        $offset = ($page - 1) * $perPage;
        $orderByClause = $this->tourModel->buildOrderByClause($sortBy, $order);
        $sql = "SELECT * FROM tour $whereClause $orderByClause LIMIT $perPage OFFSET $offset";
        $tours = empty($params) ? pdo_query($sql) : pdo_query($sql, ...$params);
        // Tạo HTML
        ob_start();
        ?>
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

        <!-- Phân trang -->
        <div class="row">
            <div class="col-xs-12">
                <div class="paginationCenter">
                    <ul class="pagination">
                        <?php
                        $queryString = $_POST;
                        if ($page > 1) {
                            $queryString['page'] = $page - 1;
                            echo '<li><a href="javascript:void(0);" onclick="searchTours(' . ($page - 1) . ')" aria-label="Previous">← Trước</a></li>';
                        }

                        for ($i = 1; $i <= $totalPages; $i++) {
                            $queryString['page'] = $i;
                            $active = ($i == $page) ? 'active' : '';
                            echo '<li class="' . $active . '"><a href="javascript:void(0);" onclick="searchTours(' . $i . ')">' . $i . '</a></li>';
                        }

                        if ($page < $totalPages) {
                            $queryString['page'] = $page + 1;
                            echo '<li><a href="javascript:void(0);" onclick="searchTours(' . ($page + 1) . ')" aria-label="Next">Tiếp →</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

$controller = new SearchController();
echo $controller->search();
?>