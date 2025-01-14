<?php
    // Lấy thông tin lớp học
    $get_id = $_GET['ID_LopHoc'];

    // Thiết lập để xuất file Excel
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=DanhSach_HocVien_Lop_$get_id.xls");

    // Xuất BOM UTF-8 để đảm bảo Excel đọc đúng ký tự đặc biệt
    echo "\xEF\xBB\xBF"; // BOM cho UTF-8

    // Kết nối với các lớp cần thiết và lấy dữ liệu
    require_once "../../route/route_lophoc/lophoc.php";
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";

    $lophoc = new DS_LOPHOC();
    $lophoc_info = $lophoc->get_TenLop_By_ID_LopHoc($get_id);

    // Hiển thị tiêu đề file Excel
    echo "<h3 style='text-align: center; font-weight: bold;'>
            DANH SÁCH HỌC VIÊN CỦA LỚP HỌC $lophoc_info<br>
            Tên Lớp: $lophoc_info<br>
        </h3>";

    // Lấy danh sách học viên
    $lophoc_hocvien = new DS_HOCVIEN_LOPHOC();
    $lophoc_hocvien_info = $lophoc_hocvien->get_hocvien_by_ID_LopHoc($get_id);

    if (mysqli_num_rows($lophoc_hocvien_info) <= 0) {
        echo "<p>Không có dữ liệu</p>";
        exit;
    }

    // Xuất tiêu đề bảng
    echo '<table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>STT</th>
                <th>MSHV</th>
                <th>Tên Học Viên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Ngày Sinh</th>
                <th>Số Buổi Học</th>
            </tr>';

    $num = 0;
    while ($row_hv = mysqli_fetch_assoc($lophoc_hocvien_info)) {
        require_once "../../route/route_diemdanh/diemdanh.php";
        $diemdanh = new DS_DIEMDANH();
        $soBuoiHoc = $diemdanh->SoBuoi_DD($row_hv['ID_HocVien']);

        $num++;
        require_once "../../route/route_hocvien/hocvien.php";
        $hocvien = new DS_HOCVIEN();
        $hocvien_info = $hocvien->get($row_hv['ID_HocVien']);

        // Thêm dữ liệu học viên vào bảng
        echo '<tr>';
        echo '<td>' . $num . '</td>';
        echo '<td>' . $hocvien_info['ID_HocVien'] . '</td>';
        echo '<td>' . $hocvien_info['TenHV'] . '</td>';
        echo '<td>' . $hocvien_info['Email'] . '</td>';
        echo '<td>' . $hocvien_info['SDT'] . '</td>';
        echo '<td>' . $hocvien_info['NgaySinh'] . '</td>';
        echo '<td>' . $soBuoiHoc . '</td>';
        echo '</tr>';
    }

    echo '</table>';
?>
