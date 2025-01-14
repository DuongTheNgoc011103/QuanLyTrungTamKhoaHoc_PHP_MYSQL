<?php

    require_once "../../route/route_dangkythi/dangky_thi.php";
    
    $get_id = $_GET['ID_DKThi'];
    
    $dangky_thi = new DS_DKTHI();
    
    $dangky_thi->delete_dangky_thi($get_id);
    
    header('location: ../../pages/admin_pages/index.php');

?>