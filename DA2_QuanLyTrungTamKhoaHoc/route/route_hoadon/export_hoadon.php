<?php

    require_once('../../vendor/tecnickcom/tcpdf/tcpdf.php');

    // Kiểm tra và lấy ID hóa đơn
    if (!isset($_GET['ID_HoaDon']) || empty($_GET['ID_HoaDon'])) {
        die('ID hóa đơn không hợp lệ.');
    }
    $get_id = $_GET['ID_HoaDon'];

    // Kết nối và lấy thông tin hóa đơn
    require_once "../../route/route_hoadon/hoadon.php";
    $hoadon = new DS_HOADON();
    $hoadon_info = $hoadon->get($get_id);

    if (!$hoadon_info) {
        die('Không tìm thấy thông tin hóa đơn.');
    }

    // Lấy thông tin lớp học liên quan
    $id_lophoc = $hoadon->get_ID_LopHoc($get_id);

    require_once "../../route/route_lophoc/lophoc.php";
    $lophoc = new DS_LOPHOC();
    $lophoc_info = $lophoc->get($id_lophoc);

    // Lấy thông tin khóa học
    require_once "../../route/route_khoahoc/khoahoc.php";
    $khoahoc = new DS_KHOAHOC();
    $id_khoahoc = $lophoc_info['ID_KhoaHoc'];
    $khoahoc_info = $khoahoc->get_name_by_id($id_khoahoc);
    $price_khoahoc = $khoahoc->get_hocphi($id_khoahoc);

    // Lấy tất cả học viên trong lớp học
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    $lh_hv = new DS_HOCVIEN_LOPHOC();
    $show_all_HV = $lh_hv->get_hocvien_by_ID_LopHoc($id_lophoc);

    // Khởi tạo TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Cài đặt thông tin tài liệu
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Trung Tâm Khóa Học');
    $pdf->SetTitle('Hóa đơn khóa học');
    $pdf->SetSubject('Chi tiết hóa đơn');
    $pdf->SetKeywords('Hóa đơn, PDF, TCPDF');

    // Xóa header và footer mặc định
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Thiết lập font chữ
    $pdf->SetFont('dejavusans', '', 12);

    // Thêm trang mới
    $pdf->AddPage();

    // Nội dung tiêu đề
    $title = '<h1 style="text-align:center;">HÓA ĐƠN THU TIỀN</h1>';
    $pdf->writeHTML($title, true, false, true, false, '');

    // Lấy ngày hiện tại của hệ thống
    $current_date = date('d/m/Y');

    // Thông tin lớp học
    $html = '
    
        <p style="font-style: italic; margin: 0; width: 50%; text-align: right;">
            <strong>Ngày In:</strong> <span>' . $current_date . '</span>
        </p>
        <h3 style="margin: 0; width: 50%; text-align: left;">Thông Tin Lớp Học</h3>

    ';


    $html .= '<table border="1" cellpadding="5">
        <tr>
            <th><strong>Tên Lớp:</strong></th>
            <td>' . htmlspecialchars($lophoc_info['TenLop']) . '</td>
        </tr>
        <tr>
            <th><strong>Tên Khóa Học:</strong></th>
            <td>' . htmlspecialchars($khoahoc_info) . '</td>
        </tr>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Thông tin hóa đơn
    $html = '<h3>Chi Tiết Hóa Đơn</h3>';
    $html .= '<table border="1" cellpadding="5">
        <thead>
            <tr>
                <th style="width: 20%; text-align: center; font-weight: bold;">Mã Học Viên</th>
                <th style="width: 35%; text-align: center; font-weight: bold;">Tên Học Viên</th>
                <th style="width: 20%; text-align: center; font-weight: bold;">Ngày Đăng Ký</th>
                <th style="width: 25%; text-align: center; font-weight: bold;">Số Tiền</th>
            </tr>
        </thead>
        <tbody>';

    $tong_tien = 0;
    while ($row = mysqli_fetch_assoc($show_all_HV)) {
        $tong_tien += $price_khoahoc;

        require_once "../../route/route_hocvien/hocvien.php";
        $hocvien = new DS_HOCVIEN();
        $hocvien_info = $hocvien->get($row['ID_HocVien']);

        require_once "../../route/route_dangky/dangky.php";
        $dangky = new DS_DANGKY();
        $dangky_info = $dangky->get_ID_DK_by_ID_HocVien_AND_ID_LopHoc($row['ID_HocVien'], $id_lophoc);

        $html .= '<tr>
            <td style="text-align: center; width: 20%;">' . htmlspecialchars($row['ID_HocVien']) . '</td>
            <td style="text-align: center; width: 35%;">' . htmlspecialchars($hocvien_info['TenHV']) . '</td>
            <td style="text-align: center; width: 20%;">' . htmlspecialchars($dangky_info['NgayDK']) . '</td>
            <td style="text-align: center; width: 25%;">' . number_format($price_khoahoc, 0, ',', '.') . ' VNĐ</td>
        </tr>';
    }

    $html .= '</tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right; font-weight: bold;">Tổng Cộng:</th>
                <th style="text-align: center; font-weight: bold;">' . number_format($tong_tien, 0, ',', '.') . ' VNĐ</th>
            </tr>
        </tfoot>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Xuất file PDF
    $pdf->Output('hoadon_' . $get_id . '.pdf', 'I'); // Xuất file PDF trực tiếp trên trình duyệt I
?>
