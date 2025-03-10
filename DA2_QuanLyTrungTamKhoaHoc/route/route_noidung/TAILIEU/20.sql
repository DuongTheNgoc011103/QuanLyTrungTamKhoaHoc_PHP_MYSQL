USE [master]
GO
/****** Object:  Database [QuanLyQuanNET]    Script Date: 6/4/2024 10:04:04 PM ******/
CREATE DATABASE [QuanLyQuanNET]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'QuanLyQuanNET', FILENAME = N'D:\DA1_NET\SQL\QuanLyQuanNET.mdf' , SIZE = 3136KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'QuanLyQuanNET_log', FILENAME = N'D:\DA1_NET\SQL\QuanLyQuanNET_log.ldf' , SIZE = 784KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [QuanLyQuanNET] SET COMPATIBILITY_LEVEL = 110
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [QuanLyQuanNET].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [QuanLyQuanNET] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET ARITHABORT OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET AUTO_CLOSE ON 
GO
ALTER DATABASE [QuanLyQuanNET] SET AUTO_CREATE_STATISTICS ON 
GO
ALTER DATABASE [QuanLyQuanNET] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [QuanLyQuanNET] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [QuanLyQuanNET] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET  DISABLE_BROKER 
GO
ALTER DATABASE [QuanLyQuanNET] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [QuanLyQuanNET] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [QuanLyQuanNET] SET  MULTI_USER 
GO
ALTER DATABASE [QuanLyQuanNET] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [QuanLyQuanNET] SET DB_CHAINING OFF 
GO
ALTER DATABASE [QuanLyQuanNET] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [QuanLyQuanNET] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
USE [QuanLyQuanNET]
GO
USE [QuanLyQuanNET]
GO
/****** Object:  Sequence [dbo].[CTHOADONSequence]    Script Date: 6/4/2024 10:04:04 PM ******/
CREATE SEQUENCE [dbo].[CTHOADONSequence] 
 AS [bigint]
 START WITH 1
 INCREMENT BY 1
 MINVALUE -9223372036854775808
 MAXVALUE 9223372036854775807
 CACHE 
GO
USE [QuanLyQuanNET]
GO
/****** Object:  Sequence [dbo].[DICHVUSEQUENCE]    Script Date: 6/4/2024 10:04:04 PM ******/
CREATE SEQUENCE [dbo].[DICHVUSEQUENCE] 
 AS [bigint]
 START WITH 1
 INCREMENT BY 1
 MINVALUE -9223372036854775808
 MAXVALUE 9223372036854775807
 CACHE 
GO
USE [QuanLyQuanNET]
GO
/****** Object:  Sequence [dbo].[HOADONSequence]    Script Date: 6/4/2024 10:04:04 PM ******/
CREATE SEQUENCE [dbo].[HOADONSequence] 
 AS [bigint]
 START WITH 1
 INCREMENT BY 1
 MINVALUE -9223372036854775808
 MAXVALUE 9223372036854775807
 CACHE 
GO
USE [QuanLyQuanNET]
GO
/****** Object:  Sequence [dbo].[MAYSEQUENCE]    Script Date: 6/4/2024 10:04:04 PM ******/
CREATE SEQUENCE [dbo].[MAYSEQUENCE] 
 AS [bigint]
 START WITH 1
 INCREMENT BY 1
 MINVALUE -9223372036854775808
 MAXVALUE 9223372036854775807
 CACHE 
