-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 05:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `du_lich`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id_Banner` varchar(20) NOT NULL,
  `img_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id_Banner`, `img_url`) VALUES
('BannerTrangChu1', '2025 - Nhat Ban hoa anh dao.jpg'),
('BannerTrangChu2', '2025-ChaoHe - Uc Queensland.jpg'),
('BannerTrangChu3', 'STS---banner-web-370-x-208px-30.4-1.5.ai-banner-nho.png'),
('BannerTrangChu4', 'STS---banner-web-770-x-433px-LHAT-2025.png');

-- --------------------------------------------------------

--
-- Table structure for table `diemden_traingiem`
--

CREATE TABLE `diemden_traingiem` (
  `id_DDvsTN` varchar(50) NOT NULL,
  `QuocGia` varchar(300) NOT NULL,
  `TieuDe` varchar(300) NOT NULL,
  `MoTa` varchar(500) NOT NULL,
  `img_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diemden_traingiem`
--

INSERT INTO `diemden_traingiem` (`id_DDvsTN`, `QuocGia`, `TieuDe`, `MoTa`, `img_url`) VALUES
('DiemDen_TrangChu1', '[Du lịch Việt Nam]', 'Hành trình đắm chìm vẻ đẹp biển trời miền Trung', 'Không gian xanh mát, thơ mộng hoà cùng làn nước biển trong xanh đã làm lưu luyến bao trái tim khách thập phương khi tìm về \"Xứ Nẫu\".', 'Ky-Co-island_298885256.jpg'),
('DiemDen_TrangChu2', '[Du lịch Việt Nam]', 'Hà Giang - Nơi đá nở hoa', 'Hà Giang - Vùng đất địa đầu của Tổ quốc - nơi cảnh vật làm nao lòng du khách khi đặt chân đến nơi đây. Mỗi mùa, mỗi thời điểm khác nhau lại có một nét đặc trưng', 'Xin-Man_1131374039.jpg'),
('DiemDen_TrangChu3', '[Du lịch Thai Lan]', 'Du lịch ngoài nước - Trải nghiệm mới mẻ cho kỳ nghỉ 30/4 và 1/5', 'Du lịch nước ngoài không chỉ giúp bạn khám phá những nền văn hóa mới mẻ, mở rộng tầm nhìn mà còn mang đến cho bạn những trải nghiệm độc đáo và khó quên', 'Bangkok-China-Town_1124522612.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gia_ve`
--

