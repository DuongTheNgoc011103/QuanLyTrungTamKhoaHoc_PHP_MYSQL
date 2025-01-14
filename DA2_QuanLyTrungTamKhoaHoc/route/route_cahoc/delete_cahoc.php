<?php

    require_once "../../route/route_cahoc/cahoc.php";
    
    $get_id = $_GET['ID_CaHoc'];

    require_once "../../route/route_lichhoc/lichhoc.php";
    $lichhoc = new DS_LICHHOC();
    $lichhoc->delete_lichhoc_by_ID_CaHoc($get_id);
    
    $cahoc = new DS_CAHOC();;
    $cahoc->delete_cahoc($get_id);
    
    header("Location:  ../../pages/admin_pages/index.php");

?>