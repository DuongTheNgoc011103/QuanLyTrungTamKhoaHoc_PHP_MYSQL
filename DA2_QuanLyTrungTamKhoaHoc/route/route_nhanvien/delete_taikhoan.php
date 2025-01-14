<?php

    require_once "../../route/route_nhanvien/taikhoan_nhanvien.php";
    
    $get_id = $_GET['ID_TaiKhoan'];
    
    $taikhoan = new DS_TAIKHOAN(); 
    
    $taikhoan->delete_taikhoan($get_id);
    
    header("Location: ../../pages/admin_pages/index.php");

?>