CREATE TABLE `gia_ve` (
  `tour_id` varchar(20) NOT NULL,
  `tuoi` int(11) NOT NULL,
  `gia_ve` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don`
--

CREATE TABLE `hoa_don` (
  `user_id` varchar(20) NOT NULL,
  `hoadon_id` varchar(20) NOT NULL,
  `tour_id` varchar(20) NOT NULL,
  `gia_ve` int(11) NOT NULL,
  `khuyen_mai_id` varchar(20) NOT NULL,
  `ngay_dat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khuyen_mai`
--

CREATE TABLE `khuyen_mai` (
  `k_id` varchar(20) NOT NULL,
  `khuyen_mai` smallint(6) NOT NULL,
  `thoi_han` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lienhe`
--

CREATE TABLE `lienhe` (
  `id_LienHe` varchar(20) NOT NULL,
  `HoTen` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Sdt` varchar(10) DEFAULT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `NoiDung` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `loc_id` varchar(20) DEFAULT NULL,
  `tour_id` varchar(20) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Ratings';

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE `slide` (
  `id_slide` varchar(20) NOT NULL,
  `TieuDe` varchar(100) DEFAULT NULL,
  `MoTa` varchar(300) DEFAULT NULL,
  `img_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slide`
--

INSERT INTO `slide` (`id_slide`, `TieuDe`, `MoTa`, `img_url`) VALUES
('slideTrangChu1', 'Du lịch Tân Cương', 'Giảm đến 2000000 đ/người', 'shutterstock_386148169.jpg'),
('slideTrangChu2', 'Du lịch Hà Giang', 'khởi hành 28/4/2025', 'Bangioc-Caobang-Vietnam_509256661.jpg'),
('slideTrangChu3', 'Du lịch Miền Trung', 'Kỉ niệm sinh nhật 50 năm', 'Eo-Gio-sea_685030210.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE `tintuc` (
  `MaTinTuc` varchar(20) NOT NULL,
  `TenTinTuc` varchar(100) DEFAULT NULL,
  `NgayDang` date DEFAULT NULL,
  `MoTa` varchar(300) DEFAULT NULL,
  `LuotXem` int(11) DEFAULT NULL,
  `img_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `maTour` varchar(20) NOT NULL,
  `tenTour` varchar(50) DEFAULT NULL,
  `loaiTour` varchar(50) DEFAULT NULL,
  `img_url` varchar(50) DEFAULT NULL,
  `tuyenDi` varchar(50) DEFAULT NULL,
  `moTa` varchar(100) DEFAULT NULL,
  `ngayMoTour` datetime DEFAULT NULL,
  `ngayHetTour` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trang_chu`
--

CREATE TABLE `trang_chu` (
  `idSlide` varchar(20) NOT NULL,
  `idBanner` varchar(20) NOT NULL,
  `maTinTuc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sdt` varchar(11) DEFAULT NULL,
  `dia_chi` varchar(200) NOT NULL,
  `NgaySinh` date DEFAULT NULL,
  `GioiTinh` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `otp` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Info';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `sdt`, `dia_chi`, `NgaySinh`, `GioiTinh`, `password`, `otp`) VALUES
('112580868226092746395', 'Vương Quốc An', 'azan100an3@gmail.com', '0818182400', 'Bình Thạnh', '2005-03-09', 1, '1234567', NULL),
('114307604018377441301', 'An Vương Quốc', 'quocan090305@gmail.com', NULL, '', '0000-00-00', 0, '114307604018377441301', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vitritour`
--

CREATE TABLE `vitritour` (
  `maTour` varchar(20) NOT NULL,
  `locID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vi_tri`
--

CREATE TABLE `vi_tri` (
  `loc_id` varchar(20) NOT NULL,
  `mo_ta` int(11) NOT NULL,
  `img_url` int(11) NOT NULL,
  `vi_tri` int(11) NOT NULL,
  `ten_loc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id_Banner`);

--
-- Indexes for table `gia_ve`
--
ALTER TABLE `gia_ve`
  ADD PRIMARY KEY (`tour_id`);

--
-- Indexes for table `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`hoadon_id`),
  ADD KEY `fk_hoadon_userid` (`user_id`),
  ADD KEY `fk_hoadon_tour` (`tour_id`),
  ADD KEY `fk_hoadon_khuyenmai` (`khuyen_mai_id`);

--
-- Indexes for table `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  ADD PRIMARY KEY (`k_id`);

--
-- Indexes for table `lienhe`
--
ALTER TABLE `lienhe`
  ADD PRIMARY KEY (`id_LienHe`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_review_tourid` (`user_id`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id_slide`);

--
-- Indexes for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`MaTinTuc`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`maTour`);

--
-- Indexes for table `trang_chu`
--
ALTER TABLE `trang_chu`
  ADD PRIMARY KEY (`idSlide`),
  ADD KEY `FK_Trang_chu_Banner` (`idBanner`),
  ADD KEY `FK_Trang_chu_Tin_Tuc` (`maTinTuc`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vitritour`
--
ALTER TABLE `vitritour`
  ADD PRIMARY KEY (`maTour`),
  ADD KEY `fk_vitritour_vitri` (`locID`);

--
-- Indexes for table `vi_tri`
--
ALTER TABLE `vi_tri`
  ADD PRIMARY KEY (`loc_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gia_ve`
--
ALTER TABLE `gia_ve`
  ADD CONSTRAINT `fk_giave` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`maTour`);

--
-- Constraints for table `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD CONSTRAINT `fk_hoadon_khuyenmai` FOREIGN KEY (`khuyen_mai_id`) REFERENCES `khuyen_mai` (`k_id`),
  ADD CONSTRAINT `fk_hoadon_tour` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`maTour`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_review_tourid` FOREIGN KEY (`user_id`) REFERENCES `tour` (`maTour`);

--
-- Constraints for table `trang_chu`
--
ALTER TABLE `trang_chu`
  ADD CONSTRAINT `FK_Trang_chu_Banner` FOREIGN KEY (`idBanner`) REFERENCES `banner` (`id_Banner`),
  ADD CONSTRAINT `FK_Trang_chu_Slide` FOREIGN KEY (`idSlide`) REFERENCES `slide` (`id_slide`),
  ADD CONSTRAINT `FK_Trang_chu_Tin_Tuc` FOREIGN KEY (`maTinTuc`) REFERENCES `tintuc` (`MaTinTuc`);

--
-- Constraints for table `vitritour`
--
ALTER TABLE `vitritour`
  ADD CONSTRAINT `fk_vitritour_tour` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`),
  ADD CONSTRAINT `fk_vitritour_vitri` FOREIGN KEY (`locID`) REFERENCES `vi_tri` (`loc_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
