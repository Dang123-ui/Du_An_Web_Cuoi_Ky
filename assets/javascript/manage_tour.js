// Add at the beginning of the file
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('tourTable');
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const totalToursElement = document.getElementById('totalTours');
    let currentPage = 1;
    // Thêm chức năng tìm kiếm
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    function searchTable() {
        const searchText = searchInput.value.toLowerCase();
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        
        rows.forEach(row => {
            const maTour = row.cells[0].textContent.toLowerCase();
            const tenTour = row.cells[1].textContent.toLowerCase();
            
            if (maTour.includes(searchText) || tenTour.includes(searchText)) {
                row.classList.remove('d-none');
            } else {
                row.classList.add('d-none');
            }
        });
        
        // Cập nhật phân trang sau khi tìm kiếm
        currentPage = 1;
        updateTable();
    }

    searchButton.addEventListener('click', searchTable);
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            searchTable();
        }
    });

    // Thêm chức năng sắp xếp
    document.querySelectorAll('.sort-btn').forEach(button => {
        button.addEventListener('click', function() {
            const sortType = this.dataset.sort;
            const sortOrder = this.dataset.order;
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            
            // Remove active class from all buttons
            document.querySelectorAll('.sort-btn').forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            rows.sort((a, b) => {
                let aValue, bValue;
                
                switch(sortType) {
                    case 'price':
                        aValue = parseInt(a.cells[2].textContent.replace(/[^\d]/g, ''));
                        bValue = parseInt(b.cells[2].textContent.replace(/[^\d]/g, ''));
                        break;
                    case 'date':
                        aValue = new Date(a.cells[6].textContent.split('/').reverse().join('-'));
                        bValue = new Date(b.cells[6].textContent.split('/').reverse().join('-'));
                        break;
                    case 'people':
                        aValue = parseInt(a.cells[10].textContent);
                        bValue = parseInt(b.cells[10].textContent);
                        break;
                }
                
                if (sortOrder === 'asc') {
                    return aValue > bValue ? 1 : -1;
                } else {
                    return aValue < bValue ? 1 : -1;
                }
            });

            // Xóa các row hiện tại
            rows.forEach(row => row.remove());
            // Thêm lại các row đã sắp xếp
            const tbody = table.querySelector('tbody');
            rows.forEach(row => tbody.appendChild(row));
            
            // Cập nhật phân trang
            currentPage = 1;
            updateTable();
        });
    });
    
    function updateTable() {
        const rowsPerPage = parseInt(rowsPerPageSelect.value);
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        
        // Update total tours count
        totalToursElement.textContent = totalRows;
        
        // Hide all rows
        rows.forEach(row => row.style.display = 'none');
        
        // Show rows for current page
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.slice(start, end).forEach(row => row.style.display = '');
        
        // Update pagination
        updatePagination(totalPages);
    }
    
    function updatePagination(totalPages) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';
        
        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = '<a class="page-link" href="#">Previous</a>';
        prevLi.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        };
        pagination.appendChild(prevLi);
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${currentPage === i ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.onclick = () => {
                currentPage = i;
                updateTable();
            };
            pagination.appendChild(li);
        }
        
        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = '<a class="page-link" href="#">Next</a>';
        nextLi.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        };
        pagination.appendChild(nextLi);
    }
    
    // Initialize table
    updateTable();
    
    // Listen for rows per page changes
    rowsPerPageSelect.addEventListener('change', () => {
        currentPage = 1; // Reset to first page
        updateTable();
    });
});

// ...existing code...

// Preview image before upload
document.getElementById('tour_image').addEventListener('change', function(e) {
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

// Edit tour
document.querySelectorAll('.edit-tour').forEach(button => {
    button.addEventListener('click', function() {
        const tourId = this.getAttribute('data-id');
        fetch(`../controller/get_tour.php?id=${tourId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('maTour').value = data.maTour;
                document.getElementById('tenTour').value = data.tenTour;
                document.getElementById('price').value = data.price;
                document.querySelector(`input[name="loaiTour"][value="${data.loaiTour}"]`).checked = true;
                document.getElementById('tuyenDi').value = data.tuyenDi;
                document.getElementById('ngayMoTour').value = data.ngayMoTour;
                document.getElementById('thoiLuong').value = data.thoiLuong;
                document.getElementById('discount').value = data.discount;
                document.getElementById('max_people').value = data.max_people;
                document.getElementById('isFetured').checked = data.isFetured === '1';
                document.getElementById('description').value = data.description;
                
                if (data.img_url) {
                    const preview = document.getElementById('image_preview');
                    preview.src = `../assets/image/${data.img_url}`;
                    preview.style.display = 'block';
                }
            });
    });
});

// Submit form
document.getElementById('tourForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('../controller/update_tour.php', {
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

// Delete tour
document.querySelectorAll('.delete-tour').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Bạn có chắc muốn xóa tour này?')) {
            const tourId = this.getAttribute('data-id');
            fetch('../controller/delete_tour.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ maTour: tourId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    });
});

