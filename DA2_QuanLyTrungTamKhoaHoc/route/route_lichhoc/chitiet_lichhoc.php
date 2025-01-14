<?php
    session_start();
            
    if(isset($_SESSION['AD_NAME']) && !isset($_SESSION['GV_NAME'])){
        header("Location: ../../pages/admin_pages/index.php");
        exit();
    }

    require_once "../../route/route_lichhoc/lichhoc.php";

    // Kiểm tra và lấy giá trị ID_lichhoc từ URL
    $get_id = isset($_GET['ID_LichHoc']) ? intval($_GET['ID_LichHoc']) : null;
    if (!$get_id) {
        die("ID_LichHoc không hợp lệ hoặc không được truyền.");
    }

    $lichhoc = new DS_LICHHOC();
    $lichhoc_info = $lichhoc->get($get_id);

    // Kiểm tra nếu không tìm thấy lớp học
    if (!$lichhoc_info) {
        die("Không tìm thấy thông tin lớp học với ID: " . htmlspecialchars($get_id));
    }
    
    require_once "../../route/route_lophoc/lophoc.php";
    $lophoc = new DS_LOPHOC();
    $lophoc_info = $lophoc->get($lichhoc_info['ID_LopHoc']);

    require_once "../../route/route_giangvien/giangvien.php";
    $giangvien = new DS_GIANGVIEN();
    $giangvien_info = $giangvien->get($lophoc_info['ID_GiangVien']);
    if (!$giangvien_info) {
        die("Không tìm thấy thông tin giảng viên.");
    }

    require_once "../../route/route_khoahoc/khoahoc.php";
    $khoahoc = new DS_KHOAHOC();
    $khoahoc_info = $khoahoc->get($lophoc_info['ID_KhoaHoc']);
    if (!$khoahoc_info) {
        die("Không tìm thấy thông tin khóa học.");
    }
    
    require_once "../../route/route_cahoc/cahoc.php";
    $cahoc = new DS_CAHOC();
    $cahoc_info = $cahoc->get($lichhoc_info['ID_CaHoc']);
    if (!$khoahoc_info) {
        die("Không tìm thấy thông tin ca học.");
    }

    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    $lophoc_hocvien = new DS_HOCVIEN_LOPHOC();
    $lophoc_hocvien_info = $lophoc_hocvien->get_hocvien_by_ID_LopHoc($lichhoc_info['ID_LopHoc']);
    
    /////////////////////////////////////////////////////////////////////////////////////////
    // ĐIỂM DANH
    
    require "../../route/route_diemdanh/diemdanh.php";
    $diemdanh = new DS_DIEMDANH();
    if (isset($_POST['DiemDanh'])) {
        $hocvien_ids = isset($_POST['hocvien_ids']) ? $_POST['hocvien_ids'] : []; // Danh sách ID học viên được chọn
    
        // Lấy toàn bộ danh sách học viên trong lớp
        $all_hocvien_ids = [];
        while ($row = mysqli_fetch_assoc($lophoc_hocvien_info)) {
            $all_hocvien_ids[] = $row['ID_HocVien'];
        }
    
        // Duyệt qua tất cả học viên
        foreach ($all_hocvien_ids as $id_hocvien) {
            $id_hocvien = intval($id_hocvien);
    
            if (in_array($id_hocvien, $hocvien_ids)) {
                // Học viên có mặt
                if ($diemdanh->check_diemdanh_exists($id_hocvien, $get_id)) {
                    $diemdanh->update($get_id, $id_hocvien, "Có mặt");
                    
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Điểm danh thành công!";
                    $_SESSION['status_type'] = "success"; // success, error, warning
                } else {
                    $diemdanh->add_diemdanh($get_id, $id_hocvien, "Có mặt");
                    
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Điểm danh thành công!";
                    $_SESSION['status_type'] = "success"; // success, error, warning
                }
            } else {
                // Học viên vắng mặt
                if ($diemdanh->check_diemdanh_exists($id_hocvien, $get_id)) {
                    $diemdanh->update($get_id, $id_hocvien, "Vắng mặt");
                    
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Điểm danh thành công!";
                    $_SESSION['status_type'] = "success"; // success, error, warning
                } else {
                    $diemdanh->add_diemdanh($get_id, $id_hocvien, "Vắng mặt");
                    
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Điểm danh thành công!";
                    $_SESSION['status_type'] = "success"; // success, error, warning
                }
            }
        }
        
        $lichhoc->update_lichhoc($get_id);
        
        // Sau khi thêm, xóa, hoặc cập nhật thành công:
        $_SESSION['status_message'] = "Điểm danh thành công!";
        $_SESSION['status_type'] = "success"; // success, error, warning
        
        header("Location: " . $_SERVER['PHP_SELF'] . "?ID_LichHoc=" . urlencode($get_id));
        exit();
        
    }
    
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
                        <img src="../route_giangvien/ANHGV/<?= htmlspecialchars($giangvien_info['AnhGV']) ?>" alt="Giảng viên" class="col-5">
                        <div class="info_giangvien col">
                            <div class="tengv text-uppercase my-2"><?= htmlspecialchars($giangvien_info['TenGV']) ?></div>
                            <div class="sdt_giangvien my-2"><strong class="me-1">SĐT: </strong><?= htmlspecialchars($giangvien_info['SDT']) ?></div>
                            <div class="email_giangvien my-2"><strong class="me-1">Email: </strong><?= htmlspecialchars($giangvien_info['Email']) ?></div>
                            <div class="ngaysinh_giangvien my-2"><strong class="me-1">Ngày Sinh: </strong><?= htmlspecialchars($giangvien_info['NgaySinh']) ?></div>
                        </div>
                    </div>
                    <!-- Khóa học -->
                    <div class="khoahoc">
                        <strong class="me-3">Khóa học:</strong> <?= htmlspecialchars($khoahoc_info['TenKH']) ?>
                    </div>
                    <!-- Lớp học -->
                    <div class="lophoc">
                        <strong class="me-3">Lớp học:</strong> <?= htmlspecialchars($lophoc_info['TenLop']) ?>
                    </div>
                    <!-- Ca học -->
                    <div class="khoahoc">
                        <strong class="me-3">Ca học:</strong> <?= htmlspecialchars($cahoc_info['Ten_CaHoc']) ?> : <?= htmlspecialchars($cahoc_info['Gio_BD']) ?> - <?= htmlspecialchars($cahoc_info['Gio_KT']) ?> 
                    </div>
                    <!-- Ngày học -->
                    <div class="lophoc">
                        <strong class="me-3">Ngày học:</strong> <?= htmlspecialchars($lichhoc_info['NgayHoc']) ?>
                    </div>
                </div>
                <!-- Danh sách học viên (Bảng) -->
                <div class="col-md-8">
                    <div class="table-container">
                        <h4 class="mb-3 text-uppercase fw-bold">Danh Sách Học Viên</h4>
                        <form action="" method="POST">
                            <table class="table table-striped table-hover text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">STT</th>
                                        <th style="width: 50px;">MSHV</th>
                                        <th>Tên Học Viên</th>
                                        <th>Email</th>
                                        <th style="width: 120px;">SĐT</th>
                                        <th style="width: 120px;">Ngày Sinh</th>
                                        <th style="width: 100px;">Điểm Danh</th> <!-- Cột mới để chứa radio buttons -->
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php 
                                        $num=0;
                                        while($lophoc_info_hv = mysqli_fetch_assoc($lophoc_hocvien_info)){ 
                                            $num++;
                                            require_once "../../route/route_hocvien/hocvien.php";
                                            $hocvien = new DS_HOCVIEN();
                                            $hocvien_info = $hocvien->get($lophoc_info_hv['ID_HocVien']);
                                            
                                            // Kiểm tra điểm danh của học viên này
                                            require_once "../../route/route_diemdanh/diemdanh.php";
                                            $diemdanh = new DS_DIEMDANH();
                                            $is_present = $diemdanh->check_diemdanh_exists($hocvien_info['ID_HocVien'], $get_id) && 
                                                        $diemdanh->get_TrangThai($hocvien_info['ID_HocVien'], $get_id) == "Có mặt";
                                    ?>
                                        <tr>
                                            <td class="align-middle" style="width: 50px;"><?=$num?></td>
                                            <td class="align-middle" style="width: 50px;"><?=$hocvien_info['ID_HocVien']?></td>
                                            <td class="align-middle"><?=$hocvien_info['TenHV']?></td>
                                            <td class="align-middle"><?=$hocvien_info['Email']?></td>
                                            <td class="align-middle" style="width: 120px;"><?=$hocvien_info['SDT']?></td>
                                            <td class="align-middle" style="width: 120px;"><?=$hocvien_info['NgaySinh']?></td>
                                            <td class="align-middle" style="width: 100px;">
                                                <input 
                                                    type="checkbox" 
                                                    name="hocvien_ids[]" 
                                                    value="<?= $hocvien_info['ID_HocVien'] ?>" 
                                                    id="hocvien_<?= $hocvien_info['ID_HocVien'] ?>"
                                                    <?php if ($is_present) echo 'checked'; ?>  />
                                                <label for="hocvien_<?= $hocvien_info['ID_HocVien'] ?>">Có mặt</label>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" name="DiemDanh">Lưu Điểm Danh</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Kiểm tra thông báo trong session PHP
            <?php if (isset($_SESSION['status_message'])): ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['status_type']; ?>', // success, error, warning
                title: '<?php echo $_SESSION['status_message']; ?>',
                showConfirmButton: false,
                timer: 3000
            });
            <?php unset($_SESSION['status_message'], $_SESSION['status_type']); ?>
            <?php endif; ?>
        });
        document.addEventListener("DOMContentLoaded", function () {
            // Kiểm tra thông báo trong session PHP
            <?php if (isset($_SESSION['status_message'])): ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['status_type']; ?>', // success, error, warning
                title: '<?php echo $_SESSION['status_message']; ?>',
                showConfirmButton: false,
                timer: 3000
            });
            <?php unset($_SESSION['status_message'], $_SESSION['status_type']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