GO
/****** Object:  Table [dbo].[CTHOADON]    Script Date: 6/4/2024 10:04:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CTHOADON](
	[MaCTHD] [varchar](10) NOT NULL DEFAULT ('CTHD'+right('000000'+CONVERT([varchar](6),NEXT VALUE FOR [CTHOADONSequence]),(6))),
	[MaHD] [varchar](8) NULL,
	[MaDV] [varchar](8) NULL,
	[DonGia] [int] NULL,
	[SoLuong] [float] NULL,
 CONSTRAINT [PK_CTHOADON] PRIMARY KEY CLUSTERED 
(
	[MaCTHD] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[DICHVU]    Script Date: 6/4/2024 10:04:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[DICHVU](
	[MaDV] [varchar](8) NOT NULL CONSTRAINT [DF__DICHVU__MaDV__6F7F8B4B]  DEFAULT ('DV'+right('000000'+CONVERT([varchar](6),NEXT VALUE FOR [DICHVUSequence]),(6))),
	[TenDV] [nvarchar](100) NULL,
	[DVTinh] [nvarchar](50) NULL,
	[DonGia] [int] NULL,
	[SoLuong] [float] NULL,
	[HinhAnh] [nvarchar](max) NULL,
 CONSTRAINT [PK_DICHVU] PRIMARY KEY CLUSTERED 
(
	[MaDV] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[HOADON]    Script Date: 6/4/2024 10:04:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[HOADON](
	[MaHD] [varchar](8) NOT NULL CONSTRAINT [DF__HOADON__MaHD__753864A1]  DEFAULT ('HD'+right('000000'+CONVERT([varchar](6),NEXT VALUE FOR [HOADONSequence]),(6))),
	[SDT] [varchar](10) NULL,
	[MaMay] [varchar](6) NULL,
	[TGBatDau] [datetime] NULL,
	[TGKetThuc] [datetime] NULL,
	[TongTien] [int] NULL,
	[TrangThaiHD] [nvarchar](20) NULL,
 CONSTRAINT [PK_HOADON] PRIMARY KEY CLUSTERED 
(
	[MaHD] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[KHACHHANG]    Script Date: 6/4/2024 10:04:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[KHACHHANG](
	[SDT] [varchar](10) NOT NULL,
	[TenKH] [nvarchar](100) NULL,
	[DiaChi] [nvarchar](200) NULL,
 CONSTRAINT [PK_KHACHHANG] PRIMARY KEY CLUSTERED 
(
	[SDT] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MAY]    Script Date: 6/4/2024 10:04:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MAY](
	[MaMay] [varchar](6) NOT NULL CONSTRAINT [DF__MAY__MaMay__68D28DBC]  DEFAULT ('MAY'+right('000'+CONVERT([varchar](3),NEXT VALUE FOR [MAYSequence]),(3))),
	[TenMay] [nvarchar](100) NULL,
	[TrangThaiMay] [nvarchar](20) NULL,
 CONSTRAINT [PK_MAY] PRIMARY KEY CLUSTERED 
(
	[MaMay] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[TAIKHOAN]    Script Date: 6/4/2024 10:04:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TAIKHOAN](
	[TaiKhoan] [nvarchar](100) NOT NULL,
	[MatKhau] [nvarchar](100) NOT NULL,
	[AnhAD] [nvarchar](max) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000212', N'HD000379', N'DV000001', 7000, 19)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000213', N'HD000379', N'DV000029', 10000, 3)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000214', N'HD000380', N'DV000001', 7000, 2.366667)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000215', N'HD000380', N'DV000029', 10000, 7)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000216', N'HD000379', N'DV000020', 15000, 2)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000217', N'HD000381', N'DV000001', 7000, 3.883333)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000218', N'HD000382', N'DV000001', 7000, 2.566667)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000219', N'HD000382', N'DV000018', 12000, 1)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000220', N'HD000382', N'DV000020', 15000, 1)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000223', N'HD000384', N'DV000001', 7000, 22.73333)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000224', N'HD000385', N'DV000001', 7000, 22.85)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000225', N'HD000386', N'DV000001', 7000, 17.16667)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000226', N'HD000386', N'DV000018', 12000, 2)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000227', N'HD000381', N'DV000020', 15000, 1)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000228', N'HD000385', N'DV000020', 15000, 1)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000229', N'HD000386', N'DV000020', 15000, 11)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000231', N'HD000388', N'DV000001', 7000, 0)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000232', N'HD000388', N'DV000019', 27000, 1)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000233', N'HD000389', N'DV000001', 7000, 0)
INSERT [dbo].[CTHOADON] ([MaCTHD], [MaHD], [MaDV], [DonGia], [SoLuong]) VALUES (N'CTHD000234', N'HD000389', N'DV000025', 12000, 11)
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000001', N'NET', N'Giờ', 7000, 0, N'D:\DA1_NET\C#\DA1_QLQuanNET\images\banner_3.png')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000018', N'Sting Dâu', N'Chai', 12000, 48, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\sting-dau.jpg')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000019', N'Cơm Gà', N'Phần', 27000, 24, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\com-ga.jpg')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000020', N'Mì Trứng', N'Phần', 15000, 20, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\mi-trung.jpg')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000025', N'Wakeup 247', N'Chai', 12000, 39, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\wakeup-247.jpg')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000029', N'Pepsi', N'Lon', 10000, 50, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\pepsi.jpg')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000030', N'Trà Đào', N'Ly', 25000, 50, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\tra-dao.jpeg')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000031', N'Cà Phê', N'Ly', 10000, 30, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\exit-removebg-preview.png')
INSERT [dbo].[DICHVU] ([MaDV], [TenDV], [DVTinh], [DonGia], [SoLuong], [HinhAnh]) VALUES (N'DV000032', N'REDBULL', N'Lon', 20000, 27, N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\wakeup-247.jpg')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000379', N'0123456789', N'MAY059', CAST(N'2024-05-27 15:48:25.000' AS DateTime), CAST(N'2024-05-27 16:08:06.440' AS DateTime), 193000, N'Đã Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000380', N'0333333333', N'MAY099', CAST(N'2024-05-27 15:49:08.000' AS DateTime), CAST(N'2024-05-27 15:49:08.000' AS DateTime), 86566, N'Chưa Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000381', N'0444444444', N'MAY059', CAST(N'2024-05-27 16:09:18.000' AS DateTime), CAST(N'2024-05-27 16:09:18.000' AS DateTime), 42183, N'Chưa Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000382', N'0329502687', N'MAY071', CAST(N'2024-05-27 16:10:04.000' AS DateTime), CAST(N'2024-05-27 16:10:04.000' AS DateTime), 44966, N'Chưa Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000384', N'0000011111', N'MAY098', CAST(N'2024-05-27 19:27:09.000' AS DateTime), CAST(N'2024-05-27 19:27:09.000' AS DateTime), 159133, N'Chưa Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000385', N'0214365879', N'MAY064', CAST(N'2024-05-27 19:28:26.000' AS DateTime), CAST(N'2024-05-27 19:28:26.000' AS DateTime), 174950, N'Chưa Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000386', N'0123456789', N'MAY069', CAST(N'2024-05-27 21:56:48.000' AS DateTime), CAST(N'2024-06-01 15:06:56.020' AS DateTime), 309166, N'Đã Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000388', N'0834370558', N'MAY058', CAST(N'2024-05-30 16:02:31.000' AS DateTime), CAST(N'2024-05-30 16:03:15.047' AS DateTime), 27000, N'Đã Thanh Toán')
INSERT [dbo].[HOADON] ([MaHD], [SDT], [MaMay], [TGBatDau], [TGKetThuc], [TongTien], [TrangThaiHD]) VALUES (N'HD000389', N'1111100000', N'MAY063', CAST(N'2024-06-04 20:02:36.000' AS DateTime), CAST(N'2024-06-04 20:02:36.000' AS DateTime), 132000, N'Chưa Thanh Toán')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0000011111', N'Z', N'y')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0111111111', N'Khách Hàng 1', N'Địa Chỉ 1')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0123456789', N'Dương Thế Ngọc', N'Kiên Giang')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0214365879', N'Nguyễn Huỳnh Hữu Lợi', N'An Giang')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0222222222', N'Khách Hàng 2', N'Địa Chỉ 2')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0321654987', N'Phan Bảo Duy', N'Bến Tre')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0329502687', N'CHÍ CƯỜNG', N'cần thơ')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0333333333', N'Khách Hàng 3', N'Địa Chỉ 3')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0444444444', N'Khách Hàng 4', N'Địa Chỉ 4')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0555555555', N'Khách Hàng 4', N'Địa Chỉ 4')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0834370558', N'Huy Đặc Cầu', N'Sóc Trăng')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'0981276345', N'Khách Hàng Test', N'Địa Chỉ Test')
INSERT [dbo].[KHACHHANG] ([SDT], [TenKH], [DiaChi]) VALUES (N'1111100000', N'B', N'A')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY058', N'Máy 32', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY059', N'Máy 4', N'Đang dùng')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY060', N'Máy 5', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY061', N'Máy 6', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY062', N'Máy 7', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY063', N'Máy 8', N'Đang dùng')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY064', N'Máy 9', N'Đang dùng')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY066', N'Máy 10', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY068', N'Máy 12', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY069', N'Máy 13', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY070', N'Máy 14', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY071', N'Máy 15', N'Đang dùng')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY072', N'Máy 16', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY073', N'Máy 17', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY074', N'Máy 18', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY075', N'Máy 19', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY076', N'Máy 20', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY077', N'Máy 21', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY078', N'Máy 22', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY079', N'Máy 23', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY080', N'Máy 24', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY081', N'Máy 25', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY082', N'Máy 26', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY083', N'Máy 27', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY084', N'Máy 28', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY085', N'Máy 29', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY086', N'Máy 30', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY088', N'Máy 11', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY089', N'Máy 1', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY091', N'Máy 33', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY092', N'Máy 34', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY093', N'Máy 35', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY094', N'Máy 36', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY095', N'Máy 37', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY096', N'Máy 38', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY097', N'Máy 3', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY098', N'Máy 39', N'Đang dùng')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY099', N'Máy 40', N'Đang dùng')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY100', N'Máy 31', N'Trống')
INSERT [dbo].[MAY] ([MaMay], [TenMay], [TrangThaiMay]) VALUES (N'MAY101', N'Máy 2', N'Trống')
INSERT [dbo].[TAIKHOAN] ([TaiKhoan], [MatKhau], [AnhAD]) VALUES (N'admin', N'211242', N'D:\PhanMem_QLQuanNET\DA1_QLQuanNET\DA1_QLQuanNET\images\User.png')
ALTER TABLE [dbo].[CTHOADON]  WITH CHECK ADD  CONSTRAINT [FK_CTHOADON_DICHVU] FOREIGN KEY([MaDV])
REFERENCES [dbo].[DICHVU] ([MaDV])
GO
ALTER TABLE [dbo].[CTHOADON] CHECK CONSTRAINT [FK_CTHOADON_DICHVU]
GO
ALTER TABLE [dbo].[CTHOADON]  WITH CHECK ADD  CONSTRAINT [FK_CTHOADON_HOADON] FOREIGN KEY([MaHD])
REFERENCES [dbo].[HOADON] ([MaHD])
GO
ALTER TABLE [dbo].[CTHOADON] CHECK CONSTRAINT [FK_CTHOADON_HOADON]
GO
ALTER TABLE [dbo].[HOADON]  WITH CHECK ADD  CONSTRAINT [FK_HOADON_KHACHHANG] FOREIGN KEY([SDT])
REFERENCES [dbo].[KHACHHANG] ([SDT])
GO
ALTER TABLE [dbo].[HOADON] CHECK CONSTRAINT [FK_HOADON_KHACHHANG]
GO
ALTER TABLE [dbo].[HOADON]  WITH CHECK ADD  CONSTRAINT [FK_HOADON_MAY] FOREIGN KEY([MaMay])
REFERENCES [dbo].[MAY] ([MaMay])
GO
ALTER TABLE [dbo].[HOADON] CHECK CONSTRAINT [FK_HOADON_MAY]
GO
USE [master]
GO
ALTER DATABASE [QuanLyQuanNET] SET  READ_WRITE 
GO
