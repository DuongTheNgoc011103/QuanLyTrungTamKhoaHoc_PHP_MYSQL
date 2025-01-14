<?php

    $get_id = $_GET['ID_DKThi'];

    // Lấy thông tin lớp học
    require_once "../../route/route_dangkythi/dangky_thi.php";
    $dkthi = new DS_DKTHI();
    
    // lay ID_LopHoc
    $lophoc_info = $dkthi->get_ID_LopHoc($get_id);
    
    // Thiết lập để xuất file Excel
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=DanhSach_DiemThi_$get_id.xls");

    // Xuất BOM UTF-8 để đảm bảo Excel đọc đúng ký tự đặc biệt
    echo "\xEF\xBB\xBF";  // BOM cho UTF-8

    // Kết nối với các lớp cần thiết và lấy dữ liệu
    require_once "../../route/route_lophoc/lophoc.php";
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";    

    // Lấy danh sách học viên
    $lophoc_hocvien = new DS_HOCVIEN_LOPHOC();
    $lophoc_hocvien_info = $lophoc_hocvien->get_hocvien_by_ID_LopHoc($lophoc_info);
    if (mysqli_num_rows($lophoc_hocvien_info) < 0) {
        echo 'Không có dữ liệu';
    }


    // Xuất file Excel
    echo '<table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>STT</th>
                <th>MSHV</th>
                <th>Tên Học Viên</th>
                <th>Email</th>
                <th>Ngày Sinh</th>
                <th>Điểm Thi</th>
            </tr>';
    $num=0;
    while($row_hv = mysqli_fetch_assoc($lophoc_hocvien_info)){
        
        require_once "../../route/route_diemthi/diemthi.php";
        $diemthi = new DS_DIEMTHI();
        $diem = $diemthi->get_DiemThi($row_hv['ID_HocVien'], $get_id);
        
        require_once "../../route/route_diemdanh/diemdanh.php";
        $diemdanh = new DS_DIEMDANH();
        $soBuoiHoc = $diemdanh->SoBuoi_DD($row_hv['ID_HocVien']);
        
        $num++;
        require_once "../../route/route_hocvien/hocvien.php";
        $hocvien = new DS_HOCVIEN();
        $hocvien_info = $hocvien->get($row_hv['ID_HocVien']);
        
        echo '<tr>';
        echo '<td>' . $num . '</td>';
        echo '<td>' . $hocvien_info['ID_HocVien'] . '</td>';
        echo '<td>' . $hocvien_info['TenHV'] . '</td>';
        echo '<td>' . $hocvien_info['Email'] . '</td>';
        echo '<td>' . $hocvien_info['NgaySinh'] . '</td>';
        echo '<td>' . $diem . '</td>';
        echo '</tr>';
    }

    echo '</table>';
?>
