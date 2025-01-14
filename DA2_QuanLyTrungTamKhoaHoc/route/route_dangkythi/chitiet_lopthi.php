<?php
    require_once "../../route/db_connect.php";
    session_start();

    // Kiểm tra quyền truy cập
    if (!isset($_SESSION['GV_NAME'])) {
        header("Location: ../../pages/admin_pages/index.php");
        exit();
    }

    // Nhập các lớp cần thiết
    require_once "../../route/route_dangkythi/dangky_thi.php";
    require_once "../../route/route_lophoc/lophoc.php";
    require_once "../../route/route_giangvien/giangvien.php";
    require_once "../../route/route_khoahoc/khoahoc.php";
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    require_once "../../route/route_diemthi/diemthi.php";

    // Lấy ID Đăng ký thi từ GET
    $get_id = $_GET['ID_LopHoc'] ?? null;


    // Lấy thông tin liên quan
    $dkthi = new DS_DKTHI();
    $lophoc = new DS_LOPHOC();
    $giangvien = new DS_GIANGVIEN();
    $khoahoc = new DS_KHOAHOC();
    $lophoc_hocvien = new DS_HOCVIEN_LOPHOC();
    $diemthi = new DS_DIEMTHI();

    $id_dangky = $dkthi->get_ID_DangKyThi_by_ID_LopHoc($get_id);
    $dkthi_info = $dkthi->get($id_dangky);
    $lophoc_info = $lophoc->get($dkthi_info['ID_LopHoc']);
    $giangvien_info = $giangvien->get($lophoc_info['ID_GiangVien']);
    $khoahoc_info = $khoahoc->get($lophoc_info['ID_KhoaHoc']);
    $lophoc_hocvien_info = $lophoc_hocvien->get_hocvien_by_ID_LopHoc($dkthi_info['ID_LopHoc']);

    // Xử lý lưu điểm thi
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['DiemThi'])) {
        $diem = $_POST['diem'] ?? []; // Lấy dữ liệu điểm từ form
    
        // Lấy số lần đăng ký thi của lớp
        $soLanDangKy = $dkthi->COUNT_LopHoc_IN_DS_DKTHI($lophoc_info['ID_LopHoc']);
    
        foreach ($diem as $id_hocvien => $columns) {
            // Lấy tất cả các giá trị của cột, nếu trống thì lưu giá trị rỗng
            $cot1 = $columns['Cot1'] ?? 0;
            $cot2 = $columns['Cot2'] ?? 0;
            $cot3 = $columns['Cot3'] ?? 0;
            $cot4 = $columns['Cot4'] ?? 0;
            $cot5 = $columns['Cot5'] ?? 0;
            $cot6 = $columns['Cot6'] ?? 0;
    
            // Tính Diem_TB: Tổng các cột điểm chia cho số lần đăng ký
            $diem_tb = $soLanDangKy > 0 ? ($cot1 + $cot2 + $cot3 + $cot4 + $cot5 + $cot6) / $soLanDangKy : 0;
    
            // Kiểm tra điểm thi đã tồn tại chưa, thêm mới hoặc cập nhật
            if ($diemthi->check_diemthi_exists($id_hocvien, $get_id)) {
                // Cập nhật nếu đã tồn tại
                $diemthi->update($get_id, $id_hocvien, $cot1, $cot2, $cot3, $cot4, $cot5, $cot6, $diem_tb);
            } else {
                // Thêm mới nếu chưa tồn tại
                $diemthi->add_diemthi($get_id, $id_hocvien, $cot1, $cot2, $cot3, $cot4, $cot5, $cot6, $diem_tb);
            }
        }
    
        // Cập nhật trạng thái đăng ký thi
        $dkthi->update_trangThaiDKTHI($get_id);
    
        $_SESSION['status_message'] = "Nhập điểm thi thành công!";
        $_SESSION['status_type'] = "success";
        header("Location: " . $_SERVER['PHP_SELF'] . "?ID_LopHoc=" . urlencode($get_id));
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
            <!-- Hàng đầu tiên: Thông tin giảng viên -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="giangvien d-flex p-3">
                        <img src="../route_giangvien/ANHGV/<?=$giangvien_info['AnhGV']?>" alt="Giảng viên" class="giangvien-img me-4">
                        <div class="info_giangvien">
                            <div class="tengv text-uppercase mb-2"><?=$giangvien_info['TenGV']?></div>
                            <div class="sdt_giangvien mb-2"><strong>SĐT:</strong> <?=$giangvien_info['SDT']?></div>
                            <div class="email_giangvien mb-2"><strong>Email:</strong> <?=$giangvien_info['Email']?></div>
                            <div><strong>Khóa học:</strong> <?=$khoahoc_info['TenKH']?></div>
                            <div><strong>Lớp học:</strong> <?=$lophoc_info['TenLop']?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hàng thứ hai: Bảng danh sách học viên -->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-container">
                        <h4 class="text-uppercase fw-bold mb-3">Danh Sách Học Viên</h4>
                        <form action="" method="POST">
                            <table class="table table-striped table-hover text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 8%;">STT</th>
                                        <th style="width: 10%;">MSHV</th>
                                        <th style="width: 33%;">Tên Học Viên</th>
                                        <th style="width: 8%;">Cột 1</th>
                                        <th style="width: 8%;">Cột 2</th>
                                        <th style="width: 8%;">Cột 3</th>
                                        <th style="width: 8%;">Cột 4</th>
                                        <th style="width: 8%;">Cột 5</th>
                                        <th style="width: 8%;">Cột 6</th>
                                        <th style="width: 8%;">Điểm TB</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $num = 0;
                                    while ($row = mysqli_fetch_assoc($lophoc_hocvien_info)) {
                                        $num++;
                                        $diemThi = $diemthi->get_diem_hocvien($get_id, $row['ID_HocVien']) ?? []; // Lấy điểm từ CSDL
                                        require_once "../../route/route_hocvien/hocvien.php";
                                        $hocvien = new DS_HOCVIEN();
                                        $hocvien_name = $hocvien->get_name_by_id($row['ID_HocVien']);

                                        // Đảm bảo tất cả các giá trị đều không bị null
                                        $cot1 = $diemThi['Cot1'] ?? '0';
                                        $cot2 = $diemThi['Cot2'] ?? '0';
                                        $cot3 = $diemThi['Cot3'] ?? '0';
                                        $cot4 = $diemThi['Cot4'] ?? '0';
                                        $cot5 = $diemThi['Cot5'] ?? '0';
                                        $cot6 = $diemThi['Cot6'] ?? '0';
                                        $diemTB = $diemThi['Diem_TB'] ?? '0';
                                    ?>
                                        <tr>
                                            <td style="width: 8%;"><?=$num?></td>
                                            <td style="width: 10%;"><?=$row['ID_HocVien']?></td>
                                            <td style="width: 33%;"><?=htmlspecialchars($hocvien_name)?></td>
                                            <td style="width: 8%;"><input type="text" name="diem[<?=$row['ID_HocVien']?>][Cot1]" value="<?=htmlspecialchars($cot1)?>"></td>
                                            <td style="width: 8%;"><input type="text" name="diem[<?=$row['ID_HocVien']?>][Cot2]" value="<?=htmlspecialchars($cot2)?>"></td>
                                            <td style="width: 8%;"><input type="text" name="diem[<?=$row['ID_HocVien']?>][Cot3]" value="<?=htmlspecialchars($cot3)?>"></td>
                                            <td style="width: 8%;"><input type="text" name="diem[<?=$row['ID_HocVien']?>][Cot4]" value="<?=htmlspecialchars($cot4)?>"></td>
                                            <td style="width: 8%;"><input type="text" name="diem[<?=$row['ID_HocVien']?>][Cot5]" value="<?=htmlspecialchars($cot5)?>"></td>
                                            <td style="width: 8%;"><input type="text" name="diem[<?=$row['ID_HocVien']?>][Cot6]" value="<?=htmlspecialchars($cot6)?>"></td>
                                            <td style="width: 8%;"><input type="text" name="diem[<?=$row['ID_HocVien']?>][Diem_TB]" value="<?=htmlspecialchars($diemTB)?>"></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary" name="DiemThi">Lưu Điểm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- checkbox-input -->
    <script>
        function toggleCheckbox(hocVienId) {
            // Lấy input nhập điểm
            const diemInput = document.getElementById(`diem_${hocVienId}`);
            // Lấy checkbox tương ứng
            const checkbox = document.getElementById(`hocvien_${hocVienId}`);
            
            // Nếu có giá trị trong ô nhập điểm, check checkbox; ngược lại, bỏ check
            if (diemInput.value.trim() !== "") {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        }
    </script>
    
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