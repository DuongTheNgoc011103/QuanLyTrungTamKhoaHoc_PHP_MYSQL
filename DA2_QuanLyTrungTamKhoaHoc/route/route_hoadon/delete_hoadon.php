<?php

    require_once "../../route/route_hoadon/hoadon.php";
    
    $get_id = $_GET['ID_HoaDon'];
    
    $hoadon = new DS_HOADON();
    
    $hoadon->delete_hoadon($get_id);
    
    header('location: ../../pages/admin_pages/index.php');
?>