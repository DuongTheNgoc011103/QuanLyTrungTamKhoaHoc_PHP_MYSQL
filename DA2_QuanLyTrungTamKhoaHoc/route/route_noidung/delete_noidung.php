<?php

    require_once "../../route/route_noidung/noidung_khoahoc.php";
    
    $noidung = new DS_NDKH();
    
    $get_id = $_GET['ID_NoiDung'];
    
    $khoahoc_info = $noidung->get_ID_KhoaHoc($get_id);
    
    $noidung->delete_noidung_kh($get_id);

    header("Location: ../../route/route_khoahoc/edit_khoahoc.php?ID_KhoaHoc=" . urlencode($khoahoc_info));
    exit();

    
?>