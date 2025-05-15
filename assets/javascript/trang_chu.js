var swiper1 = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    effect: "fade",
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
        clickable: true,
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    on: {
        slideChangeTransitionStart: function () {
            document.querySelectorAll(".slide-content").forEach((content) => {
                content.classList.remove("animate-content");
            });
        },
        slideChangeTransitionEnd: function () {
            const activeSlide = document.querySelector(".swiper-slide-active .slide-content");
            if (activeSlide) {
                activeSlide.classList.add("animate-content");
            }
        },
    },
});

var swiper2 = new Swiper(".mySwiper2", {
    slidesPerView: 3,
    loop: true,
    spaceBetween: 30,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    breakpoints: {
        320: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    }
  });

window.addEventListener("scroll", function() {
    var navbar = document.querySelector(".navbar ");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});