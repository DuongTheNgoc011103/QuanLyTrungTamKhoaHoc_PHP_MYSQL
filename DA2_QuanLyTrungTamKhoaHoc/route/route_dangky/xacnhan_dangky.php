<?php

    require_once "../../route/route_dangky/dangky.php";
        
    $get_id = $_GET['ID_DangKy'];

    $dangky = new DS_DANGKY();

    $dangky->xacnhan_dangky($get_id);

    header("Location:  ../../pages/admin_pages/index.php");

?>