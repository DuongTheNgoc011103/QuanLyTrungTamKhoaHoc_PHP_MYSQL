<?php

    require_once "../../route/route_khoahoc/khoahoc.php";
    
    $get_id = $_GET['ID_KhoaHoc'];
    
    $khoahoc = new DS_KHOAHOC();
    
    $khoahoc->delete_khoahoc($get_id);
    
    header('Location:  ../../pages/admin_pages/index.php');

?>