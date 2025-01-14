<?php

    $get_id = $_GET['ID_HoaDon'];
    
    require_once "../../route/route_hoadon/hoadon.php";
    $hoadon = new DS_HOADON();
    
    $hoadon_info = $hoadon->get($get_id);
    
    $id_lophoc = $hoadon->get_ID_LopHoc($get_id);
    
    require_once "../../route/route_lophoc/lophoc.php";
    $lophoc = new DS_LOPHOC();
    $lophoc_info = $lophoc->get($id_lophoc);
    
    require_once "../../route/route_khoahoc/khoahoc.php";
    $khoahoc = new DS_KHOAHOC();
    $id_khoahoc = $lophoc_info['ID_KhoaHoc'];
    $khoahoc_info = $khoahoc->get_name_by_id($id_khoahoc);
    $price_khoahoc = $khoahoc->get_hocphi($id_khoahoc);
    
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    $lh_hv = new DS_HOCVIEN_LOPHOC();
    
    // show all hocvien by id_lophoc
    $show_all_HV = $lh_hv->get_hocvien_by_ID_LopHoc($id_lophoc);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="../../assets/images/icons/icon-web.png" rel="shortcut icon" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <title>CHI TIẾT HÓA ĐƠN</title>
    <style>
        body{
            background: rgba(0, 0, 0, 0.2);
        }
        .modal-dialog{
            background: #fff;
        }
    </style>
</head>
<body>
    <button class="btn px-4 py-2 top-0 rounded-0 btn-secondary position-fixed z-1 btn-back" onclick="window.location.href='../../pages/admin_pages/index.php'">BACK</button>
    <div class="content" style="display: block;">
        <div class="modal-dialog" style="max-width: 1000px;">
            <div class="modal-content px-4 py-3">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase text-center w-100 fw-bold text-primary" id="ChiTietHDLabel">
                        CHI TIẾT HÓA ĐƠN
                    </h5>
                </div>
                <div id="modal-body-HD">
                    <div class="info d-flex justify-content-between mt-3">
                        <h6 class="text-uppercase fw-bold"></h6>
                        <h1 class="fw-bold fst-italic" style="letter-spacing: 2px; transform: translateX(80px)">
                            <span>STY</span><span class="text-primary">DU</span>
                        </h1>
                        <h6 class="text-uppercase fst-italic">Trung Tâm Khóa Học</h6>
                    </div>

                    <!-- Thông tin Lớp Học -->
                    <div class="info-HocVien mb-4 col">
                        <h6 class="text-uppercase fw-bold">Thông Tin Lớp Học</h6>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width: 200px" class="fw-bold">Tên Lớp</td>
                                    <td><?=$lophoc_info['TenLop']?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tên Khóa Học</td>
                                    <td><?=$khoahoc_info?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Chi tiết hóa đơn -->
                    <h6 class="text-uppercase fw-bold">Chi Tiết Hóa Đơn</h6>
                    <table class="table table-bordered text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>Mã Học Viên</th>
                                <th>Tên Học Viên</th>
                                <th>Ngày đăng ký</th>
                                <th>Số tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $tong_tien = 0;
                                while($row = mysqli_fetch_assoc($show_all_HV)){
                                
                                $tong_tien += $price_khoahoc;
                                require_once "../../route/route_hocvien/hocvien.php";
                                
                                $hocvien = new DS_HOCVIEN();
                                $hocvien_info = $hocvien->get($row['ID_HocVien']);
                                
                                require_once "../../route/route_dangky/dangky.php";
                                $dangky = new DS_DANGKY();
                                $dangky_info = $dangky->get_ID_DK_by_ID_HocVien_AND_ID_LopHoc($row['ID_HocVien'], $id_lophoc);
                            ?>
                            
                                <tr>
                                    <td><?=$row['ID_HocVien']?></td>
                                    <td><?=$hocvien_info['TenHV']?></td>
                                    <td><?=$dangky_info['NgayDK']?></td>
                                    <td><?php echo number_format($price_khoahoc, 0, ',', '.') . " VNĐ"; ?></td>
                                </tr>
                            
                            <?php } ?>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pe-5">Tổng Hóa Đơn</td>
                                    <td class="fw-bold"><?php echo number_format($tong_tien, 0, ',', '.') . " VNĐ"; ?></td>
                                </tr>
                        </tbody>
                    </table>

                    <div class="btn-in d-flex justify-content-end">
                        <button class="btn btn-success px-5 text-uppercase" onclick="location.href='./export_hoadon.php?ID_HoaDon=<?php echo $get_id; ?>'">IN HÓA ĐƠN</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>