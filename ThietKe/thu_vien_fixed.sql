-- ============================================================
-- Cơ sở dữ liệu: thuvien1 (Web quản lý thư viện - PHP + MySQL)
-- Tương thích MySQL 8 / MariaDB 10.6+. Nhập (import) được trên máy trống.
-- Chạy lại file này sẽ XÓA và tạo lại các bảng (đặt lại dữ liệu mẫu).
--
-- Quy ước: tiền phạt = số ngày trả trễ x 1000 đồng/ngày.
-- Mật khẩu trong bảng nguoi_dung là chuỗi băm bcrypt (password_hash),
-- kiểm tra bằng password_verify() trong PHP. Tài khoản demo xem README.
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `thuvien1` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `thuvien1`;

DROP TABLE IF EXISTS `chi_tiet_muon`;
DROP TABLE IF EXISTS `phieu_muon`;
DROP TABLE IF EXISTS `sach`;
DROP TABLE IF EXISTS `doc_gia`;
DROP TABLE IF EXISTS `nguoi_dung`;
DROP TABLE IF EXISTS `the_loai`;

-- ------------------------------------------------------------
-- Bảng the_loai
-- ------------------------------------------------------------
CREATE TABLE `the_loai` (
  `ma_the_loai` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_the_loai` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`ma_the_loai`),
  UNIQUE KEY `uq_the_loai_ten` (`ten_the_loai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bảng nguoi_dung (tài khoản quản trị / thủ thư)
-- ------------------------------------------------------------
CREATE TABLE `nguoi_dung` (
  `ma_nguoi_dung` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_dang_nhap` VARCHAR(50) NOT NULL,
  `mat_khau_ma_hoa` VARCHAR(255) NOT NULL,
  `ho_ten` VARCHAR(100) NOT NULL,
  `vai_tro` ENUM('quan_tri','thu_thu') NOT NULL DEFAULT 'thu_thu',
  `trang_thai` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ma_nguoi_dung`),
  UNIQUE KEY `uq_nguoi_dung_ten_dn` (`ten_dang_nhap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bảng doc_gia
-- ------------------------------------------------------------
CREATE TABLE `doc_gia` (
  `ma_doc_gia` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ma_the` VARCHAR(20) NOT NULL,
  `ho_ten` VARCHAR(100) NOT NULL,
  `so_dien_thoai` VARCHAR(15) DEFAULT NULL,
  `dia_chi` VARCHAR(255) DEFAULT NULL,
  `ngay_het_han` DATE NOT NULL,
  `trang_thai` ENUM('hoat_dong','bi_khoa') NOT NULL DEFAULT 'hoat_dong',
  PRIMARY KEY (`ma_doc_gia`),
  UNIQUE KEY `uq_doc_gia_ma_the` (`ma_the`),
  KEY `idx_doc_gia_ho_ten` (`ho_ten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bảng sach
-- ------------------------------------------------------------
CREATE TABLE `sach` (
  `ma_sach` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_sach` VARCHAR(255) NOT NULL,
  `tac_gia` VARCHAR(100) NOT NULL,
  `nam_xuat_ban` YEAR DEFAULT NULL,
  `ma_the_loai` SMALLINT UNSIGNED DEFAULT NULL,
  `tong_so_ban` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `so_ban_con` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `vi_tri_ke` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`ma_sach`),
  KEY `fk_sach_the_loai` (`ma_the_loai`),
  KEY `idx_sach_ten` (`ten_sach`),
  KEY `idx_sach_tac_gia` (`tac_gia`),
  CONSTRAINT `ck_sach_so_ban` CHECK (`so_ban_con` <= `tong_so_ban`),
  CONSTRAINT `fk_sach_the_loai` FOREIGN KEY (`ma_the_loai`) REFERENCES `the_loai` (`ma_the_loai`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bảng phieu_muon
-- ------------------------------------------------------------
CREATE TABLE `phieu_muon` (
  `ma_phieu_muon` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ma_doc_gia` INT UNSIGNED NOT NULL,
  `ma_nguoi_dung` INT UNSIGNED NOT NULL,
  `ngay_muon` DATE NOT NULL,
  `han_tra` DATE NOT NULL,
  PRIMARY KEY (`ma_phieu_muon`),
  KEY `fk_pm_doc_gia` (`ma_doc_gia`),
  KEY `fk_pm_nguoi_dung` (`ma_nguoi_dung`),
  KEY `idx_pm_han_tra` (`han_tra`),
  CONSTRAINT `ck_pm_han_tra` CHECK (`han_tra` >= `ngay_muon`),
  CONSTRAINT `fk_pm_doc_gia` FOREIGN KEY (`ma_doc_gia`) REFERENCES `doc_gia` (`ma_doc_gia`) ON UPDATE CASCADE,
  CONSTRAINT `fk_pm_nguoi_dung` FOREIGN KEY (`ma_nguoi_dung`) REFERENCES `nguoi_dung` (`ma_nguoi_dung`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bảng chi_tiet_muon (mỗi dòng = một cuốn sách trong một phiếu)
-- ------------------------------------------------------------
CREATE TABLE `chi_tiet_muon` (
  `ma_phieu_muon` INT UNSIGNED NOT NULL,
  `ma_sach` INT UNSIGNED NOT NULL,
  `ngay_tra` DATE DEFAULT NULL,
  `tien_phat` INT UNSIGNED NOT NULL DEFAULT 0,
  `trang_thai` ENUM('dang_muon','da_tra') NOT NULL DEFAULT 'dang_muon',
  PRIMARY KEY (`ma_phieu_muon`,`ma_sach`),
  KEY `idx_ctm_sach` (`ma_sach`),
  KEY `idx_ctm_trang_thai` (`trang_thai`),
  CONSTRAINT `ck_ctm_trang_thai` CHECK ((`trang_thai` = 'dang_muon' AND `ngay_tra` IS NULL) OR (`trang_thai` = 'da_tra' AND `ngay_tra` IS NOT NULL)),
  CONSTRAINT `fk_ctm_phieu_muon` FOREIGN KEY (`ma_phieu_muon`) REFERENCES `phieu_muon` (`ma_phieu_muon`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ctm_sach` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============ DỮ LIỆU MẪU ============

INSERT INTO `the_loai` (`ma_the_loai`, `ten_the_loai`) VALUES
(1, 'Văn học'),
(2, 'Thiếu nhi'),
(3, 'Công nghệ thông tin'),
(4, 'Khoa học'),
(5, 'Lịch sử'),
(6, 'Kỹ năng sống');

INSERT INTO `nguoi_dung` (`ma_nguoi_dung`, `ten_dang_nhap`, `mat_khau_ma_hoa`, `ho_ten`, `vai_tro`, `trang_thai`) VALUES
(1, 'admin', '$2y$10$yDr/NdU3ONymudzVsDjwteUiaLKgSW9nbFNbAgni9PTu87zULCeZ2', 'Quản trị hệ thống', 'quan_tri', 1),
(2, 'thuthu1', '$2y$10$sRyl/lJbbVaattnv60MT/O2YnZy41XCrsnqlsiaV/DGLFIT5Vw1.6', 'Trần Thị Thủ Thư', 'thu_thu', 1);

INSERT INTO `doc_gia` (`ma_doc_gia`, `ma_the`, `ho_ten`, `so_dien_thoai`, `dia_chi`, `ngay_het_han`, `trang_thai`) VALUES
(1, 'TV2026001', 'Nguyễn Văn An', '0900000003', 'Sơn La', '2027-09-01', 'hoat_dong'),
(2, 'TV2026002', 'Lê Thị Bình', '0900000004', 'Điện Biên', '2027-09-01', 'hoat_dong'),
(3, 'TV2026003', 'Phạm Quốc Cường', '0900000005', 'Lai Châu', '2027-09-05', 'hoat_dong'),
(4, 'TV2026004', 'Trần Minh Đức', '0900000006', 'Hòa Bình', '2027-09-10', 'hoat_dong'),
(5, 'TV2026005', 'Hoàng Thị Em', '0900000007', 'Yên Bái', '2027-09-11', 'hoat_dong'),
(6, 'TV2026006', 'Vũ Thanh Hà', '0900000008', 'Lào Cai', '2027-09-12', 'hoat_dong'),
(7, 'TV2026007', 'Đỗ Quang Huy', '0900000009', 'Mộc Châu, Sơn La', '2027-09-13', 'hoat_dong'),
(8, 'TV2026008', 'Bùi Thị Lan', '0900000010', 'Mai Sơn, Sơn La', '2027-09-14', 'hoat_dong'),
(9, 'TV2026009', 'Ngô Văn Long', '0900000011', 'Sơn La', '2027-09-15', 'hoat_dong'),
(10, 'TV2026010', 'Đặng Thị Mai', '0900000012', 'Điện Biên', '2027-09-16', 'hoat_dong'),
(11, 'TV2026011', 'Lý Văn Nam', '0900000013', 'Lai Châu', '2027-09-17', 'hoat_dong'),
(12, 'TV2026012', 'Phan Thị Oanh', '0900000014', 'Hòa Bình', '2027-09-18', 'hoat_dong'),
(13, 'TV2026013', 'Tòng Văn Phong', '0900000015', 'Yên Bái', '2027-09-19', 'hoat_dong'),
(14, 'TV2026014', 'Lò Thị Quyên', '0900000016', 'Lào Cai', '2027-09-20', 'hoat_dong'),
(15, 'TV2026015', 'Cà Văn Sơn', '0900000017', 'Mộc Châu, Sơn La', '2027-09-21', 'hoat_dong'),
(16, 'TV2026016', 'Hà Thị Thảo', '0900000018', 'Mai Sơn, Sơn La', '2027-09-22', 'hoat_dong'),
(17, 'TV2026017', 'Lường Văn Tùng', '0900000019', 'Sơn La', '2027-09-23', 'hoat_dong'),
(18, 'TV2026018', 'Quàng Thị Uyên', '0900000020', 'Điện Biên', '2027-09-24', 'hoat_dong'),
(19, 'TV2026019', 'Mùa A Vàng', '0900000021', 'Lai Châu', '2027-09-25', 'hoat_dong'),
(20, 'TV2026020', 'Giàng Thị Xuân', '0900000022', 'Hòa Bình', '2027-09-06', 'hoat_dong'),
(21, 'TV2026021', 'Vì Văn Yên', '0900000023', 'Yên Bái', '2027-09-07', 'hoat_dong'),
(22, 'TV2026022', 'Lù Thị Hoa', '0900000024', 'Lào Cai', '2027-09-08', 'hoat_dong'),
(23, 'TV2026023', 'Sồng A Páo', '0900000025', 'Mộc Châu, Sơn La', '2027-09-09', 'hoat_dong'),
(24, 'TV2026024', 'Điêu Thị Hương', '0900000026', 'Mai Sơn, Sơn La', '2027-09-10', 'hoat_dong'),
(25, 'TV2026025', 'Tạ Văn Kiên', '0900000027', 'Sơn La', '2027-09-11', 'hoat_dong'),
(26, 'TV2026026', 'Nguyễn Thị Linh', '0900000028', 'Điện Biên', '2027-09-12', 'hoat_dong'),
(27, 'TV2026027', 'Trần Văn Mạnh', '0900000029', 'Lai Châu', '2027-09-13', 'hoat_dong'),
(28, 'TV2026028', 'Phạm Thị Ngân', '0900000030', 'Hòa Bình', '2027-09-14', 'hoat_dong'),
(29, 'TV2026029', 'Lê Văn Phúc', '0900000031', 'Yên Bái', '2026-09-30', 'hoat_dong'),
(30, 'TV2026030', 'Hoàng Thị Quỳnh', '0900000032', 'Lào Cai', '2027-09-16', 'bi_khoa');

INSERT INTO `sach` (`ma_sach`, `ten_sach`, `tac_gia`, `nam_xuat_ban`, `ma_the_loai`, `tong_so_ban`, `so_ban_con`, `vi_tri_ke`) VALUES
(1, 'Mắt biếc', 'Nguyễn Nhật Ánh', 1990, 1, 3, 3, 'A1-01'),
(2, 'Cho tôi xin một vé đi tuổi thơ', 'Nguyễn Nhật Ánh', 2008, 2, 2, 1, 'B1-01'),
(3, 'Dế Mèn phiêu lưu ký', 'Tô Hoài', 1941, 2, 1, 0, 'B1-02'),
(4, 'Chí Phèo', 'Nam Cao', 1941, 1, 2, 2, 'A1-02'),
(5, 'Cơ sở dữ liệu', 'Nhiều tác giả', 2019, 3, 2, 0, 'C2-01'),
(6, 'Tôi thấy hoa vàng trên cỏ xanh', 'Nguyễn Nhật Ánh', 2010, 1, 3, 3, 'A1-03'),
(7, 'Số đỏ', 'Vũ Trọng Phụng', 1936, 1, 2, 2, 'A1-04'),
(8, 'Tắt đèn', 'Ngô Tất Tố', 1939, 1, 2, 1, 'A1-05'),
(9, 'Lão Hạc', 'Nam Cao', 1943, 1, 2, 1, 'A1-06'),
(10, 'Tuổi thơ dữ dội', 'Phùng Quán', 1988, 2, 2, 2, 'B1-03'),
(11, 'Lập trình ứng dụng web', 'Nguyễn Duy Hiếu, Đặng Thị Vân Chi', 2026, 3, 4, 4, 'C2-02'),
(12, 'Learning PHP, MySQL & JavaScript', 'Robin Nixon', 2021, 3, 3, 3, 'C2-03'),
(13, 'Modern PHP', 'Josh Lockhart', 2015, 3, 2, 2, 'C2-04'),
(14, 'Lược sử thời gian', 'Stephen Hawking', 1988, 4, 2, 2, 'D1-01'),
(15, 'Sapiens: Lược sử loài người', 'Yuval Noah Harari', 2011, 5, 3, 3, 'E1-01'),
(16, 'Việt Nam sử lược', 'Trần Trọng Kim', 1920, 5, 2, 2, 'E1-02'),
(17, 'Đắc nhân tâm', 'Dale Carnegie', 1936, 6, 3, 3, 'F1-01'),
(18, 'Nhà giả kim', 'Paulo Coelho', 1988, 1, 3, 2, 'A2-01'),
(19, 'Cha giàu cha nghèo', 'Robert T. Kiyosaki', 1997, 6, 2, 1, 'F1-02'),
(20, 'Vũ trụ trong vỏ hạt dẻ', 'Stephen Hawking', 2001, 4, 2, 1, 'D1-02');

INSERT INTO `phieu_muon` (`ma_phieu_muon`, `ma_doc_gia`, `ma_nguoi_dung`, `ngay_muon`, `han_tra`) VALUES
(1, 1, 2, '2026-10-20', '2026-11-03'),
(2, 2, 2, '2026-11-05', '2026-11-19'),
(3, 3, 2, '2026-10-28', '2026-11-11'),
(4, 18, 1, '2026-08-15', '2026-08-29'),
(5, 10, 1, '2026-08-17', '2026-08-31'),
(6, 11, 2, '2026-08-19', '2026-09-02'),
(7, 25, 2, '2026-08-21', '2026-09-04'),
(8, 8, 1, '2026-08-23', '2026-09-06'),
(9, 14, 1, '2026-08-25', '2026-09-08'),
(10, 7, 2, '2026-08-27', '2026-09-10'),
(11, 4, 1, '2026-08-29', '2026-09-12'),
(12, 10, 2, '2026-09-01', '2026-09-15'),
(13, 20, 2, '2026-09-03', '2026-09-17'),
(14, 9, 2, '2026-09-05', '2026-09-19'),
(15, 21, 2, '2026-09-07', '2026-09-21'),
(16, 27, 2, '2026-09-09', '2026-09-23'),
(17, 27, 1, '2026-09-11', '2026-09-25'),
(18, 5, 1, '2026-09-13', '2026-09-27'),
(19, 6, 2, '2026-09-15', '2026-09-29'),
(20, 9, 2, '2026-09-18', '2026-10-02'),
(21, 26, 2, '2026-09-20', '2026-10-04'),
(22, 18, 1, '2026-09-22', '2026-10-06'),
(23, 1, 2, '2026-09-24', '2026-10-08'),
(24, 9, 1, '2026-09-26', '2026-10-10'),
(25, 5, 1, '2026-09-28', '2026-10-12'),
(26, 27, 2, '2026-09-30', '2026-10-14'),
(27, 27, 2, '2026-10-03', '2026-10-17'),
(28, 7, 1, '2026-10-05', '2026-10-19'),
(29, 21, 2, '2026-10-07', '2026-10-21'),
(30, 24, 2, '2026-10-09', '2026-10-23'),
(31, 19, 1, '2026-10-11', '2026-10-25'),
(32, 15, 2, '2026-10-13', '2026-10-27'),
(33, 12, 1, '2026-10-15', '2026-10-29'),
(34, 8, 1, '2026-10-17', '2026-10-31'),
(35, 14, 1, '2026-10-20', '2026-11-03'),
(36, 5, 1, '2026-10-22', '2026-11-05'),
(37, 5, 2, '2026-10-24', '2026-11-07'),
(38, 15, 1, '2026-10-26', '2026-11-09'),
(39, 1, 2, '2026-10-28', '2026-11-11'),
(40, 20, 2, '2026-10-30', '2026-11-13'),
(41, 22, 2, '2026-11-01', '2026-11-15'),
(42, 14, 2, '2026-11-03', '2026-11-17'),
(43, 11, 2, '2026-11-06', '2026-11-20'),
(44, 24, 1, '2026-11-08', '2026-11-22'),
(45, 12, 2, '2026-11-10', '2026-11-24'),
(46, 22, 2, '2026-11-12', '2026-11-26'),
(47, 3, 1, '2026-11-14', '2026-11-28'),
(48, 2, 2, '2026-11-16', '2026-11-30'),
(49, 28, 1, '2026-11-18', '2026-12-02'),
(50, 20, 2, '2026-11-21', '2026-12-05');

INSERT INTO `chi_tiet_muon` (`ma_phieu_muon`, `ma_sach`, `ngay_tra`, `tien_phat`, `trang_thai`) VALUES
(1, 1, '2026-11-08', 5000, 'da_tra'),
(2, 2, NULL, 0, 'dang_muon'),
(2, 5, NULL, 0, 'dang_muon'),
(3, 3, NULL, 0, 'dang_muon'),
(4, 17, '2026-09-04', 6000, 'da_tra'),
(5, 8, '2026-08-22', 0, 'da_tra'),
(5, 20, '2026-08-24', 0, 'da_tra'),
(6, 9, '2026-08-29', 0, 'da_tra'),
(7, 1, '2026-09-11', 7000, 'da_tra'),
(7, 14, '2026-08-24', 0, 'da_tra'),
(8, 18, '2026-09-11', 5000, 'da_tra'),
(8, 19, '2026-09-02', 0, 'da_tra'),
(9, 16, '2026-09-15', 7000, 'da_tra'),
(10, 14, '2026-09-06', 0, 'da_tra'),
(11, 2, '2026-09-13', 1000, 'da_tra'),
(12, 12, '2026-09-15', 0, 'da_tra'),
(13, 7, '2026-09-23', 6000, 'da_tra'),
(13, 9, '2026-09-24', 7000, 'da_tra'),
(14, 6, '2026-09-27', 8000, 'da_tra'),
(14, 20, '2026-09-19', 0, 'da_tra'),
(15, 5, '2026-09-26', 5000, 'da_tra'),
(15, 6, '2026-09-11', 0, 'da_tra'),
(16, 15, '2026-09-25', 2000, 'da_tra'),
(17, 13, '2026-09-17', 0, 'da_tra'),
(18, 12, '2026-09-18', 0, 'da_tra'),
(19, 2, '2026-10-03', 4000, 'da_tra'),
(20, 5, '2026-10-04', 2000, 'da_tra'),
(21, 14, '2026-10-03', 0, 'da_tra'),
(22, 10, '2026-09-28', 0, 'da_tra'),
(23, 8, '2026-10-15', 7000, 'da_tra'),
(23, 19, '2026-09-29', 0, 'da_tra'),
(24, 19, '2026-10-11', 1000, 'da_tra'),
(25, 17, '2026-10-14', 2000, 'da_tra'),
(26, 2, '2026-10-18', 4000, 'da_tra'),
(27, 5, '2026-10-09', 0, 'da_tra'),
(28, 2, '2026-10-18', 0, 'da_tra'),
(28, 8, '2026-10-15', 0, 'da_tra'),
(29, 13, '2026-10-20', 0, 'da_tra'),
(30, 13, '2026-10-27', 4000, 'da_tra'),
(30, 20, '2026-10-14', 0, 'da_tra'),
(31, 13, '2026-10-22', 0, 'da_tra'),
(32, 4, '2026-10-17', 0, 'da_tra'),
(32, 10, '2026-10-20', 0, 'da_tra'),
(33, 2, '2026-10-26', 0, 'da_tra'),
(34, 18, '2026-11-07', 7000, 'da_tra'),
(35, 9, '2026-11-04', 1000, 'da_tra'),
(36, 4, '2026-11-03', 0, 'da_tra'),
(36, 11, '2026-10-26', 0, 'da_tra'),
(37, 18, '2026-11-03', 0, 'da_tra'),
(38, 7, '2026-11-04', 0, 'da_tra'),
(39, 9, '2026-11-05', 0, 'da_tra'),
(40, 11, '2026-11-11', 0, 'da_tra'),
(41, 5, '2026-11-18', 3000, 'da_tra'),
(41, 6, '2026-11-10', 0, 'da_tra'),
(42, 4, '2026-11-17', 0, 'da_tra'),
(43, 4, '2026-11-23', 3000, 'da_tra'),
(44, 20, '2026-11-23', 1000, 'da_tra'),
(45, 11, '2026-11-23', 0, 'da_tra'),
(46, 19, NULL, 0, 'dang_muon'),
(46, 20, NULL, 0, 'dang_muon'),
(47, 5, NULL, 0, 'dang_muon'),
(48, 9, NULL, 0, 'dang_muon'),
(49, 8, NULL, 0, 'dang_muon'),
(50, 18, NULL, 0, 'dang_muon');

SET FOREIGN_KEY_CHECKS = 1;
