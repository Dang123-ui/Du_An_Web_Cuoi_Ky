document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const bannerId = this.getAttribute('data-id');
        document.getElementById('banner_id').value = bannerId;
        console.log('Set banner ID:', bannerId);
    });
});
document.getElementById('updateBannerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Log để debug
    console.log('Banner ID:', formData.get('banner_id'));
    console.log('Image File:', formData.get('banner_image'));

    // Sửa đường dẫn fetch
    fetch('../controller/update_banner.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        // Log response để debug
        console.log('Raw response:', response);
        return response.text().then(text => {
            console.log('Response text:', text);
            return JSON.parse(text);
        });
    })
    .then(data => {
        console.log('Parsed data:', data);
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
document.getElementById('banner_image').addEventListener('change', function(e) {
    const preview = document.getElementById('image_preview');
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