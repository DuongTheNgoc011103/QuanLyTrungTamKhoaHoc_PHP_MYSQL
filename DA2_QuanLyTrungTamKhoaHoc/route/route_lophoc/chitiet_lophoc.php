<?php

    require_once "../../route/route_lophoc/lophoc.php";        
    
    $get_id = $_GET['ID_LopHoc'];
    $lophoc = new DS_LOPHOC();
    
    $lophoc_info = $lophoc->get($get_id);
    
    require_once "../../route/route_giangvien/giangvien.php";
    $giangvien = new DS_GIANGVIEN();
    $giangvien_info = $giangvien->get($lophoc_info['ID_GiangVien']);
    
    require_once "../../route/route_khoahoc/khoahoc.php";
    $khoahoc = new DS_KHOAHOC();
    $khoahoc_info = $khoahoc->get($lophoc_info['ID_KhoaHoc']);
    
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    $lophoc_hocvien = new DS_HOCVIEN_LOPHOC();
    $lophoc_hocvien_info = $lophoc_hocvien->get_hocvien_by_ID_LopHoc($get_id);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="../../assets/images/icons/icon-web.png" rel="shortcut icon" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
        
        <link rel="stylesheet" href="../../assets/css/header.css">
        <link rel="stylesheet" href="../../assets/css/chitiet_lophoc.css">
        
        <title>THÔNG TIN LỚP HỌC</title>
    </head>
<body>
    <button class="btn px-4 py-2 top-0 rounded-0 btn-secondary position-fixed btn-back" onclick="window.location.href='../../pages/admin_pages/index.php'">BACK</button>
    <main>
        <div class="container mt-4">
            <div class="row">
                <!-- Thông tin giảng viên và khóa học -->
                <div class="col-md-4">
                    <div class="giangvien row p-3 mb-3">
                        <img src="../route_giangvien/ANHGV/<?=$giangvien_info['AnhGV']?>" alt="Giảng viên" class="col-5">
                        <div class="info_giangvien col">
                            <div class="tengv text-uppercase my-2"><?=$giangvien_info['TenGV']?></div>
                            <div class="sdt_giangvien my-2"><strong class="me-1">SĐT: </strong><?=$giangvien_info['SDT']?></div>
                            <div class="email_giangvien my-2"><strong class="me-1">Email: </strong><?=$giangvien_info['Email']?></div>
                            <div class="ngaysinh_giangvien my-2"><strong class="me-1">Ngày Sinh: </strong><?=$giangvien_info['NgaySinh']?></div>
                        </div>
                    </div>
                    <!-- Khóa học -->
                    <div class="khoahoc">
                        <strong class="me-3">Khóa học:</strong> <?=$khoahoc_info['TenKH']?>
                    </div>
                    <!-- Lớp học -->
                    <div class="lophoc">
                        <strong class="me-3">Lớp học:</strong> <?=$lophoc_info['TenLop']?>
                    </div>
                </div>
                <!-- Danh sách học viên (Bảng) -->
                <div class="col-md-8">
                    <div class="table-container">
                        <div class="head d-flex justify-content-between mb-3 row">
                            <h4 class="m-0 d-flex align-items-center text-uppercase fw-bold col">Danh Sách Học Viên</h4>
                            <div class="gap-3 d-flex justify-content-end col-8">
                                <button class="btn btn-success px-4 text-uppercase rounded-0" onclick="location.href='./export_DSHV.php?ID_LopHoc=<?php echo $get_id; ?>'">Export</button>
                            </div>
                        </div>
                        <table class="table table-striped table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px;">STT</th>
                                    <th style="width: 50px;">MSHV</th>
                                    <th>Tên Học Viên</th>
                                    <th>Email</th>
                                    <th style="width: 100px;">SĐT</th>
                                    <th style="width: 120px;">Ngày Sinh</th>
                                    <th style="width: 120px;">Số Buổi Học</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                    $num=0;
                                    while($lophoc_info_hv = mysqli_fetch_assoc($lophoc_hocvien_info)){ 
                                        
                                        require_once "../../route/route_diemdanh/diemdanh.php";
                                        $diemdanh = new DS_DIEMDANH();
                                        $soBuoiHoc = $diemdanh->SoBuoi_DD($lophoc_info_hv['ID_HocVien']);
                                        
                                        $num++;
                                        require_once "../../route/route_hocvien/hocvien.php";
                                        $hocvien = new DS_HOCVIEN();
                                        $hocvien_info = $hocvien->get($lophoc_info_hv['ID_HocVien']);
                                ?>
                                    <tr>
                                        <td class="align-middle" style="width: 50px;"><?=$num?></td>
                                        <td class="align-middle" style="width: 50px;"><?=$hocvien_info['ID_HocVien']?></td>
                                        <td class="align-middle"><?=$hocvien_info['TenHV']?></td>
                                        <td class="align-middle"><?=$hocvien_info['Email']?></td>
                                        <td class="align-middle" style="width: 100px;"><?=$hocvien_info['SDT']?></td>
                                        <td class="align-middle" style="width: 120px;"><?=$hocvien_info['NgaySinh']?></td>
                                        <td class="align-middle" style="width: 120px;"><?=$soBuoiHoc?></td>
                                    </tr>
                                <?php } ?>
                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>