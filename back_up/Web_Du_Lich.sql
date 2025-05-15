CREATE DATABASE IF NOT EXISTS Web_Du_Lich
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Chọn database để sử dụng
USE Web_Du_Lich;

-- Xóa bảng nếu đã tồn tại để tránh lỗi
DROP TABLE IF EXISTS banners;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS tours;
DROP TABLE IF EXISTS users;


-- Bảng Users (Người dùng/Admin)
CREATE TABLE users (
    user_id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    birthday DATE,
    gender TINYINT,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Tours (Tour du lịch)
CREATE TABLE tours (
    tour_id VARCHAR(20) PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    duration INT NOT NULL, -- Số ngày
    start_date DATE,
    end_date DATE,
    location VARCHAR(200),
    image_url VARCHAR(255),
    max_people INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Orders (Đơn đặt tour)
CREATE TABLE orders (
    order_id VARCHAR(20) PRIMARY KEY,
    user_id VARCHAR(50),
    tour_id VARCHAR(20),
    total_price DECIMAL(10,2),
    number_of_people INT,
    status ENUM('pending', 'confirmed', 'paid', 'cancelled') DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id)
);

-- Bảng Reviews (Đánh giá)
CREATE TABLE reviews (
    review_id VARCHAR(20) PRIMARY KEY,
    user_id VARCHAR(50),
    tour_id VARCHAR(20),
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id)
);

-- Bảng Posts (Tin tức/Bài viết)
CREATE TABLE posts (
    post_id VARCHAR(20) PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    image_url VARCHAR(255),
    author_id VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(user_id)
);

-- Bảng Banners
CREATE TABLE banners (
    banner_id VARCHAR(20) PRIMARY KEY,
    title VARCHAR(200),
    image_url VARCHAR(255) NOT NULL,
    link VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);