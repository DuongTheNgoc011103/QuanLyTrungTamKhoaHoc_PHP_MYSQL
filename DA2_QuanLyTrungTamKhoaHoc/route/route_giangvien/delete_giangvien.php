<?php
    require_once "../route_giangvien/giangvien.php";
    
    $get_id = $_GET['ID_GiangVien'];
    
    $giangvien = new DS_GIANGVIEN();
    
    $giangvien->delete_giangvien($get_id);
    
    header('location: ../../pages/admin_pages/index.php');
    
?>