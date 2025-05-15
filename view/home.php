<article>
    <section>
        <?php
        $sql = "SELECT * FROM slide";
        $slides = pdo_query($sql);
        ?>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                if (isset($slides) && count($slides) > 0) {
                    foreach ($slides as $slide) {
                        echo '<div class="swiper-slide" id="mySwiper-img">';
                        echo '<img src="assets/image/' . $slide['img_url'] . '" />';
                        echo '<div class="slide-content">';
                        echo '<h2>' . $slide['TieuDe'] . '</h2>';
                        echo '<p><small>' . $slide['MoTa'] . '</small></p>';
                        echo '<button class="btn btn-primary">Xem thêm</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No slides available.</p>';
                }
                ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section>
        <form class="search-form d-flex flex-wrap justify-content-between align-items-center">
            <input id="toggle-dates" type="text" class="form-control me-2 mb-2 mb-md-0" placeholder="Tìm kiếm điểm đến"
                aria-label="Search">
            <button class="search-btn" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </section>
</article>
</header>

<main>
    <br>
    <br>
    <h4 style="text-align: center; color:#0087e8;">TOUR MỚI 2025</h4>
    <div class="container">
        <article>
            <div class="swiper mySwiper2">
                <div class="swiper-wrapper">
                    <?php
                    $sql = "SELECT tenTour, price, img_url, discount, thoiLuong, ngayMoTour 
                            FROM tour 
                            ORDER BY ngayMoTour DESC 
                            LIMIT 6";
                    $tours = pdo_query($sql);

                    if (isset($tours) && count($tours) > 0) {
                        foreach ($tours as $tour) {
                            echo '<div class="swiper-slide" id="mySwiper2-img">';
                            echo '<a href="">';
                            echo '<div class="tour-card">';
                            echo '<img src="assets/image/' . $tour['img_url'] . '" alt="Tour Image">';
                            echo '<div class="tour-info">';
                            echo '<div class="discount-banner">Giảm ' . number_format($tour['discount']) . 'đ/1 khách</div>';
                            echo '<div class="price-info">';
                            echo '<span>Giá từ</span>';
                            echo '<h4>' . number_format($tour['price']) . '</h4>';
                            echo '<small>' . $tour['thoiLuong'] . '</small>';
                            echo '</div>';
                            echo '<div class="tour-details">';
                            echo '<div class="d-flex justify-content-between">';
                            echo '<h5>' . $tour['tenTour'] . '</h5>';
                            echo '</div>';
                            echo '</div>';
                            echo '<button class="btn btn-primary">Mua tour</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Không có tour nào.</p>';
                    }
                    ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </article>
    </div>

    <br>
    <br>
    <h4 style="text-align: center; color:#0087e8;">Banner</h4>
    <div class="container">
        <article class="banner-section">
            <?php
            $sql = "SELECT * FROM banner";
            $banners = pdo_query($sql);
            ?>
            <?php if (isset($banners) && count($banners) === 4): ?>
                <section>
                    <a href="">
                        <img src="assets/image/<?php echo $banners[0]['img_url']; ?>" alt="" class="img-fluid">
                    </a>
                    <br><br>
                </section>
                <section>
                    <div class="row">
                        <div class="col-12 col-md-8 align-items-end">
                            <a href="">
                                <img src="assets/image/<?php echo $banners[1]['img_url']; ?>" class="img-fluid" alt="...">
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <a href="">
                                    <img src="assets/image/<?php echo $banners[2]['img_url']; ?>" class="img-fluid"
                                        style="max-height: 200px;" alt="...">
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a href="">
                                    <img src="assets/image/<?php echo $banners[3]['img_url']; ?>" class="img-fluid"
                                        style="max-height: 200px;" alt="...">
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <p>No banners available.</p>
            <?php endif; ?>
        </article>
    </div>

    <article class="bg-img">
        <div class="box-text">
            <h5>Lữ Hành Saigontourist Đẩy Mạnh Hợp Tác Du Lịch Indonesia 2025</h5>
            <p>Vào ngày 9/3, Công ty Dịch vụ Lữ hành Saigontourist (trực thuộc Saigontourist Group) đã ký biên bản ghi
                nhớ cùng Công ty Golden Rama Express - Indonesia trong việc cung cấp đa dạng các sản phẩm cho khách lẻ
                và khách MICE.</p>
            <button class="btn btn-primary">Xem thêm</button>
        </div>

    </article>

    <br><br>
    <h4 style="text-align: center; color:#0087e8;">Điểm đến và trải nghiệm</h4>
    <article>
        <div class="container">
            <?php
            $sql = "SELECT * FROM tour";
            $result_tour = pdo_query($sql);
            ?>
            <div class="row">
                <?php if (isset($result_tour)): ?>
                    <div class="col-12 col-md-4">
                        <div class="card" style="width: 100%;">
                            <a href=""><img src="assets/image/<?php echo $result_tour[0]['img_url']; ?>"
                                    class="card-img-top img-fluid" alt="..."></a>
                            <div class="card-body">

                                <a href="">
                                    <h5 class="card-title"><?php echo $result_tour[0]['tuyenDi']; ?></h5>
                                </a>
                                <p class="card-text"><?php echo $result_tour[0]['description']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <a href=""><img src="assets/image/<?php echo $result_tour[1]['img_url']; ?>" alt=""
                                        class="img-fluid"></a>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="">
                                    <h5><?php echo $result_tour[1]['tuyenDi']; ?></h5>
                                </a><br>
                                <p><?php echo $result_tour[1]['description']; ?></p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <a href=""><img src="assets/image/<?php echo $result_tour[2]['img_url']; ?>" alt=""
                                        class="img-fluid"></a>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="">
                                    <h5><?php echo $result_tour[2]['tuyenDi']; ?></h5>
                                </a><br>
                                <p><?php echo $result_tour[2]['description']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No destinations available.</p>
                <?php endif; ?>
            </div>
        </div>
    </article>
    <br><br>
    <article>
        <div class="container-fluid cham-soc">
            <div class="row">
                <div class="col-6 col-md-4 cham-soc-text">
                    <h5>CHĂM SÓC KHÁCH HÀNG</h5>
                    <h5 style="color: #ffffff;">Chương trình thẻ thành viên Lữ hành Saigontourist</h5>
                    <p>Hội viên chương trình “Hoa Mai Vàng” sẽ nhận được nhiều quyền lợi hấp dẫn tăng dần theo từng hạng
                        thẻ sở hữu và có cơ hội đổi nhiều quà tặng giá trị, tour du lịch trọn gói từ kho quà tặng thuộc
                        chương trình.</p>
                </div>
            </div>
        </div>
    </article>

    <br><br>
    <article>
        <div class="container">
            <div class="row gap-custom">
                <div class="col-12 col-md-5 uy-tin">
                    <img src="view/image/icon/price.png" alt="">
                    <p><b>GIÁ TỐT - NHIỀU ƯU ĐÃI</b><br> Ưu đãi và quà tặng hấp dẫn khi mua tour online</p>
                </div>
                <div class="col-12 col-md-5 uy-tin">
                    <img src="view/image/icon/pay.png" alt="">
                    <p><b>THANH TOÁN AN TOÀN</b><br> Được bảo mật bởi tổ chức quốc tế Global Sign</p>
                </div>
                <div class="col-12 col-md-5 uy-tin">
                    <img src="view/image/icon/promotion.png" alt="">
                    <p><b>TƯ VẤN MIỄN PHÍ</b><br> Hỗ trợ tư vấn online miễn phí</p>
                </div>
                <div class="col-12 col-md-5 uy-tin">
                    <img src="view/image/icon/star.png" alt="">
                    <p><b>THƯƠNG HIỆU UY TÍN</b><br> Thương hiệu lữ hành hàng đầu Việt Nam</p>
                </div>
            </div>
        </div>
    </article>
</main>

<br><br>