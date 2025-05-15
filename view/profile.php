<?php
$result = getUserByEmail($_SESSION['user']);
if (isset($_SESSION['user'])) {
    $user = $result['name'];
} else {
    header('Location: index.php?act=login');
    exit;
}
?>

<head>
    <link rel="stylesheet" href="assets/css/profile.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="banner"></div>
    <img src="assets/image/Contact-Us_Hero-Image-1-scaled.jpg" alt="Banner" class="img-fluid"
        style="width: 100%; height: 300px; object-fit: cover;">
    </div>
    <div class="container mt-5">
        <div class="row ">
            <!-- Tab Navigation -->
            <div class="col-12 col-lg-4 border p-3">
                <ul class="nav nav-pills flex-column" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <h4 class="">Tài khoản</h4>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex justify-content-between align-items-center" id="tab1-tab"
                            data-bs-toggle="pill" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                            aria-selected="true">
                            <i class="bi bi-person-circle"></i>
                            <span class="ms-2">Thông tin cá nhân</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex justify-content-between align-items-center" id="tab2-tab"
                            data-bs-toggle="pill" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                            aria-selected="false">
                            <i class="bi bi-bag-check"></i>
                            <span class="ms-2">Tour đã mua</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex justify-content-between align-items-center" id="tab3-tab"
                            data-bs-toggle="pill" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3"
                            aria-selected="false">
                            <i class="bi bi-star"></i>
                            <span class="ms-2">Review trải nghiệm</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex justify-content-between align-items-center" id="tab4-tab"
                            data-bs-toggle="pill" data-bs-target="#tab4" type="button" role="tab" aria-controls="tab3"
                            aria-selected="false">
                            <i class="bi bi-key-fill"></i>
                            <span class="ms-2">Đổi mật khẩu</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="">
                            <button class="nav-link d-flex justify-content-between align-items-center" id="tab3-tab"
                                data-bs-toggle="pill" data-bs-target="#tab3" type="button" role="tab"
                                aria-controls="tab3" aria-selected="false">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="ms-2">Đăng xuất</span>
                            </button>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="col-12 col-lg-8 border p-3">
                <div class="tab-content" id="profileTabsContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <div class="container mt-5">
                            <h4>Thông tin cá nhân</h4>

                            <!-- Thêm vào trước form -->
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger">
                                    <?php
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success">
                                    <?php
                                    echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                                    ?>
                                </div>
                            <?php endif; ?>
                            <form action="controller/update_profile.php" method="post">
                                <!-- Họ tên và Email -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="fullName" class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control" id="fullName" name="fullName"
                                            value="<?php echo isset($result['name']) ? htmlspecialchars($result['name']) : ''; ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo isset($result['email']) ? htmlspecialchars($result['email']) : ''; ?>"
                                            required>
                                    </div>
                                </div>

                                <!-- Số điện thoại và Ngày sinh -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                            value="<?php echo isset($result['phone']) ? htmlspecialchars($result['phone']) : ''; ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dob" class="form-label">Ngày sinh</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                            value="<?php echo isset($result['birthday']) ? htmlspecialchars($result['birthday']) : ''; ?>"
                                            required>
                                    </div>
                                </div>

                                <!-- Giới tính -->
                                <div class="mb-3">
                                    <label class="form-label">Giới tính</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="1"
                                            <?php echo (isset($result['gender']) && $result['gender'] == 1) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="male">Nam</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                                            <?php echo (isset($result['gender']) && $result['gender'] == 2) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="female">Nữ</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="other" value="3"
                                            <?php echo (isset($result['gender']) && $result['gender'] == 3) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="other">Khác</label>
                                    </div>
                                </div>

                                <!-- Địa chỉ -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"
                                        required><?php echo isset($result['address']) ? htmlspecialchars($result['address']) : ''; ?></textarea>
                                </div>

                                <!-- Nút gửi -->
                                <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <h4>Tour đã mua</h4>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Mã giao dịch</th>
                                    <th>Ngày mua</th>
                                    <th>Tên tour</th>
                                    <th>Giá tiền</th>
                                    <th>Xem chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>GD001</td>
                                    <td>2023-10-01</td>
                                    <td>Tour Đà Lạt</td>
                                    <td>5,000,000 VND</td>
                                    <td><a href="#" class="btn btn-primary btn-sm">Chi tiết</a></td>
                                </tr>
                                <tr>
                                    <td>GD002</td>
                                    <td>2023-10-05</td>
                                    <td>Tour Nha Trang</td>
                                    <td>6,500,000 VND</td>
                                    <td><a href="#" class="btn btn-primary btn-sm">Chi tiết</a></td>
                                </tr>
                                <tr>
                                    <td>GD003</td>
                                    <td>2023-10-10</td>
                                    <td>Tour Phú Quốc</td>
                                    <td>7,200,000 VND</td>
                                    <td><a href="#" class="btn btn-primary btn-sm">Chi tiết</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                        <h4>Review trải nghiệm</h4>
                        <form>
                            <div class="mb-3">
                                <label for="transactionId" class="form-label">Mã giao dịch</label>
                                <input type="text" class="form-control" id="transactionId"
                                    placeholder="Nhập mã giao dịch" required>
                            </div>
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Phản hồi của bạn</label>
                                <textarea class="form-control" id="feedback" rows="5"
                                    placeholder="Nhập phản hồi của bạn tại đây..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                        <h4>Đổi mật khẩu</h4>
                        <form action="controller/update_password.php" method="post">
                            <!-- Mật khẩu cũ -->
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">Mật khẩu cũ</label>
                                <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                                    placeholder="Nhập mật khẩu cũ" required>
                            </div>
                            <!-- Mật khẩu mới -->
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    placeholder="Nhập mật khẩu mới" required>
                            </div>
                            <!-- Xác nhận mật khẩu -->
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    placeholder="Nhập lại mật khẩu mới" required>
                            </div>
                            <!-- Nút gửi -->
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>