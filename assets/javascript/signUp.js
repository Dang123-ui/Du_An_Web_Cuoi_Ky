window.addEventListener("load", resizeVideo);
window.addEventListener("resize", resizeVideo);
document.addEventListener("DOMContentLoaded", function () {
  var cancelBtn = document.getElementById('cancelBtn');
  if (cancelBtn) {
    cancelBtn.onclick = function() {
      window.location.reload();
    };
  }
});
function resizeVideo() {
  const video = document.getElementById("bg-video");
  if (!video.videoWidth || !video.videoHeight) {
    setTimeout(resizeVideo, 50);
    return;
  }
  const aspectRatio = video.videoWidth / video.videoHeight;
  if (window.innerWidth / window.innerHeight > aspectRatio) {
    video.style.width = "100%";
    video.style.height = "auto";
  } else {
    video.style.width = "auto";
    video.style.height = "100%";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("password");
  const eyeIcon = document.getElementById("passwordIcon");
  toggleBtn.addEventListener("click", function () {
    
    const isHidden = passwordInput.type === "password";

  
    passwordInput.type = isHidden ? "text" : "password";

    eyeIcon.src = isHidden ? "../image/sandt/open_eye.png" : "../images/sandt/close_eye.png";
    console.log("Trạng thái mật khẩu:", isHidden ? "Hiển thị" : "Ẩn");
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("toggleConfirmPassword");
  const passwordInput = document.getElementById("confirmPassword");
  const eyeIcon = document.getElementById("confirmPasswordIcon");
  toggleBtn.addEventListener("click", function () {
    
    const isHidden = passwordInput.type === "password";

  
    passwordInput.type = isHidden ? "text" : "password";

    eyeIcon.src = isHidden ? "../image/sandt/open_eye.png" : "../image/sandt/close_eye.png";
    console.log("Trạng thái mật khẩu:", isHidden ? "Hiển thị" : "Ẩn");
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const otpForm = document.querySelector('.otp-Form');
    if (otpForm) {
        const otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        // Đồng bộ thời gian với PHP
        let timeLeft = parseInt(document.getElementById('timer').textContent.split(':').reduce((acc, curr) => acc * 60 + parseInt(curr), 0));
        const timerElement = document.getElementById('timer');
        const resendBtn = document.querySelector('.resendBtn');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            if (timeLeft > 0) {
                timeLeft--;
            } else {
                timerElement.textContent = 'Hết hạn';
                resendBtn.disabled = false;
                clearInterval(timerInterval);
            }
        }

        let timerInterval = setInterval(updateTimer, 1000);
        resendBtn.disabled = timeLeft > 0;
      }
});

