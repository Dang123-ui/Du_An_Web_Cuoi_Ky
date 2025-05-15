<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saigontourist</title>
    <link rel="icon" href="assets/image/logo.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="assets/css/trang_chu.css?v=<?php echo time(); ?>">
</head>

<body>

    <div class="container-fluid">
        <header>
            <article>
                <section class="navbar_1">
                    <div class="container">
                        <nav class="d-flex justify-content-between">
                            <div>
                                <a href="#" class="me-3">
                                    <i class="bi bi-envelope"></i>
                                    <span class="ms-2 navbar-text">info@saigontourist.net</span>
                                </a>
                                <a href="#" class="me-3">
                                    <i class="bi bi-telephone"></i>
                                    <span class="ms-2 navbar-text">Hotline: 1900 1808</span>
                                </a>
                            </div>
                            <div>
                                <a href="#" class="ms-3">
                                    <i class="bi bi-geo-alt"></i>
                                    <span class="ms-2 navbar-text">Chọn điểm khởi hành</span>
                                </a>
                                <a href="<?php echo (isset($_SESSION['user_id']) || isset($_SESSION['user'])) ? 'index.php?act=profile' : 'index.php?act=login'; ?>"
                                    class="ms-3">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    <?php $user_info = isset($_SESSION['user_id']) ? checkThongTin($_SESSION['user_id'], 1) : '';
                                    if (!empty($user_info)) {
                                        echo '<span class="ms-2 navbar-text">Xin chào ' . $user_info['name'] . '</span>';
                                    } else if (isset($_SESSION['user'])) {
                                        echo '<span class="ms-2 navbar-text">Xin chào ' . $_SESSION['user'] . '</span>';
                                    } else {
                                        echo '<span class="ms-2 navbar-text">Đăng nhập</span>';
                                    }
                                    ?>
                                </a>
                                <?php if (isset($_SESSION['user-id'])): ?>
                                    <a href="index.php?act=logout" class="ms-3 logout-button">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span class="ms-2 navbar-text">Đăng xuất</span>
                                </a>
                                <?php endif;?>
                                    

                            </div>
                        </nav>
                    </div>
                </section>

                <section>
                    <nav class="navbar navbar-expand-lg">
                        <div class="container">
                            <a class="navbar-brand " href="index.php?act=home"><img src="assets/image/logo.png"
                                    alt=""></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="index.php?act=home">Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle"
                                            href="index.php?act=tour&type=tour-trong-nuoc" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            onclick="location.href=this.href">
                                            Tour trong nước
                                        </a>
                                        <ul class="dropdown-menu">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <h6>Miền Bắc</h6>
                                                    <ul>
                                                        <li style="list-style-type: none;"><a
                                                                href="index.php?act=tour&type=tour-trong-nuoc&search=Hà Nội">Hà
                                                                Nội</a></li>
                                                        <li style="list-style-type: none;"><a
                                                                href="index.php?act=tour&type=tour-trong-nuoc&search=Hạ Long">Hạ
                                                                Long</a></li>
                                                        <li style="list-style-type: none;"><a
                                                                href="index.php?act=tour&type=tour-trong-nuoc&search=Sa pa">Sa
                                                                pa</a></li>
                                                        <li style="list-style-type: none;"><a
                                                                href="index.php?act=tour&type=tour-trong-nuoc&search=Ninh Bình">Ninh
                                                                Bình</a></li>
                                                        <li style="list-style-type: none;"><a
                                                                href="index.php?act=tour&type=tour-trong-nuoc&search=Hải Phòng">Hải
                                                                Phòng</a></li>
                                                        <li style="list-style-type: none;"><a href="">Thanh Hóa</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <h6>Miền Trung</h6>
                                                    <ul>
                                                        <li style="list-style-type: none;"><a href="">Phan Thiết</a>
                                                        </li>
                                                        <li style="list-style-type: none;"><a href="">Nha Trang</a></li>
                                                        <li style="list-style-type: none;"><a href="">Đà Lạt</a></li>
                                                        <li style="list-style-type: none;"><a href="">Tây Nguyên</a>
                                                        </li>
                                                        <li style="list-style-type: none;"><a href="">Tuy Hòa - Quy Nhơn
                                                                - Quảng Ngãi</a></li>
                                                        <li style="list-style-type: none;"><a href="">Huế - Quảng
                                                                Bình</a></li>
                                                        <li style="list-style-type: none;"><a href="">Nghệ An</a></li>
                                                        <li style="list-style-type: none;"><a href="">Đà Nẵng</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <h6>Miền Nam</h6>
                                                    <ul>
                                                        <li style="list-style-type: none;"><a href="">Phú Quốc</a></li>
                                                        <li style="list-style-type: none;"><a href="">Miền Tây</a></li>
                                                        <li style="list-style-type: none;"><a href="">Côn Đảo</a></li>
                                                        <li style="list-style-type: none;"><a href="">Hồ Tràm - Vũng
                                                                Tàu</a></li>
                                                        <li style="list-style-type: none;"><a href="">TP.Hồ Chí Minh</a>
                                                        </li>
                                                        <li style="list-style-type: none;"><a href="">Tây Ninh</a></li>
                                                        <li style="list-style-type: none;"><a href="">Đông Nam Bộ</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle"
                                            href="index.php?act=tour&type=tour-nuoc-ngoai" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            onclick="location.href=this.href">
                                            Tour nước ngoài
                                        </a>
                                        <ul class="dropdown-menu">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <h6>Châu Á</h6>
                                                    <ul>
                                                        <li style="list-style-type: none;"><a href="">Ấn Độ</a></li>
                                                        <li style="list-style-type: none;"><a href="">Buhatan</a></li>
                                                        <li style="list-style-type: none;"><a href="">Trung Quốc</a>
                                                        </li>
                                                        <li style="list-style-type: none;"><a href="">Đài Loan</a></li>
                                                        <li style="list-style-type: none;"><a href="">DuBai</a></li>
                                                        <li style="list-style-type: none;"><a href="">Hàn Quốc</a></li>
                                                        <li style="list-style-type: none;"><a href="">Hồng Kông</a></li>
                                                        <li style="list-style-type: none;"><a href="">Malaysia</a></li>
                                                        <li style="list-style-type: none;"><a href="">Nhật Bản</a></li>
                                                        <li style="list-style-type: none;"><a href="">Singapore</a></li>
                                                        <li style="list-style-type: none;"><a href="">Thái Lan</a></li>
                                                        <li style="list-style-type: none;"><a href="">Các Tiểu Vương
                                                                Quốc Ả Rập</a></li>
                                                        <li style="list-style-type: none;"><a href="">Lào</a></li>
                                                        <li style="list-style-type: none;"><a href="">Indonesia</a></li>
                                                        <li style="list-style-type: none;"><a href="">Trung Đông</a>
                                                        </li>
                                                        <li style="list-style-type: none;"><a href="">Qatar</a></li>
                                                        <li style="list-style-type: none;"><a href="">Philippines</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <h6>Châu Âu</h6>
                                                    <ul>
                                                        <li style="list-style-type: none;"><a href="">Vương Quốc Anh</a>
                                                        </li>
                                                        <li style="list-style-type: none;"><a href="">Châu Âu</a></li>
                                                        <li style="list-style-type: none;"><a href="">Scotland</a></li>
                                                        <li style="list-style-type: none;"><a href="">Thụy Điển</a></li>
                                                        <li style="list-style-type: none;"><a href="">Thổ Nhĩ Kỳ</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <h6>Châu Mỹ - Châu Úc - Châu Phi</h6>
                                                    <ul>
                                                        <li style="list-style-type: none;"><a href="">Úc</a></li>
                                                        <li style="list-style-type: none;"><a href="">Mỹ</a></li>
                                                        <li style="list-style-type: none;"><a href="">Nam Phi</a></li>
                                                        <li style="list-style-type: none;"><a href="">New Zealand</a>
                                                        </li>
                                                        <li style="list-style-type: none;"><a href="">Canada</a></li>
                                                        <li style="list-style-type: none;"><a href="">Nam Mỹ</a></li>
                                                        <li style="list-style-type: none;"><a href="">Ai Cập</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="dich_vu_du_lich.html" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            onclick="location.href=this.href">
                                            Dịch vụ du lịch
                                        </a>
                                        <ul class="dropdown-menu" style="max-width: 300px; padding-left: 30px;">
                                            <li style="list-style-type: none;"><a href="">Thuê xe</a></li>
                                            <li style="list-style-type: none;"><a href="">Vé máy bay</a></li>
                                            <li style="list-style-type: none;"><a href="">Bảo hiểm du lịch</a></li>
                                            <li style="list-style-type: none;"><a href="">Coupon Du lịch</a></li>
                                            <li style="list-style-type: none;"><a href="">Dịch vụ ủy thác Visa Nhật</a>
                                            </li>
                                            <li style="list-style-type: none;"><a href="">Dịch vụ free easy</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./lien_he.html">Liên hệ</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </section>
            </article>