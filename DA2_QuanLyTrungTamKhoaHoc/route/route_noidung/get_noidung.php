<?php
    require_once "../../route/route_noidung/noidung_khoahoc.php";

    if (isset($_GET['ID_NoiDung'])) {
        $id_noidung = $_GET['ID_NoiDung'];
        $noidung = new DS_NDKH();
        $data = $noidung->get($id_noidung); // Hàm để lấy thông tin theo ID
        
        if ($data) {
            echo json_encode([
                'success' => true,
                'TenND' => $data['TenND'],
                'TaiLieu' => $data['TaiLieu']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy nội dung bài học.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Thiếu ID_NoiDung.'
        ]);
    }
?>
