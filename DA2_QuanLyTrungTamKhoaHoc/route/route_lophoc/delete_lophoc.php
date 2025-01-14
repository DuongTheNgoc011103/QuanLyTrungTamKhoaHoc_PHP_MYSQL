<?php

    // Lấy ID_LopHoc
    require "../../route/route_lophoc/lophoc.php";
    
    $get_id = $_GET['ID_LopHoc'];
    
    // Xóa danh sách học viên trong lớp
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    
    $lophoc_hocvien = new DS_HOCVIEN_LOPHOC();
    
    $lophoc_hocvien->delete_hocvien_lophoc($get_id);
    
    // Xóa lịch học của lớp đó
    require_once "../../route/route_lichhoc/lichhoc.php";
    
    $lichhoc = new DS_LICHHOC();
    
    $lichhoc->delete_lichhoc_by_ID_LopHoc($get_id);
    
    // Xóa hóa đơn của lịch học đó
    require_once "../../route/route_hoadon/hoadon.php";
    
    $hoadon = new DS_HOADON();
    
    $hoadon->delete_hoadon_by_ID_LopHoc($get_id);
    
    // Xóa lớp học
    $lophoc = new DS_LOPHOC();
    
    $lophoc->delete_lophoc($get_id);
    
    header("Location: ../../pages/admin_pages/index.php");

?>