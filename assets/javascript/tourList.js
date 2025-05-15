document.addEventListener('DOMContentLoaded', () => {
    // Khởi tạo Flatpickr
    flatpickr("#ngaydi", {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
            const ngayvePicker = document.querySelector("#ngayve")._flatpickr;
            ngayvePicker.set('minDate', dateStr);
            searchTours(1); // Tìm kiếm khi thay đổi ngày
        }
    });

    flatpickr("#ngayve", {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function() {
            searchTours(1); // Tìm kiếm khi thay đổi ngày
        }
    });

    // Lấy các phần tử biểu mẫu
    const searchForm = document.querySelector('form[name="timkiem"]');
    const searchInput = searchForm.querySelector('input[name="search"]');
    const typeSelect = searchForm.querySelector('select[name="type"]');

    // Cơ chế debounce cho tìm kiếm
    let debounceTimeout;
    const debounceSearch = () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => searchTours(1), 300); // Trì hoãn 300ms
    };

    // Lắng nghe sự kiện input trên trường tìm kiếm
    searchInput.addEventListener('input', () => {
        if (searchInput.value.length >= 2 || searchInput.value.length === 0) {
            debounceSearch(); // Chỉ tìm kiếm nếu có ít nhất 2 ký tự hoặc xóa hết
        }
    });

    // Lắng nghe thay đổi trên select loại tour
    typeSelect.addEventListener('change', () => searchTours(1));

    // Xử lý liên kết sắp xếp
    const sortLinks = document.querySelectorAll('.filter-tour a');
    sortLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const url = new URL(link.href);
            const sort = url.searchParams.get('sort');
            const order = url.searchParams.get('order');
            searchTours(1, sort, order);
        });
    });

    // Hàm tìm kiếm AJAX
    window.searchTours = function(page, sort = 'ngaymotour', order = 'DESC') {
        const formData = new FormData(searchForm);
        formData.append('page', page);
        formData.append('sort', sort);
        formData.append('order', order);

        // Hiển thị chỉ báo tải
        const tourListWrapper = document.querySelector('.innerpage-wrapper');
        tourListWrapper.querySelector('.tour-list').innerHTML = '<div class="text-center"><p>Đang tải...</p></div>';

        fetch('ajax_search_tours.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Cập nhật danh sách tour và phân trang
            const existingTourList = tourListWrapper.querySelector('.tour-list');
            const existingPagination = tourListWrapper.querySelector('.paginationCenter');

            // Phân tích phản hồi
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data;

            // Thay thế danh sách tour
            if (existingTourList) {
                existingTourList.remove();
            }
            tourListWrapper.insertBefore(tempDiv.querySelector('.tour-list'), tourListWrapper.querySelector('.container-slider'));

            // Thay thế phân trang
            if (existingPagination) {
                existingPagination.parentElement.remove();
            }
            tourListWrapper.appendChild(tempDiv.querySelector('.paginationCenter').parentElement);

            // Cập nhật liên kết sắp xếp đang hoạt động
            sortLinks.forEach(link => {
                const url = new URL(link.href);
                const linkSort = url.searchParams.get('sort');
                link.classList.toggle('active', linkSort === sort);
            });
        })
        .catch(error => {
            console.error('Lỗi:', error);
            tourListWrapper.querySelector('.tour-list').innerHTML = '<div class="text-center"><p>Đã có lỗi xảy ra. Vui lòng thử lại sau.</p></div>';
        });
    };

    // Tìm kiếm ban đầu
    searchTours(1);
});
document.addEventListener('DOMContentLoaded', function() {
  if (window.scrollY !== 0) {
    window.scrollTo(0, 0);
  }
});
document.addEventListener("DOMContentLoaded", function () {
  let element = document.querySelector(".overlay");
  element.classList.add("show");
});

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector('.search-form input[type="text"]');
  const searchForm = document.querySelector(".search-form");
  const body = document.body;

  searchInput.addEventListener("focus", function () {
    body.classList.add("focus-overlay");
  });
  searchInput.addEventListener("blur", function () {
    overlay.classList.remove("focus-overlay");
  });
  document.addEventListener("mousedown", function (event) {
    if (!searchForm.contains(event.target) && event.target !== searchInput) {
      body.classList.remove("focus-overlay");
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll(
    ".search-form .input-group, .search-form select, button"
  );
  const delay = 150;
  let currentIndex = 0;
  function animateNextInput() {
    if (currentIndex < inputs.length) {
      inputs[currentIndex].classList.add("domino-bounce");
      currentIndex++;
      setTimeout(animateNextInput, delay);
    }
  }
  setTimeout(animateNextInput, 300);
});

document.addEventListener("DOMContentLoaded", function () {
  const options = {
    locale: "vn",
    dateFormat: "d/m/Y",
    allowInput: true,
    disableMobile: true,
    onOpen: function (selectedDates, dateStr, instance) {
      // Áp dụng active state cho icon tương ứng
      instance.element.nextElementSibling.classList.add("active");
    },
    onClose: function (selectedDates, dateStr, instance) {
      // Xóa active state
      instance.element.nextElementSibling.classList.remove("active");
    },
  };
  const ngayDi = flatpickr("#ngaydi", options);
  const ngayVe = flatpickr("#ngayve", options);
  document.querySelectorAll(".calendar-icon").forEach((icon) => {
    icon.addEventListener("click", function () {
      // Lấy input tương ứng
      const input = this.previousElementSibling;

      // Mở calendar đúng với input được click
      if (input.id === "ngaydi") {
        ngayDi.open();
      } else {
        ngayVe.open();
      }

      // Hiệu ứng ripple
      this.classList.add("clicked");
      setTimeout(() => {
        this.classList.remove("clicked");
      }, 300);
    });
  });
  ngayDi.config.onChange.push(function (selectedDates) {
    ngayVe.set("minDate", selectedDates[0] || new Date());
  });
});

let items = document.querySelectorAll(".slider .item");
let next = document.getElementById("next");
let prev = document.getElementById("prev");

let active = 3;
function loadShow() {
  let stt = 0;
  items[active].style.transform = `none`;
  items[active].style.zIndex = 1;
  items[active].style.filter = "none";
  items[active].style.opacity = 1;
  for (var i = active + 1; i < items.length; i++) {
    stt++;
    items[i].style.transform = `translateX(${120 * stt}px) scale(${
      1 - 0.2 * stt
    }) perspective(16px) rotateY(-1deg)`;
    items[i].style.zIndex = -stt;
    items[i].style.filter = "blur(5px)";
    items[i].style.opacity = stt > 2 ? 0 : 0.6;
  }
  stt = 0;
  for (var i = active - 1; i >= 0; i--) {
    stt++;
    items[i].style.transform = `translateX(${-120 * stt}px) scale(${
      1 - 0.2 * stt
    }) perspective(16px) rotateY(1deg)`;
    items[i].style.zIndex = -stt;
    items[i].style.filter = "blur(5px)";
    items[i].style.opacity = stt > 2 ? 0 : 0.6;
  }
}
loadShow();
next.onclick = function () {
  active = active + 1 < items.length ? active + 1 : active;
  loadShow();
};
prev.onclick = function () {
  active = active - 1 >= 0 ? active - 1 : active;
  loadShow();
};

gsap.registerPlugin(ScrollTrigger);

gsap.utils.toArray(".card").forEach((card, index) => {
  const startX = -200;
  gsap.fromTo(
    card,
    { opacity: 0, y: startX, scale: 0.3},
    {
      opacity: 1,
      y: 0,
      scale: 1,
      rotationZ: 0,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: card,
        start: `top 60%`,
        end: "top 30%",
        scrub: 1,
        toggleActions: "play none none reverse",
        markers: false,
      },
      
    }
  );
});

