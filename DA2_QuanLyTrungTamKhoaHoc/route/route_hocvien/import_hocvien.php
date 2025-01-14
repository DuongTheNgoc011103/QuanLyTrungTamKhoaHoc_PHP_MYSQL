<?php

if (class_exists('ZipArchive')) {
    echo "ZipArchive đã được kích hoạt.";
} else {
    echo "ZipArchive chưa được kích hoạt.";
}
    // Kết nối cơ sở dữ liệu
    include("./hocvien.php");
    
    require '../../vendor/autoload.php'; // Đảm bảo thư viện PhpSpreadsheet đã được tải

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;

    if (isset($_POST['import'])) {
        $file_mime_type = mime_content_type($_FILES['file']['tmp_name']);
        $allowed_types = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        
        if (!in_array($file_mime_type, $allowed_types)) {
            die("Chỉ hỗ trợ file Excel.");
        }

        $filePath = $_FILES['file']['tmp_name'];
        $spreadsheet = IOFactory::load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Bỏ qua dòng tiêu đề
        unset($sheetData[0]);

        foreach ($sheetData as $row) {
            // Giả sử các cột trong file Excel: Tên học viên, Email, SĐT, Ngày sinh, Trạng thái, Hình ảnh
            $tenHV = $row[0];
            $gioitinh = $row[1];
            $anhHV = $row[2];
            $email = $row[3];
            $sdt = $row[4];
            $ngaysinh = $row[5];

            // Thực hiện truy vấn để thêm dữ liệu vào MySQL
            $hocvien = new DS_HOCVIEN();
            $hocvien->add_hocvien($tenHV, $gioitinh, $anhHV, $email, $sdt, $ngaysinh);
        }

        header('location: ../../pages/admin_pages/index.php');
    }
?>
