<?php
session_start();
include '../controller/signUpController.php';
include '../controller/OTP_signup.php';
$controller = new SignUpController();
$errors = [];
$success = '';
$showOtpForm = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['exit_otp'])) {
    unset($_SESSION['otp'], $_SESSION['otp_email'], $_SESSION['otp_expiry'], $_SESSION['pending_user']);
    $showOtpForm = false;
  } elseif (isset($_POST['cancel'])) {
    $errors = [];
    $_POST = [];
  } elseif (isset($_POST['register'])) {
    $result = $controller->check_Sign_Up(
      $_POST['fullName'] ?? '',
      $_POST['password'] ?? '',
      $_POST['confirmPassword'] ?? '',
      $_POST['email'] ?? '',
      $_POST['phone'] ?? '',
      $_POST['address'] ?? ''
    );
    if ($result['success']) {
      $_SESSION['pending_user'] = [
        'fullName' => $_POST['fullName'],
        'password' => $_POST['password'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address']
      ];
      $otp = rand(1000, 9999);
      $_SESSION['otp'] = $otp;
      $_SESSION['otp_email'] = $_POST['email'];
      $_SESSION['otp_expiry'] = time() + 300;

      // Gửi OTP qua email
      if (sendOtp($_POST['email'], $otp)) {
        $showOtpForm = true;
      } else {
        $errors['email'] = 'Không thể gửi OTP. Vui lòng thử lại!';
      }
    } else {
      $errors = $result['fieldErrors'];
    }
  } elseif (isset($_POST['verify_otp'])) {
    $otp = ($_POST['otp1'] ?? '') . ($_POST['otp2'] ?? '') . ($_POST['otp3'] ?? '') . ($_POST['otp4'] ?? '');
    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry'])) {
      $errors['otp'] = 'OTP không tồn tại hoặc đã hết hạn!';
      $showOtpForm = true;
    } elseif (time() > $_SESSION['otp_expiry']) {
      $errors['otp'] = 'OTP đã hết hạn!';
      $showOtpForm = true;
    } elseif ($otp == $_SESSION['otp']) {
      $pending = $_SESSION['pending_user'];
      try {
        $controller->addUserAfterOtp(
          $pending['fullName'],
          $pending['password'],
          $pending['email'],
          $pending['phone'],
          $pending['address']
        );
        $success = "Đăng ký thành công!";
      } catch (Exception $e) {
        $errors['general'] = $e->getMessage();
        $showOtpForm = true;
      }
      unset($_SESSION['otp'], $_SESSION['otp_email'], $_SESSION['otp_expiry'], $_SESSION['pending_user']);
    } else {
      $errors['otp'] = "Mã OTP không đúng!";
      $showOtpForm = true;
    }
  } elseif (isset($_POST['resend_otp']) && isset($_SESSION['otp_email'])) {
    $otp = rand(1000, 9999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 300;
    if (sendOtp($_SESSION['otp_email'], $otp)) {
      $showOtpForm = true;
    } else {
      $errors['email'] = 'Không thể gửi OTP. Vui lòng thử lại!';
    }
  }
} elseif (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry']) && time() <= $_SESSION['otp_expiry']) {
  $showOtpForm = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../assets/css/signUp.css?v=<?php echo time(); ?>">
  <title>Đăng ký</title>
</head>

<body>
  <div class="video-background">
    <video autoplay loop muted playsinline id="bg-video">
      <source src="../assets/image/sandt/bgr-signup.mp4" type="video/mp4" />
      Trình duyệt của bạn không hỗ trợ video HTML5.
    </video>
  </div>
  <div id="messageBox"
    style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
    <div
      style="background:#fff;padding:30px 40px;border-radius:8px;box-shadow:0 2px 10px #0003;min-width:300px;max-width:90vw;text-align:center;">
      <div id="messageContent" style="color:#dc3545;font-size:18px;"></div>
      <button onclick="document.getElementById('messageBox').style.display='none'" style="margin-top:20px;"
        class="btn btn-primary">OK</button>
    </div>
  </div>
  <script>
    <?php if (!empty($errors)): ?>
      document.getElementById('messageContent').innerHTML = "<?php foreach ($errors as $err)
        if ($err)
          echo addslashes($err) . '<br>'; ?>";
      document.getElementById('messageBox').style.display = 'flex';
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      document.getElementById('messageContent').innerHTML = "<?php echo addslashes($success); ?>";
      document.getElementById('messageBox').style.display = 'flex';
    <?php endif; ?>
  </script>
  <?php if ($showOtpForm): ?>
    <form class="otp-Form" method="POST" autocomplete="off">
      <button class="exitBtn" type="submit" name="exit_otp">×</button>
      <span class="mainHeading">Nhập mã OTP</span>
      <p class="otpSubheading">
        Chúng tôi đã gửi mã xác thực đến email của
        bạn<?php if (isset($_SESSION['otp_email']))
          echo ': ' . htmlspecialchars($_SESSION['otp_email']); ?>
      </p>
      <div class="inputContainer">
        <input maxlength="1" type="text" class="otp-input" name="otp1" pattern="\d*">
        <input maxlength="1" type="text" class="otp-input" name="otp2" pattern="\d*">
        <input maxlength="1" type="text" class="otp-input" name="otp3" pattern="\d*">
        <input maxlength="1" type="text" class="otp-input" name="otp4" pattern="\d*">
      </div>
      <?php if (!empty($errors['otp'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($errors['otp']); ?></div>
      <?php endif; ?>
      <?php if (!empty($errors['csrf'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($errors['csrf']); ?></div>
      <?php endif; ?>
      <button class="verifyButton" type="submit" name="verify_otp">Xác nhận</button>

      <p class="resendNote">
        Không nhận được mã? <button class="resendBtn" type="button" onclick="alert('OTP đã được gửi lại!');">Gửi lại
          mã</button>
      </p>
      <span class="timer" id="timer">
        <?php
        $remaining = isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] - time() : 300;
        $minutes = floor($remaining / 60);
        $seconds = $remaining % 60;
        echo sprintf('%02d:%02d', $minutes, $seconds);
        ?>
      </span>
    </form>
  <?php else: ?>


    <div class="register">
      <div class="container">
        <h4 class="text-center">Đăng ký</h4>
        <div class="row">
          <div class="col-md-12 col-xs-12" style="border-left: 2px solid #ddd">
            <form id="registerForm" method="POST" novalidate="" class="has-validation-callback"
              action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <div class="form-content">
                <div class="form-group position-relative mb-3">
                  <div class="input-group">
                    <input type="text" name="fullName" required id="name"
                      class="form-control <?php echo !empty($errors['fullName']) ? 'is-invalid' : ''; ?>"
                      style="border-color: orangered;"
                      value="<?php echo (isset($_POST['register']) ? htmlspecialchars($_POST['fullName'] ?? '') : ''); ?>" />
                    <span class="input-group-text" style="border-color: orangered; border-radius: 0 5px 5px 0;">
                      <img src="../assets/image/sandt/user.png" alt="" style="width: 30px" />
                    </span>
                    <label class="label">
                      <span class="label-char" style="--index: 0">H</span>
                      <span class="label-char" style="--index: 1">ọ</span>
                      <span class="label-char" style="--index: 2">&nbsp;</span>
                      <span class="label-char" style="--index: 3">v</span>
                      <span class="label-char" style="--index: 4">à</span>
                      <span class="label-char" style="--index: 5">&nbsp;</span>
                      <span class="label-char" style="--index: 6">t</span>
                      <span class="label-char" style="--index: 7">ê</span>
                      <span class="label-char" style="--index: 8">n</span>
                    </label>
                  </div>
                  <div>
                    <?php if (!empty($errors['fullName'])): ?>
                      <div class="error-message" id="name-error" style="color: #dc3545;">
                        <?php echo htmlspecialchars($errors['fullName']); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="form-group position-relative mb-3">
                  <div class="input-group">
                    <input type="email" name="email" required id="email"
                      class="form-control <?php echo !empty($errors['email']) ? 'is-invalid' : ''; ?>"
                      style="border-color: orangered;" placeholder=" "
                      value="<?php echo (isset($_POST['register']) ? htmlspecialchars($_POST['email'] ?? '') : ''); ?>" />
                    <span class="input-group-text" style="border-color: orangered; border-radius: 0 5px 5px 0;">
                      <img src="../assets/image/sandt/email.png" alt="" style="width: 30px" />
                    </span>
                    <label class="label">
                      <span class="label-char" style="--index: 0">E</span>
                      <span class="label-char" style="--index: 1">m</span>
                      <span class="label-char" style="--index: 2">a</span>
                      <span class="label-char" style="--index: 3">i</span>
                      <span class="label-char" style="--index: 4">l</span>
                    </label>
                  </div>
                  <div>
                    <?php if (!empty($errors['email'])): ?>
                      <div class="error-message" style="color: #dc3545;">
                        <?php echo htmlspecialchars($errors['email']); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group position-relative mb-3">
                  <div class="input-group">
                    <input type="password" id="password" name="password" required
                      class="form-control <?php echo !empty($errors['password']) ? 'is-invalid' : ''; ?>"
                      style="border-color: orangered !important"
                      value="<?php echo (isset($_POST['register']) ? htmlspecialchars($_POST['password'] ?? '') : ''); ?>" />
                    <span class="input-group-text p-0" style="border-color: orangered; border-radius: 0 5px 5px 0;">
                      <button class="btn border-0" type="button" id="togglePassword">
                        <img src="../assets/image/sandt/close_eye.png" alt="icon" style="width: 30px" id="passwordIcon" />
                      </button>
                    </span>
                    <label class="label">
                      <span class="label-char" style="--index: 0">M</span>
                      <span class="label-char" style="--index: 1">ậ</span>
                      <span class="label-char" style="--index: 2">t</span>
                      <span class="label-char" style="--index: 3">&nbsp;</span>
                      <span class="label-char" style="--index: 4">K</span>
                      <span class="label-char" style="--index: 5">h</span>
                      <span class="label-char" style="--index: 6">ẩ</span>
                      <span class="label-char" style="--index: 7">u</span>
                    </label>
                  </div>
                  <div>
                    <?php if (!empty($errors['password'])): ?>
                      <div class="error-message" style="color: #dc3545;">
                        <?php echo $errors['password']; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group position-relative mb-3">
                  <div class="input-group">
                    <input type="password" id="confirmPassword" name="confirmPassword" required
                      class="form-control <?php echo !empty($errors['confirmPassword']) ? 'is-invalid' : ''; ?>"
                      value="<?php echo (isset($_POST['register']) ? htmlspecialchars($_POST['confirmPassword'] ?? '') : ''); ?>"
                      style="border-color: orangered !important" />
                    <span class="input-group-text p-0" style="border-color: orangered; border-radius: 0 5px 5px 0;">
                      <button class="btn border-0" type="button" id="toggleConfirmPassword">
                        <img src="../assets/image/sandt/close_eye.png" alt="icon" style="width: 30px"
                          id="confirmPasswordIcon" />
                      </button>
                    </span>
                    <label class="label">
                      <span class="label-char" style="--index: 0">X</span>
                      <span class="label-char" style="--index: 1">á</span>
                      <span class="label-char" style="--index: 2">c</span>
                      <span class="label-char" style="--index: 3">&nbsp;</span>
                      <span class="label-char" style="--index: 4">n</span>
                      <span class="label-char" style="--index: 5">h</span>
                      <span class="label-char" style="--index: 6">ậ</span>
                      <span class="label-char" style="--index: 7">n</span>
                      <span class="label-char" style="--index: 8">&nbsp;</span>
                      <span class="label-char" style="--index: 9">M</span>
                      <span class="label-char" style="--index: 10">ậ</span>
                      <span class="label-char" style="--index: 11">t</span>
                      <span class="label-char" style="--index: 12">&nbsp;</span>
                      <span class="label-char" style="--index: 13">K</span>
                      <span class="label-char" style="--index: 14">h</span>
                      <span class="label-char" style="--index: 15">ẩ</span>
                      <span class="label-char" style="--index: 16">u</span>
                    </label>
                  </div>
                  <div>
                    <?php if (!empty($errors['confirmPassword'])): ?>
                      <div class="error-message" style="color: #dc3545;">
                        <?php echo $errors['confirmPassword']; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group position-relative mb-3">
                  <div class="input-group">
                    <input type="tel" id="phone" name="phone" required
                      class="form-control <?php echo !empty($errors['phone']) ? 'is-invalid' : ''; ?>"
                      style="border-color: orangered !important"
                      value="<?php echo (isset($_POST['register']) ? htmlspecialchars($_POST['phone'] ?? '') : ''); ?>"
                      style="border-color: orangered !important" />
                    <span class="input-group-text" style="border-color: orangered; border-radius: 0 5px 5px 0;"><img
                        src="../assets/image/sandt/phone-call.png" alt="" style="width: 30px" /></span>
                    <label class="label">
                      <span class="label-char" style="--index: 0">S</span>
                      <span class="label-char" style="--index: 1">ố</span>
                      <span class="label-char" style="--index: 2">&nbsp;</span>
                      <span class="label-char" style="--index: 3">đ</span>
                      <span class="label-char" style="--index: 4">i</span>
                      <span class="label-char" style="--index: 5">ệ</span>
                      <span class="label-char" style="--index: 6">n</span>
                      <span class="label-char" style="--index: 7">&nbsp;</span>
                      <span class="label-char" style="--index: 8">t</span>
                      <span class="label-char" style="--index: 9">h</span>
                      <span class="label-char" style="--index: 10">o</span>
                      <span class="label-char" style="--index: 11">ạ</span>
                      <span class="label-char" style="--index: 12">i</span>
                    </label>
                  </div>
                  <div>
                    <?php if (!empty($errors['phone'])): ?>
                      <div class="error-message" style="color: #dc3545;">
                        <?php echo $errors['phone']; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group position-relative">
                  <div class="input-group">
                    <input type="text" id="address" name="address" required
                      class="form-control <?php echo !empty($errors['address']) ? 'is-invalid' : ''; ?>"
                      style="border-color: orangered !important"
                      value="<?php echo (isset($_POST['register']) ? htmlspecialchars($_POST['address'] ?? '') : ''); ?>"
                      style="border-color: orangered !important" />
                    <span class="input-group-text" style="border-color: orangered; border-radius: 0 5px 5px 0;"><img
                        src="../assets/image/sandt/address.png" alt="" style="width: 30px" /></span>
                    <label class="label">
                      <span class="label-char" style="--index: 0">Đ</span>
                      <span class="label-char" style="--index: 1">ị</span>
                      <span class="label-char" style="--index: 2">a</span>
                      <span class="label-char" style="--index: 3">&nbsp;</span>
                      <span class="label-char" style="--index: 4">c</span>
                      <span class="label-char" style="--index: 5">h</span>
                      <span class="label-char" style="--index: 6">ỉ</span>
                    </label>
                  </div>
                  <div>
                    <?php if (!empty($errors['address'])): ?>
                      <div class="error-message" style="color: #dc3545;">
                        <?php echo $errors['address']; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="form-footer mt-3">
                <div class="row gap-10">
                  <div class="col-xs-6 col-sm-6">
                    <!-- <div>
                      <div
                        class="grecaptcha-badge"
                        data-style="bottomright"
                        style="
                          width: 256px;
                          height: 60px;
                          display: block;
                          transition: right 0.3s;
                          position: fixed;
                          bottom: 14px;
                          right: -186px;
                          box-shadow: gray 0px 0px 5px;
                          border-radius: 2px;
                          overflow: hidden;
                        "
                      >
                        <div class="grecaptcha-logo">
                          <iframe
                            title="reCAPTCHA"
                            width="256"
                            height="60"
                            role="presentation"
                            name="a-4pre663cas6r"
                            frameborder="0"
                            scrolling="no"
                            sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation"
                            src="https:/www.google.com/recaptcha/api2/anchor?ar=1&k=6LczWKcpAAAAAHGDLGvc8qm3n5-d5k5zBFWHd7k_&co=aHR0cHM6Ly93d3cuc2FpZ29udG91cmlzdC5uZXQ6NDQz&hl=vi&v=hbAq-YhJxOnlU-7cpgBoAJHb&size=invisible&cb=czpgtmxftrpo"
                          ></iframe>
                        </div>
                        <div class="grecaptcha-error"></div>
                        <textarea
                          id="g-recaptcha-response"
                          name="g-recaptcha-response"
                          class="g-recaptcha-response"
                          style="
                            width: 250px;
                            height: 40px;
                            border: 1px solid rgb(193, 193, 193);
                            margin: 10px 25px;
                            padding: 0px;
                            resize: none;
                            display: none;
                          "
                        ></textarea>
                      </div>
                      <iframe style="display: none"></iframe>
                    </div> -->


                    <button type="submit" class="btn btn-primary w-100" name="register">
                      Đăng Ký
                    </button>
                  </div>
                  <div class="col-xs-6 col-sm-6 mbot-10">
                    <button type="button" class="btn btn-danger btn-block w-100" id="cancelBtn">Hủy</button>
                    <div class="login-link text-end mt-3">
                      Đã có tài khoản?
                      <a type="button" href="../index.php?act=login" class="btn btn-link">Đăng Nhập</a>
                    </div>
                  </div>
            </form>
          </div>
        </div>
      </div>
      <img src="../assets/image/sandt/flight.png" alt="" class="flight-img">
    </div>
  <?php endif; ?>
  <script src="../assets/javascript/bootstrap.bundle.min.js"></script>
  <script src="../assets/javascript/signUp.js"></script>
</body>

</html>