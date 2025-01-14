<?php
    require_once "../route_hocvien/hocvien.php";
    require_once "../../route/route_dangky/dangky.php";
    require_once "../../route/route_hoadon/hoadon.php";
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    
    $get_id = $_GET['ID_HocVien'];
    
    $dangky = new DS_DANGKY();
    $id_dangky = $dangky->get_ID_HocVien($get_id);
    
    $hoadon = new DS_HOADON();
    $hoadon->delete_hoadon_by_ID_DangKy($id_dangky);
    
    // cần xóa thông tin đáng ký của học viên đó trước
    $dangky->delete_dangky_by_ID_HocVien($get_id);
    
    // cần xóa thông tin của học viên đó trước
    $lh_hv = new DS_HOCVIEN_LOPHOC();
    $lh_hv->delete_hocvien_lophoc_By_ID_HocVien($get_id);

    $hocvien = new DS_HOCVIEN();
    $hocvien->delete_hocvien($get_id);
    
    header('location: ../../pages/admin_pages/index.php');
    
?>