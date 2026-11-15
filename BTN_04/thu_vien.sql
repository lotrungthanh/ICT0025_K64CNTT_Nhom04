-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 15, 2026 lúc 04:27 PM
-- Phiên bản máy phục vụ: 10.11.16-MariaDB
-- Phiên bản PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thu_vien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_muon`
--

CREATE TABLE `chi_tiet_muon` (
  `ma_phieu_muon` int(10) UNSIGNED NOT NULL,
  `ma_sach` int(10) UNSIGNED NOT NULL,
  `ngay_tra` date DEFAULT NULL,
  `tien_phat` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `trang_thai` enum('dang_muon','da_tra') NOT NULL DEFAULT 'dang_muon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_muon`
--

INSERT INTO `chi_tiet_muon` (`ma_phieu_muon`, `ma_sach`, `ngay_tra`, `tien_phat`, `trang_thai`) VALUES
(1, 1, '2026-11-08', 10000, 'da_tra'),
(2, 2, NULL, 0, 'dang_muon'),
(2, 5, NULL, 0, 'dang_muon'),
(3, 3, NULL, 0, 'dang_muon');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doc_gia`
--

CREATE TABLE `doc_gia` (
  `ma_doc_gia` int(10) UNSIGNED NOT NULL,
  `ma_the` varchar(20) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `ngay_het_han` date NOT NULL,
  `trang_thai` enum('hoat_dong','bi_khoa') NOT NULL DEFAULT 'hoat_dong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `doc_gia`
--

INSERT INTO `doc_gia` (`ma_doc_gia`, `ma_the`, `ho_ten`, `so_dien_thoai`, `dia_chi`, `ngay_het_han`, `trang_thai`) VALUES
(1, 'TV2026001', 'Nguyễn Văn An', '0900000003', 'Sơn La', '2027-09-01', 'hoat_dong'),
(2, 'TV2026002', 'Lê Thị Bình', '0900000004', 'Điện Biên', '2027-09-01', 'hoat_dong'),
(3, 'TV2026003', 'Phạm Quốc Cường', '0900000005', 'Lai Châu', '2027-09-05', 'hoat_dong');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `ma_nguoi_dung` int(10) UNSIGNED NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau_ma_hoa` varchar(255) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `vai_tro` enum('quan_tri','thu_thu') NOT NULL DEFAULT 'thu_thu',
  `trang_thai` tinyint(1) NOT NULL DEFAULT 1
) ;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`ma_nguoi_dung`, `ten_dang_nhap`, `mat_khau_ma_hoa`, `ho_ten`, `vai_tro`, `trang_thai`) VALUES
(1, 'admin', '123', 'Quản trị hệ thống', 'quan_tri', 1),
(2, 'thuthu1', '456', 'Trần Thị Thủ Thư', 'thu_thu', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_muon`
--

CREATE TABLE `phieu_muon` (
  `ma_phieu_muon` int(10) UNSIGNED NOT NULL,
  `ma_doc_gia` int(10) UNSIGNED NOT NULL,
  `ma_nguoi_dung` int(10) UNSIGNED NOT NULL,
  `ngay_muon` date NOT NULL,
  `han_tra` date NOT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `phieu_muon`
--

INSERT INTO `phieu_muon` (`ma_phieu_muon`, `ma_doc_gia`, `ma_nguoi_dung`, `ngay_muon`, `han_tra`) VALUES
(1, 1, 2, '2026-10-20', '2026-11-03'),
(2, 2, 2, '2026-11-05', '2026-11-19'),
(3, 3, 2, '2026-10-28', '2026-11-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sach`
--

CREATE TABLE `sach` (
  `ma_sach` int(10) UNSIGNED NOT NULL,
  `ten_sach` varchar(255) NOT NULL,
  `tac_gia` varchar(100) NOT NULL,
  `nam_xuat_ban` year(4) DEFAULT NULL,
  `ma_the_loai` smallint(5) UNSIGNED NOT NULL,
  `tong_so_ban` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `so_ban_con` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `vi_tri_ke` varchar(50) DEFAULT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `sach`
--

INSERT INTO `sach` (`ma_sach`, `ten_sach`, `tac_gia`, `nam_xuat_ban`, `ma_the_loai`, `tong_so_ban`, `so_ban_con`, `vi_tri_ke`) VALUES
(1, 'Mắt biếc', 'Nguyễn Nhật Ánh', '1990', 1, 3, 3, 'A1-01'),
(2, 'Cho tôi xin một vé đi tuổi thơ', 'Nguyễn Nhật Ánh', '2008', 2, 2, 1, 'B1-01'),
(3, 'Dế Mèn phiêu lưu ký', 'Tô Hoài', '1941', 2, 1, 0, 'B1-02'),
(4, 'Chí Phèo', 'Nam Cao', '1941', 1, 2, 2, 'A1-02'),
(5, 'Cơ sở dữ liệu', 'Nhiều tác giả', '2019', 3, 2, 1, 'C2-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the_loai`
--

CREATE TABLE `the_loai` (
  `ma_the_loai` smallint(5) UNSIGNED NOT NULL,
  `ten_the_loai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `the_loai`
--

INSERT INTO `the_loai` (`ma_the_loai`, `ten_the_loai`) VALUES
(3, 'Công nghệ thông tin'),
(2, 'Thiếu nhi'),
(1, 'Văn học');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_tiet_muon`
--
ALTER TABLE `chi_tiet_muon`
  ADD PRIMARY KEY (`ma_phieu_muon`,`ma_sach`),
  ADD KEY `idx_ctm_sach` (`ma_sach`);

--
-- Chỉ mục cho bảng `doc_gia`
--
ALTER TABLE `doc_gia`
  ADD PRIMARY KEY (`ma_doc_gia`),
  ADD UNIQUE KEY `uq_doc_gia_ma_the` (`ma_the`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`ma_nguoi_dung`),
  ADD UNIQUE KEY `uq_nguoi_dung_ten_dn` (`ten_dang_nhap`);

--
-- Chỉ mục cho bảng `phieu_muon`
--
ALTER TABLE `phieu_muon`
  ADD PRIMARY KEY (`ma_phieu_muon`),
  ADD KEY `fk_pm_doc_gia` (`ma_doc_gia`),
  ADD KEY `fk_pm_nguoi_dung` (`ma_nguoi_dung`);

--
-- Chỉ mục cho bảng `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`ma_sach`),
  ADD KEY `fk_sach_the_loai` (`ma_the_loai`),
  ADD KEY `idx_sach_ten` (`ten_sach`),
  ADD KEY `idx_sach_tac_gia` (`tac_gia`);

--
-- Chỉ mục cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  ADD PRIMARY KEY (`ma_the_loai`),
  ADD UNIQUE KEY `uq_the_loai_ten` (`ten_the_loai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `doc_gia`
--
ALTER TABLE `doc_gia`
  MODIFY `ma_doc_gia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `ma_nguoi_dung` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phieu_muon`
--
ALTER TABLE `phieu_muon`
  MODIFY `ma_phieu_muon` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sach`
--
ALTER TABLE `sach`
  MODIFY `ma_sach` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  MODIFY `ma_the_loai` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `chi_tiet_muon`
--
ALTER TABLE `chi_tiet_muon`
  ADD CONSTRAINT `fk_ctm_phieu_muon` FOREIGN KEY (`ma_phieu_muon`) REFERENCES `phieu_muon` (`ma_phieu_muon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctm_sach` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`) ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `phieu_muon`
--
ALTER TABLE `phieu_muon`
  ADD CONSTRAINT `fk_pm_doc_gia` FOREIGN KEY (`ma_doc_gia`) REFERENCES `doc_gia` (`ma_doc_gia`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pm_nguoi_dung` FOREIGN KEY (`ma_nguoi_dung`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`) ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `sach`
--
ALTER TABLE `sach`
  ADD CONSTRAINT `fk_sach_the_loai` FOREIGN KEY (`ma_the_loai`) REFERENCES `the_loai` (`ma_the_loai`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
