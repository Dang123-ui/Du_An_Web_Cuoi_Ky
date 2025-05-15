<head>
    <link rel="stylesheet" href="assets/css/login.css?v=<?php echo time(); ?>">
</head>
<div class="container-login">

    <main class="bg-login">
        <article class="box-login w-100" style="max-width: 400px; max-height:500px;">
            <h3>Đăng nhập</h3>
            <br><br>
            <div class="row g-3">
                
                <div class="col-12">
                    <form action="index.php?act=login" method="post">
                        <div class=" mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="email"
                                placeholder="Vui lòng nhập email">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="floatingPassword" name="password"
                                placeholder="Mật khẩu">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label for="exampleCheck1">Ghi Nhớ</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3 mb-3">
                            <input name="login-btn" type="submit" class="btn btn-primary w-100" value="Đăng nhập"></input>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a href="index.php?act=forgot-password">Quên mật khẩu</a>
                        </div>
                        <div class="col-12">
                    <div class="d-flex align-items-center mb-3">
                        <hr class="flex-grow-1">
                        <span class="mx-3 text-muted">Hoặc</span>
                        <hr class="flex-grow-1">
                    </div>

                    
   
                    <?php
                    require_once 'login-google/vendor/autoload.php';
                    require_once './model/function.php';
                    $client1 = clientGoogle();
                    $url = $client1->createAuthUrl();
                    ?>
                    <a href="<?php echo $url ?>" class="btn btn-danger btn-login w-100" style="color: #fff;">
                        <i class="bi bi-google"></i>
                        <span><small>Đăng nhập với Google.</small></span>
                    </a>
                </div>
                        <div class="d-flex justify-content-center mt-3">
                            <p>Chưa có tài khoản ? <a href="view\sign_up.php">Đăng ký ngay</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            ?>
        </article>
    </main>
    <br>
</div>