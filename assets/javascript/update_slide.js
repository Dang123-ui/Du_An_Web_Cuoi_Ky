document.querySelectorAll('.edit-slide-btn').forEach(button => {
    button.addEventListener('click', function() {
        const slideId = this.getAttribute('data-id');
        document.getElementById('slide_id').value = slideId;
        
        // Fetch slide data
        fetch(`../controller/get_slide.php?id=${slideId}`)
            .then(response => response.json())
            .then(data => {
                // Tự động điền các giá trị hiện tại
                document.getElementById('slide_title').value = data.TieuDe;
                document.getElementById('slide_desc').value = data.MoTa;
                
                // Hiển thị ảnh hiện tại
                const preview = document.getElementById('slide_preview');
                preview.src = `../assets/image/${data.img_url}`;
                preview.style.display = 'block';
                
                // Đánh dấu trường ảnh là không bắt buộc vì đã có ảnh cũ
                document.getElementById('slide_image').removeAttribute('required');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Không thể tải thông tin slide');
            });
    });
});

document.getElementById('updateSlideForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('../controller/update_slide.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra: ' + error.message);
    });
});

// Preview image before upload
document.getElementById('slide_image').addEventListener('change', function(e) {
    const preview = document.getElementById('slide_preview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});