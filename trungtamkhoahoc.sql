-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 08:11 PM
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
-- Database: `trungtamkhoahoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `cahoc`
--

CREATE TABLE `cahoc` (
  `ID_CaHoc` int(11) NOT NULL,
  `Ten_CaHoc` text NOT NULL,
  `Gio_BD` text NOT NULL,
  `Gio_KT` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cahoc`
--

INSERT INTO `cahoc` (`ID_CaHoc`, `Ten_CaHoc`, `Gio_BD`, `Gio_KT`) VALUES
(1, 'Ca 1', '7:00', '9:00'),
(2, 'Ca 2', '9:30', '11:30'),
(3, 'Ca 3', '13:00', '15:00'),
(4, 'Ca 4', '15:30', '17:30'),
(6, 'Ca 5', '18:15', '19:30'),
(7, 'Ca 6', '20:00', '21:00');

-- --------------------------------------------------------

--
-- Table structure for table `dangky`
--

CREATE TABLE `dangky` (
  `ID_DangKy` int(11) NOT NULL,
  `ID_HocVien` int(11) NOT NULL,
  `ID_LopHoc` int(11) NOT NULL,
  `NgayDK` text NOT NULL,
  `TrangThai_DK` text NOT NULL DEFAULT 'Chờ xác nhận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dangky`
--

INSERT INTO `dangky` (`ID_DangKy`, `ID_HocVien`, `ID_LopHoc`, `NgayDK`, `TrangThai_DK`) VALUES
(2, 11, 1, '2024-12-20', 'Đã sắp lớp'),
(3, 11, 1, '2024-12-20', 'Đã sắp lớp'),
(4, 17, 1, '2024-12-20', 'Đã sắp lớp'),
(5, 16, 1, '2024-12-20', 'Đã sắp lớp'),
(6, 39, 1, '2024-12-20', 'Đã sắp lớp'),
(7, 18, 1, '2024-12-20', 'Đã sắp lớp'),
(8, 49, 1, '2024-12-20', 'Đã sắp lớp'),
(9, 47, 1, '2024-12-20', 'Đã sắp lớp'),
(10, 80, 1, '2024-12-20', 'Đã sắp lớp'),
(11, 51, 1, '2024-12-19', 'Đã sắp lớp'),
(12, 52, 1, '2024-12-18', 'Chờ xác nhận'),
(13, 53, 1, '2024-12-07', 'Chờ xác nhận'),
(14, 53, 1, '2024-12-07', 'Chờ xác nhận'),
(15, 79, 1, '2024-12-20', 'Đã sắp lớp'),
(16, 36, 2, '2024-12-20', 'Đã sắp lớp'),
(17, 49, 2, '2024-12-20', 'Đã sắp lớp'),
(18, 80, 1, '2024-12-21', 'Chờ xác nhận'),
(19, 17, 6, '2024-12-21', 'Đã sắp lớp');

-- --------------------------------------------------------

--
-- Table structure for table `dangkythi`
--

CREATE TABLE `dangkythi` (
  `ID_DKThi` int(11) NOT NULL,
  `ID_LopHoc` int(11) NOT NULL,
  `ID_CaHoc` int(11) NOT NULL,
  `NgayDK_Thi` text NOT NULL,
  `Phong` text NOT NULL,
  `TrangThai_DKThi` text NOT NULL DEFAULT 'Đang thi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dangkythi`
--

INSERT INTO `dangkythi` (`ID_DKThi`, `ID_LopHoc`, `ID_CaHoc`, `NgayDK_Thi`, `Phong`, `TrangThai_DKThi`) VALUES
(1, 2, 1, '2024-12-22', 'I3-01', 'Thi xong'),
(2, 2, 2, '2024-12-24', 'I5-01', 'Thi xong'),
(3, 2, 3, '2024-12-28', 'I4-06', 'Thi xong'),
(4, 2, 4, '2024-12-06', 'I4-06', 'Thi xong'),
(5, 2, 6, '2024-12-23', 'I3-03', 'Thi xong'),
(6, 2, 7, '2025-01-03', 'I4-05', 'Thi xong');

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc_khoahoc`
--

CREATE TABLE `danhmuc_khoahoc` (
  `ID_DanhMuc` int(11) NOT NULL,
  `TenDM` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danhmuc_khoahoc`
--

INSERT INTO `danhmuc_khoahoc` (`ID_DanhMuc`, `TenDM`) VALUES
(1, 'Công Nghệ Thông Tin'),
(2, 'Anh Văn'),
(3, 'Kỹ Năng Mềm'),
(4, 'Tin Học Văn Phòng'),
(8, 'Luyện Thi'),
(9, 'Anh Văn Chuyên Ngành');

-- --------------------------------------------------------

--
-- Table structure for table `diemdanh`
--

CREATE TABLE `diemdanh` (
  `ID_DiemDanh` int(11) NOT NULL,
  `ID_LichHoc` int(11) NOT NULL,
  `ID_HocVien` int(11) NOT NULL,
  `TrangThai_DD` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diemdanh`
--

INSERT INTO `diemdanh` (`ID_DiemDanh`, `ID_LichHoc`, `ID_HocVien`, `TrangThai_DD`) VALUES
(1, 10, 36, 'Có mặt'),
(2, 10, 49, 'Có mặt');

-- --------------------------------------------------------

--
-- Table structure for table `diemthi`
--

CREATE TABLE `diemthi` (
  `ID_DiemThi` int(11) NOT NULL,
  `ID_DKThi` int(11) NOT NULL,
  `ID_HocVien` int(11) NOT NULL,
  `Cot1` float DEFAULT NULL,
  `Cot2` float DEFAULT NULL,
  `Cot3` float DEFAULT NULL,
  `Cot4` float DEFAULT NULL,
  `Cot5` float DEFAULT NULL,
  `Cot6` float DEFAULT NULL,
  `Diem_TB` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diemthi`
--

INSERT INTO `diemthi` (`ID_DiemThi`, `ID_DKThi`, `ID_HocVien`, `Cot1`, `Cot2`, `Cot3`, `Cot4`, `Cot5`, `Cot6`, `Diem_TB`) VALUES
(3, 2, 36, 5.7, 4.1, 9.5, 9.4, 7.9, 7.7, 7.38333),
(4, 2, 49, 7, 8, 10, 7.8, 8, 6.75, 7.925);

-- --------------------------------------------------------

--
-- Table structure for table `giangvien`
--

CREATE TABLE `giangvien` (
  `ID_GiangVien` int(11) NOT NULL,
  `TenGV` text NOT NULL,
  `AnhGV` text NOT NULL,
  `GioiTinh` text NOT NULL,
  `Email` text NOT NULL,
  `SDT` varchar(10) NOT NULL,
  `NgaySinh` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `giangvien`
--

INSERT INTO `giangvien` (`ID_GiangVien`, `TenGV`, `AnhGV`, `GioiTinh`, `Email`, `SDT`, `NgaySinh`) VALUES
(1, 'Huỳnh Võ Hữu Trí', '1.png', 'Nam', 'vhhtri@gmail.com', '0789456333', '2000-11-11'),
(2, 'Bùi Thị Diễm Trinh', '2.png', 'Nữ', 'btdtrinh@gmail.com', '0896754231', '2000-11-11'),
(3, 'Trương Hùng Chen', '3.png', 'Nam', 'thchen@gmail.com', '0896754231', '2000-11-11'),
(4, 'Đoàn Hòa Minh', '4.png', 'Nam', 'dhminh@gmail.com', '0378438473', '2000-11-11'),
(5, 'Phạm Thị Xuân Trang', '5.png', 'Nữ', 'ptxtrang@gmail.com', '0987645312', '2000-11-11'),
(6, 'Trương Quốc Bảo', '6.png', 'Nam', 'tqbao@gmail.com', '0378438473', '2003-11-11'),
(7, 'Nguyễn Hoàng Phương', '7.png', 'Nam', 'nhphuong@gmail.com', '0987654321', '2000-11-11'),
(8, ' Đào Anh Pha', '8.png', 'Nam', 'dapha@gmail.com', '0987654321', '2000-11-11'),
(9, 'Đinh Thành Nhân', '9.png', 'Nam', 'dtnhan@gmail.com', '0891247777', '2000-11-11'),
(10, 'Võ Văn Phúc', '10.png', 'Nam', 'vvphuc@gmail.com', '0896754231', '2000-11-11');

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `ID_HoaDon` int(11) NOT NULL,
  `ID_TaiKhoan` int(11) NOT NULL,
  `ID_LopHoc` int(11) NOT NULL,
  `TongTien` int(50) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`ID_HoaDon`, `ID_TaiKhoan`, `ID_LopHoc`, `TongTien`) VALUES
(3, 8, 6, 2450000);

-- --------------------------------------------------------

--
-- Table structure for table `hocvien`
--

CREATE TABLE `hocvien` (
  `ID_HocVien` int(11) NOT NULL,
  `TenHV` text NOT NULL,
  `AnhHV` text NOT NULL,
  `GioiTinh` text NOT NULL,
  `Email` text NOT NULL,
  `SDT` varchar(10) NOT NULL,
  `NgaySinh` varchar(50) NOT NULL,
  `TrangThai_HV` text NOT NULL DEFAULT 'Đang học'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hocvien`
--

INSERT INTO `hocvien` (`ID_HocVien`, `TenHV`, `AnhHV`, `GioiTinh`, `Email`, `SDT`, `NgaySinh`, `TrangThai_HV`) VALUES
(1, 'Dương Thế Ngọc', '1.png', 'Nam', 'duongthengoc01112003@gmail.com', '0378438473', '2003-01-11', 'Đã nghỉ học'),
(4, 'Nguyễn Quốc Huy', '4.png', 'Nam', 'quochuy@gmail.com', '0896754231', '2003-04-11', 'Đã nghỉ học'),
(9, 'Lê Trọng Nhân', '9.png', 'Nam', 'trongnhan@gmail.com', '0546372819', '2003-01-12', 'Đã nghỉ học'),
(11, 'Nguyễn Huỳnh Hữu Lợi', '11.png', 'Nữ', 'thangloi@gmail.com', '0378438473', '2003-10-11', 'Đang học'),
(13, 'Lê Thành Đạt', '13.png', 'Nam', 'ltdat@gmail.com', '0942777326', '2002-11-01', 'Đang học'),
(15, 'Lê Hoàng Em', '15.png', 'Nữ', 'hoangem@gmail.com', '0789456333', '2003-12-12', 'Đang học'),
(16, 'Lê Hoàng Khang', '16.png', 'Nữ', 'hoangkhang@gmail.com', '0987645312', '2003-02-11', 'Đang học'),
(17, 'ngọc', '17.png', 'Nữ', 'admin@gmail.com', '0896754231', '2003-01-11', 'Đang học'),
(18, 'Lê Triệu Vỹ', '18.png', 'Nữ', 'trieuvy@gmail.com', '0987126418', '2003-12-11', 'Đang học'),
(35, 'Nguyễn Văn A', '35.png', 'Nữ', 'dp@gmail.com', '0896754321', '2000-12-01', 'Đã nghỉ học'),
(36, 'Trần Thị B', '36.png', 'Nam', 'em@gmail.com', '0789456333', '2003-12-12', 'Đang học'),
(37, 'Lê Minh C', '37.png', 'Nam', 'huy@gmail.com', '0896754231', '2003-04-11', 'Đã nghỉ học'),
(39, 'Lý Thị D', '38.png', 'Nữ', 'lythiD@gmail.com', '0998887771', '2003-12-15', 'Đang học'),
(46, 'lê hoàng khang', '46.png', 'Nam', 'lehoangkhang12et4@gmail.com', '0378438473', '2003-02-11', 'Đang học'),
(47, 'thế ngọc', '47.png', 'Nam', 'dtcogn@gmail.com', '0378438473', '2003-01-11', 'Đang học'),
(48, 'Trần Quang Sang', '48.png', 'Nữ', 'tranquangsang01511.pq@gmail.com', '0789456333', '2003-12-11', 'Đang học'),
(49, 'Đạt', '49.png', 'Nữ', 'dat@gmail.com', '0789456333', '2002-12-22', 'Đang học'),
(51, 'Trần Thị Bình', '#VALUE!', 'Nữ', 'ttb@gmail.com', '0789456333', '12/12/2001', 'Đang học'),
(52, 'Lê Minh Cảnh', '#VALUE!', 'Nam', 'lmc@gmail.com', '0896754231', '10/1/2000', 'Đang học'),
(53, 'Nguyễn Văn Dân', '#VALUE!', 'Nam', 'nvd@gmail.com', '0896754321', '9/5/1999', 'Đang học'),
(54, 'Trần Thị Em', '#VALUE!', 'Nữ', 'tte@gmail.com', '0789456333', '12/12/2003', 'Đang học'),
(55, 'Lê Minh Hiền', '#VALUE!', 'Nam', 'lmh@gmail.com', '0896754231', '1/11/2003', 'Đang học'),
(56, 'Phạm Quang Trí', '56.png', 'Nam', 'pqt@gmail.com', '0378438473', '2003-11-11', 'Đang học'),
(57, 'Nguyễn Đức Trí', '57.png', 'Nữ', 'ndt@gmail.com', '0789456333', '2003-11-11', 'Đang học'),
(59, 'Trần Thị Bình', '#VALUE!', 'Nữ', 'ttb@gmail.com', '0789456333', '12/12/2001', 'Đang học'),
(60, 'Lê Minh Cảnh', '#VALUE!', 'Nam', 'lmc@gmail.com', '0896754231', '10/1/2000', 'Đang học'),
(61, 'Nguyễn Văn Dân', '#VALUE!', 'Nam', 'nvd@gmail.com', '0896754321', '9/5/1999', 'Đang học'),
(62, 'Trần Thị Em', '#VALUE!', 'Nữ', 'tte@gmail.com', '0789456333', '12/12/2003', 'Đang học'),
(63, 'Lê Minh Hiền', '#VALUE!', 'Nam', 'lmh@gmail.com', '0896754231', '1/11/2003', 'Đang học'),
(65, 'Nguyễn Đức Trí', '#VALUE!', 'Nam', 'ndt@gmail.com', '', '11/11/2003', 'Đang học'),
(66, 'Nguyễn Văn An', '#VALUE!', 'Nam', 'nvav@gmail.com', '0896754321', '12/1/2002', 'Đang học'),
(67, 'Trần Thị Bình', '#VALUE!', 'Nữ', 'ttb@gmail.com', '0789456333', '12/12/2001', 'Đang học'),
(68, 'Lê Minh Cảnh', '#VALUE!', 'Nam', 'lmc@gmail.com', '0896754231', '10/1/2000', 'Đang học'),
(69, 'Nguyễn Văn Dân', '#VALUE!', 'Nam', 'nvd@gmail.com', '0896754321', '9/5/1999', 'Đang học'),
(70, 'Trần Thị Em', '#VALUE!', 'Nữ', 'tte@gmail.com', '0789456333', '12/12/2003', 'Đang học'),
(71, 'Lê Minh Hiền', '#VALUE!', 'Nam', 'lmh@gmail.com', '0896754231', '1/11/2003', 'Đang học'),
(72, 'Phạm Quang Trí', '#VALUE!', 'Nam', 'pqt@gmail.com', '', '11/11/2003', 'Đang học'),
(73, 'Nguyễn Đức Trí', '#VALUE!', 'Nam', 'ndt@gmail.com', '', '11/11/2003', 'Đang học'),
(74, 'Nguyễn Văn An', '#VALUE!', 'Nam', 'nvav@gmail.com', '0896754321', '12/1/2002', 'Đang học'),
(75, 'Trần Thị Bình', '#VALUE!', 'Nữ', 'ttb@gmail.com', '0789456333', '12/12/2001', 'Đang học'),
(76, 'Lê Minh Cảnh', '#VALUE!', 'Nam', 'lmc@gmail.com', '0896754231', '10/1/2000', 'Đang học'),
(77, 'Nguyễn Văn Dân', '#VALUE!', 'Nam', 'nvd@gmail.com', '0896754321', '9/5/1999', 'Đang học'),
(78, 'Trần Thị Em', '#VALUE!', 'Nữ', 'tte@gmail.com', '0789456333', '12/12/2003', 'Đang học'),
(79, 'Lê Minh Hiền', '#VALUE!', 'Nam', 'lmh@gmail.com', '0896754231', '1/11/2003', 'Đang học'),
(80, 'Phạm Quang Trí', '#VALUE!', 'Nam', 'pqt@gmail.com', '', '11/11/2003', 'Đang học'),
(81, 'Nguyễn Đức Trí', '#VALUE!', 'Nam', 'ndt@gmail.com', '', '11/11/2003', 'Đang học');

-- --------------------------------------------------------

--
-- Table structure for table `hocvien_lophoc`
--

CREATE TABLE `hocvien_lophoc` (
  `ID_LopHoc` int(11) NOT NULL,
  `ID_HocVien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hocvien_lophoc`
--

INSERT INTO `hocvien_lophoc` (`ID_LopHoc`, `ID_HocVien`) VALUES
(1, 11),
(1, 16),
(1, 17),
(1, 18),
(1, 39),
(1, 47),
(1, 49),
(1, 51),
(1, 79),
(1, 80),
(2, 36),
(2, 49),
(6, 17);

-- --------------------------------------------------------

--
-- Table structure for table `khoahoc`
--

CREATE TABLE `khoahoc` (
  `ID_KhoaHoc` int(11) NOT NULL,
  `ID_DanhMuc` int(11) NOT NULL,
  `TenKH` text NOT NULL,
  `AnhKH` text NOT NULL,
  `MoTa` text NOT NULL,
  `HocPhi` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khoahoc`
--

INSERT INTO `khoahoc` (`ID_KhoaHoc`, `ID_DanhMuc`, `TenKH`, `AnhKH`, `MoTa`, `HocPhi`) VALUES
(3, 3, 'Kỹ năng thuyết trình', '3.png', 'NOT', 700000),
(4, 1, 'Lập trình Python', '4.png', 'Lập trình Python thông qua đồ án thực tế.', 3375000),
(5, 1, 'Lập trình Thiết bị di động', '5.png', 'Phát triển ứng dụng trên điện thoại Android.', 2000000),
(6, 1, 'Lập trình PHP Cơ bản', '6.jpg', 'NOT', 5000000),
(7, 1, 'Lập trình GAME', '7.png', 'Lập trình Game bằng nền tảng Unity.', 2000000),
(8, 1, 'Lập trình Python Cơ Bản', '8.png', 'Học ngôn ngữ Python cơ bản cho người mới.', 2450000),
(9, 2, 'Học Phát Âm ', '9.png', 'Học và rèn luyện cách phát âm Tiếng anh.', 2000000),
(10, 2, 'Tiếng Anh Chuyên Ngành IT', '10.png', 'NOT', 2450000),
(11, 2, 'Anh Văn Nâng Cao', '11.png', 'NOT', 3375000),
(12, 4, 'PowerPoint', '12.png', 'NOT', 1500000),
(13, 4, 'EXCEL', '13.png', 'NOT', 1500000),
(14, 4, 'WORD', '14.png', 'NOT', 1500000),
(15, 3, 'Kỹ năng văn phòng ABC', '15.png', 'NOT', 1500000),
(16, 1, 'JAVA', '16.png', 'NOT', 3375000),
(17, 1, 'Lập trình OOP C++', '17.png', 'Thực hành các kỹ năng lập trình liên quan đến OOP', 2450000),
(19, 3, 'Kỹ năng đàm phán', '18.jpg', 'NOT', 1500000),
(20, 8, 'Luyện thi Chứng chỉ MOS Word 2016', '20.png', 'NOT', 3375000),
(21, 8, 'Luyện thi Chứng chỉ MOS Excel 2016', '21.jpg', 'NOT', 3375000),
(22, 8, 'TOEIC', '22.jpg', 'NOT', 4450000),
(23, 8, 'IELTS', '23.jpg', 'NOT', 6375000),
(24, 3, 'Kỹ năng phỏng vấn', '24.png', 'NOT', 1500000),
(25, 3, 'Kỹ năng lãnh đạo', '25.jpg', 'NOT', 1500000),
(26, 9, 'Anh văn 1', '26.jpg', 'NOT', 3375000);

-- --------------------------------------------------------

--
-- Table structure for table `lichhoc`
--

CREATE TABLE `lichhoc` (
  `ID_LichHoc` int(11) NOT NULL,
  `ID_CaHoc` int(11) NOT NULL,
  `ID_LopHoc` int(11) NOT NULL,
  `NgayHoc` text NOT NULL,
  `Phong` text NOT NULL,
  `TrangThai_Lich` text NOT NULL DEFAULT 'Đang học'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lichhoc`
--

INSERT INTO `lichhoc` (`ID_LichHoc`, `ID_CaHoc`, `ID_LopHoc`, `NgayHoc`, `Phong`, `TrangThai_Lich`) VALUES
(1, 1, 1, '2024-12-23', 'I3-01', 'Đang học'),
(2, 2, 1, '2024-12-24', 'I3-02', 'Đang học'),
(3, 3, 1, '2024-12-24', 'I3-02', 'Đang học'),
(4, 1, 1, '2024-12-30', 'I3-01', 'Đang học'),
(5, 1, 1, '2025-01-06', 'I3-01', 'Đang học'),
(6, 2, 1, '2024-12-31', 'I3-02', 'Đang học'),
(7, 2, 1, '2025-01-07', 'I3-02', 'Đang học'),
(8, 3, 1, '2024-12-31', 'I3-02', 'Đang học'),
(9, 3, 1, '2025-01-07', 'I3-02', 'Đang học'),
(10, 1, 2, '2024-12-23', 'I5-01', 'Đã điểm danh');

-- --------------------------------------------------------

--
-- Table structure for table `lophoc`
--

CREATE TABLE `lophoc` (
  `ID_LopHoc` int(11) NOT NULL,
  `TenLop` text NOT NULL,
  `ID_KhoaHoc` int(11) NOT NULL,
  `ID_GiangVien` int(11) NOT NULL,
  `SoLuong_HV` int(11) NOT NULL,
  `TrangThai_Lop` text NOT NULL DEFAULT 'Đang học'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lophoc`
--

INSERT INTO `lophoc` (`ID_LopHoc`, `TenLop`, `ID_KhoaHoc`, `ID_GiangVien`, `SoLuong_HV`, `TrangThai_Lop`) VALUES
(1, 'DH21TIN01', 26, 1, 10, 'Đang học'),
(2, 'DH21TIN02', 9, 2, 2, 'Học xong'),
(6, 'DH21TIN03', 17, 8, 1, 'Đang học');

-- --------------------------------------------------------

--
-- Table structure for table `noidung_khoahoc`
--

CREATE TABLE `noidung_khoahoc` (
  `ID_NoiDung` int(11) NOT NULL,
  `ID_KhoaHoc` int(11) NOT NULL,
  `TenND` text NOT NULL,
  `TaiLieu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `noidung_khoahoc`
--

INSERT INTO `noidung_khoahoc` (`ID_NoiDung`, `ID_KhoaHoc`, `TenND`, `TaiLieu`) VALUES
(22, 4, 'Bài 1: Tìm hiểu lý thuyết.', '1.txt'),
(23, 4, 'Bài 2: Cài đặt các môi trường và các Extension.', '1.txt'),
(24, 4, 'Bài 3: Định hướng và phát triển đề tài cá nhân.', '1.txt'),
(25, 4, 'Bài 4: Thực hành các câu lệnh.', '1.txt'),
(26, 4, 'Bài 5: Thực hành các câu lệnh(2).', '1.txt'),
(27, 4, 'Bài 6: Thực hành các thuật toán.', '1.txt'),
(28, 4, 'Bài 7: Phân tích và thiết kế CSDL.', '1.txt'),
(29, 4, 'Bài 8: Thực hành đề tài cá nhân(1).', '1.txt'),
(30, 4, 'Bài 9: Thực hành đề tài cá nhân(2).', '1.txt'),
(31, 4, 'Bài 10: Tổng kết, chấm điểm và đưa lời khuyên.', '1.txt');

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `ID_TaiKhoan` int(11) NOT NULL,
  `Ten_TK` text NOT NULL,
  `Email` text NOT NULL,
  `MatKhau` text NOT NULL,
  `Role` text NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`ID_TaiKhoan`, `Ten_TK`, `Email`, `MatKhau`, `Role`) VALUES
(3, 'Dương Thế Ngọc', 'duongthengoc01112003@gmail.com', '$2y$10$DFrxzSrX2C/FkNEHjeXamejlocmhFeCFiKvWX5Nl6I3.Yjd.MSALC', 'user'),
(4, 'user', 'user@gmail.com', '$2y$10$dth47yF8NfIVBSs1.tpdnOvQ2DzUis5v9CKCv4j5gMnrgS1CSXFne', 'user'),
(5, 'Nhân Viên 1', 'nv1@gmail.com', '$2y$10$Wjh1g05YawYmx.GcJhdXZecYany4.7lhcDEVEn3E3wLVW7kXumDWu', 'user'),
(6, 'Nhân Viên 2', 'nv2@gmail.com', '$2y$10$/Qp93ODpACMLmk/Wh4PZsuf/VuSRHSVlFn95c2cavO3Ii8zzM4phi', 'user'),
(7, 'Nhân Viên 3', 'nv3@gmail.com', '$2y$10$A.9UYfwNYy9j3eMAi.uX/OGV2uYvq.3haNU4USy82f0z2Wx/nSiwC', 'user'),
(8, 'ADMIN', 'admin@gmail.com', '$2y$10$JcDlCcJQp/L0CXur2/OuK.elJmEhZfk4TN69DOZFrvneploskG4li', 'admin'),
(9, 'Thế Ngọc', 'dtn@gmail.com', '$2y$10$gR8nq6PfFYLg9FtiwcltDepSGhJWNJ2H9iOeRg4uMX4UbQGBwj7JW', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cahoc`
--
ALTER TABLE `cahoc`
  ADD PRIMARY KEY (`ID_CaHoc`);

--
-- Indexes for table `dangky`
--
ALTER TABLE `dangky`
  ADD PRIMARY KEY (`ID_DangKy`),
  ADD KEY `ID_HocVien` (`ID_HocVien`) USING BTREE,
  ADD KEY `ID_LopHoc` (`ID_LopHoc`);

--
-- Indexes for table `dangkythi`
--
ALTER TABLE `dangkythi`
  ADD PRIMARY KEY (`ID_DKThi`),
  ADD KEY `ID_LopHoc` (`ID_LopHoc`),
  ADD KEY `ID_CaHoc` (`ID_CaHoc`);

--
-- Indexes for table `danhmuc_khoahoc`
--
ALTER TABLE `danhmuc_khoahoc`
  ADD PRIMARY KEY (`ID_DanhMuc`);

--
-- Indexes for table `diemdanh`
--
ALTER TABLE `diemdanh`
  ADD PRIMARY KEY (`ID_DiemDanh`),
  ADD KEY `ID_LichHoc` (`ID_LichHoc`,`ID_HocVien`);

--
-- Indexes for table `diemthi`
--
ALTER TABLE `diemthi`
  ADD PRIMARY KEY (`ID_DiemThi`),
  ADD KEY `ID_DKThi` (`ID_DKThi`),
  ADD KEY `ID_HocVien` (`ID_HocVien`);

--
-- Indexes for table `giangvien`
--
ALTER TABLE `giangvien`
  ADD PRIMARY KEY (`ID_GiangVien`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`ID_HoaDon`),
  ADD KEY `ID_TaiKhoan` (`ID_TaiKhoan`) USING BTREE,
  ADD KEY `hoadon_ibfk_2` (`ID_LopHoc`);

--
-- Indexes for table `hocvien`
--
ALTER TABLE `hocvien`
  ADD PRIMARY KEY (`ID_HocVien`);

--
-- Indexes for table `hocvien_lophoc`
--
ALTER TABLE `hocvien_lophoc`
  ADD PRIMARY KEY (`ID_LopHoc`,`ID_HocVien`),
  ADD KEY `ID_LopHoc` (`ID_LopHoc`,`ID_HocVien`),
  ADD KEY `ID_HocVien` (`ID_HocVien`);

--
-- Indexes for table `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD PRIMARY KEY (`ID_KhoaHoc`),
  ADD KEY `ID_DanhMuc` (`ID_DanhMuc`);

--
-- Indexes for table `lichhoc`
--
ALTER TABLE `lichhoc`
  ADD PRIMARY KEY (`ID_LichHoc`),
  ADD KEY `ID_CaHoc` (`ID_CaHoc`),
  ADD KEY `ID_LopHoc` (`ID_LopHoc`);

--
-- Indexes for table `lophoc`
--
ALTER TABLE `lophoc`
  ADD PRIMARY KEY (`ID_LopHoc`),
  ADD KEY `ID_GiangVien` (`ID_GiangVien`),
  ADD KEY `ID_KhoaHoc` (`ID_KhoaHoc`) USING BTREE;

--
-- Indexes for table `noidung_khoahoc`
--
ALTER TABLE `noidung_khoahoc`
  ADD PRIMARY KEY (`ID_NoiDung`),
  ADD KEY `ID_KhoaHoc` (`ID_KhoaHoc`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`ID_TaiKhoan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cahoc`
--
ALTER TABLE `cahoc`
  MODIFY `ID_CaHoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dangky`
--
ALTER TABLE `dangky`
  MODIFY `ID_DangKy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dangkythi`
--
ALTER TABLE `dangkythi`
  MODIFY `ID_DKThi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `danhmuc_khoahoc`
--
ALTER TABLE `danhmuc_khoahoc`
  MODIFY `ID_DanhMuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `diemdanh`
--
ALTER TABLE `diemdanh`
  MODIFY `ID_DiemDanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `diemthi`
--
ALTER TABLE `diemthi`
  MODIFY `ID_DiemThi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `giangvien`
--
ALTER TABLE `giangvien`
  MODIFY `ID_GiangVien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `ID_HoaDon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hocvien`
--
ALTER TABLE `hocvien`
  MODIFY `ID_HocVien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `ID_KhoaHoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `lichhoc`
--
ALTER TABLE `lichhoc`
  MODIFY `ID_LichHoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lophoc`
--
ALTER TABLE `lophoc`
  MODIFY `ID_LopHoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `noidung_khoahoc`
--
ALTER TABLE `noidung_khoahoc`
  MODIFY `ID_NoiDung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `ID_TaiKhoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dangky`
--
ALTER TABLE `dangky`
  ADD CONSTRAINT `dangky_ibfk_1` FOREIGN KEY (`ID_HocVien`) REFERENCES `hocvien` (`ID_HocVien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dangky_ibfk_2` FOREIGN KEY (`ID_LopHoc`) REFERENCES `lophoc` (`ID_LopHoc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diemthi`
--
ALTER TABLE `diemthi`
  ADD CONSTRAINT `diemthi_ibfk_2` FOREIGN KEY (`ID_HocVien`) REFERENCES `hocvien` (`ID_HocVien`) ON DELETE CASCADE;

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`ID_LopHoc`) REFERENCES `lophoc` (`ID_LopHoc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hocvien_lophoc`
--
ALTER TABLE `hocvien_lophoc`
  ADD CONSTRAINT `hocvien_lophoc_ibfk_1` FOREIGN KEY (`ID_HocVien`) REFERENCES `hocvien` (`ID_HocVien`);

--
-- Constraints for table `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD CONSTRAINT `khoahoc_ibfk_1` FOREIGN KEY (`ID_DanhMuc`) REFERENCES `danhmuc_khoahoc` (`ID_DanhMuc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lichhoc`
--
ALTER TABLE `lichhoc`
  ADD CONSTRAINT `lichhoc_ibfk_2` FOREIGN KEY (`ID_CaHoc`) REFERENCES `cahoc` (`ID_CaHoc`);

--
-- Constraints for table `lophoc`
--
ALTER TABLE `lophoc`
  ADD CONSTRAINT `lophoc_ibfk_1` FOREIGN KEY (`ID_GiangVien`) REFERENCES `giangvien` (`ID_GiangVien`),
  ADD CONSTRAINT `lophoc_ibfk_2` FOREIGN KEY (`ID_KhoaHoc`) REFERENCES `khoahoc` (`ID_KhoaHoc`);

--
-- Constraints for table `noidung_khoahoc`
--
ALTER TABLE `noidung_khoahoc`
  ADD CONSTRAINT `noidung_khoahoc_ibfk_1` FOREIGN KEY (`ID_KhoaHoc`) REFERENCES `khoahoc` (`ID_KhoaHoc`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
