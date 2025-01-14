<?php
    
    $get_id = $_GET['ID_LichHoc'];

    require_once "../../route/route_diemdanh/diemdanh.php";
    $diemdanh = new DS_DIEMDANH();
    $diemdanh->delete_diemdanh_by_id_lichhoc($get_id);

    require_once "../../route/route_lichhoc/lichhoc.php";
    $lichhoc = new DS_LICHHOC();
    $lichhoc->delete_lichhoc($get_id);
    
    header('Location:  ../../pages/admin_pages/index.php');

?>