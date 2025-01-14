<?php

    $get_id = $_GET['ID_DanhMuc'];
    
    require_once "../../route/route_danhmuc/danhmuc.php";
    require_once "../../route/route_khoahoc/khoahoc.php";
    
    $khoahoc = new DS_KHOAHOC();
    $khoahoc->delete_khoahoc_by_ID_DanhMuc($get_id);
    
    $danhmuc = new DS_DANHMUC();        
    $danhmuc->delete_danhmuc($get_id);
    
    header('location: ../../pages/admin_pages/index.php');

?>