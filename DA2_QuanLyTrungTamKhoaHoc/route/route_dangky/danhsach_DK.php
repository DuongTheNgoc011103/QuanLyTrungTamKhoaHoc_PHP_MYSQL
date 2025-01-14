<?php
    session_start();

    require_once "../../route/route_dangky/dangky.php";
    $ds_dk = new DS_DANGKY();
    $query_dk = $ds_dk->get_DS_by_TrangThai_DK();

    // Kết nối các lớp khác để lấy thông tin khóa học và Lớp Học
    require_once "../../route/route_khoahoc/khoahoc.php";
    $kh = new DS_KHOAHOC();

    require_once "../../route/route_hocvien/hocvien.php";
    $hv = new DS_HOCVIEN();
    
    require_once "../../route/route_lophoc/lophoc.php";
    $lp = new DS_LOPHOC();
    
    
    // OPTIONS LỚP HỌC
    
    // Truy vấn tất cả các lớp học và thêm tên khóa học
    $query_lp = $lp->show_all();
    $optionsLH = '';
    while ($row_lhOption = mysqli_fetch_assoc($query_lp)) {
        $id_khoahoc = $row_lhOption['ID_KhoaHoc'];
        $ten_khoahoc = $kh->get_name_by_id($id_khoahoc); // Lấy tên khóa học từ ID_KhoaHoc
        $optionsLH .= '<option value="' . htmlspecialchars($row_lhOption['ID_LopHoc']) . '">'
                    . htmlspecialchars($row_lhOption['ID_LopHoc']) . ' - ' . htmlspecialchars($row_lhOption['TenLop']) 
                    . ' (' . htmlspecialchars($ten_khoahoc) . ')' . '</option>';
    }
    
    require_once "../../route/route_LH_HV/lophoc_hocvien.php";
    $LH_HV = new DS_HOCVIEN_LOPHOC();
    
    // THÊM NHIỀU HỌC VIÊN VÀO LỚP HỌC
    $success = false; // Biến báo hiệu thêm thành công

    if (isset($_POST['submitAddHV'])) {
        // Lấy dữ liệu từ form
        $hocvien_ids = $_POST['hocvien_ids'];
        $id_lophoc = $_POST['id_lophoc'];
    
    
        foreach ($hocvien_ids as $id_hocvien) {
            $checkExistQuery = "SELECT COUNT(*) FROM hocvien_lophoc WHERE ID_HocVien = '$id_hocvien' AND ID_LopHoc = '$id_lophoc'";
            $result = mysqli_query($LH_HV->conn(), $checkExistQuery);
            $row = mysqli_fetch_row($result);
    
            // if ($row[0] == 0) {
            //     // Thêm học viên vào lớp
            //     $LH_HV->add_hocvien_lophoc($id_hocvien, $id_lophoc);
    
            //     // Cập nhật trạng thái đăng ký
            //     $ds_dk->update_TrangThai_DK($id_hocvien, $id_khoahoc);
    
            //     // Tăng số lượng học viên
            //     $updateSL = "UPDATE lophoc SET SoLuong_HV = SoLuong_HV + 1 WHERE ID_LopHoc = '$id_lophoc'";
            //     mysqli_query($LH_HV->conn(), $updateSL);
    
            //     $_SESSION['success'] = true;
            // }
            if ($row[0] > 0) {
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Học viên này đã tồn tại trong lớp này.";
                $_SESSION['status_type'] = "error"; // success, error, warning
                
                // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }else {
            
                $lophoc_dangky = $ds_dk->get_LopHoc_By_ID_HocVien($id_hocvien);
                
                // Kiểm tra xem 2 khóa học đăng ký và lóp học có cùng nhau không
                if(in_array($id_lophoc, $lophoc_dangky)) {
                    require_once "../../route/route_dangkythi/dangky_thi.php";
                    $dkTHI = new DS_DKTHI();
                    
                    $trangthai_DKTHI = $dkTHI->get_LopHoc($id_lophoc);
                    if($trangthai_DKTHI == 'Đang thi'){
                        
                        // Sau khi thêm, xóa, hoặc cập nhật thành công:
                        $_SESSION['status_message'] = "Không thể thêm học viên vào lớp này được nữa!";
                        $_SESSION['status_type'] = "error"; // success, error, warning
    
                        // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                    else{
                        // Nếu chưa tồn tại, thêm học viên vào lớp
                        $LH_HV->add_hocvien_lophoc($id_hocvien, $id_lophoc);
                        
                        if ($ds_dk->update_TrangThai_DK($id_hocvien, $id_lophoc)) {
                            echo "TrangThai_DK updated successfully!";
                        } else {
                            echo "Failed to update TrangThai_DK.";
                        }
                        
                        // CẬP NHẬT TỔNG TIỀN CHO HÓA ĐƠN
                        require_once "../../route/route_lophoc/lophoc.php";
                        $lophoc = new DS_LOPHOC();
                        $lophoc_info = $lophoc->get($id_lophoc);
                        
                        require_once "../../route/route_khoahoc/khoahoc.php";
                        $khoahoc = new DS_KHOAHOC();
                        $id_khoahoc = $lophoc_info['ID_KhoaHoc'];
                        $price_khoahoc = $khoahoc->get_hocphi($id_khoahoc);
                        
                        require_once "../../route/route_hoadon/hoadon.php";
                        $hoadon = new DS_HOADON();
                        $updateTongTien = "UPDATE hoadon SET TongTien = TongTien + $price_khoahoc WHERE ID_LopHoc = '$id_lophoc'";
                        mysqli_query($hoadon->conn(), $updateTongTien);
                        
                        // Sau khi thêm, xóa, hoặc cập nhật thành công:
                        $_SESSION['status_message'] = "Thêm học viên cho lớp học thành công!";
                        $_SESSION['status_type'] = "success"; // success, error, warning
    
                        // Cập nhật số lượng học viên trong lớp
                        $updateSL = "UPDATE lophoc SET SoLuong_HV = SoLuong_HV + 1 WHERE ID_LopHoc = '$id_lophoc'";
                        mysqli_query($LH_HV->conn(), $updateSL);
    
                        // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                }
                else{
                    $_SESSION['status_message'] = "Sắp sai lớp cho học viên!";
                    $_SESSION['status_type'] = "error"; // success, error, warning
                    
                    // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
        }
        if (!headers_sent()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="../../assets/images/icons/icon-web.png" rel="shortcut icon" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <title>Danh Sách Đăng Ký Đã Xác Nhận</title>
</head>
<body>
    <button class="btn px-4 py-2 top-0 rounded-0 btn-secondary position-fixed btn-back" onclick="window.location.href='../../pages/admin_pages/index.php'">BACK</button>
    
    <div class="container mt-4">
        <h2 class="text-center">Danh Sách Đăng Ký Đã Xác Nhận</h2>
        <form action="" method="POST">
            <table class="table table-bordered table-striped mt-3">
                <button type="button" class="btn bg-success text-light fw-bold btn-sm py-2 btn-themHV w-25">THÊM VÀO LỚP</button>
                <thead>
                    <tr>
                        <th scope="col">Chọn</th>
                        <th scope="col">Học Viên</th>
                        <th scope="col">Lớp Học</th>
                        <th scope="col">Khóa Học</th>
                        <th scope="col">Ngày Đăng Ký</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($query_dk->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($query_dk)) {
                                $ten_lop = $lp->get_TenLop_By_ID_LopHoc($row['ID_LopHoc']);
                                $ten_hocvien = $hv->get_name_by_id($row['ID_HocVien']);
                                
                                $id_khoahoc = $lp->get_khoahoc_by_lophoc($row['ID_LopHoc']);
                                $ten_khoahoc = $kh->get_name_by_id($id_khoahoc);
                            ?>
                            <tr>
                                <td><input type='checkbox' name='hocvien_ids[]' value='<?= $row['ID_HocVien'] ?>'></td>
                                <td><?= htmlspecialchars($ten_hocvien) ?></td>
                                <td><?= htmlspecialchars($ten_lop) ?></td>
                                <td><?= htmlspecialchars($ten_khoahoc) ?></td>
                                <td><?= htmlspecialchars($row['NgayDK']) ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Không có học viên nào đã xác nhận đăng ký</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Modal Thêm vào lớp học -->
            <div class="modal fade" id="themHVModal" tabindex="-1" aria-labelledby="themHVModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content px-4 py-3">
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase" id="themHVModalLabel">Thêm vào Lớp Học</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_lophoc" class="form-label fw-bold">Chọn Lớp Học</label>
                                <select class="form-select" id="id_lophoc" name="id_lophoc" required>
                                    <option value="" selected disabled>Chọn Lớp Học</option>
                                    <?= $optionsLH ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                            <button type="submit" class="btn btn-primary" name="submitAddHV">XÁC NHẬN</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- POPUP THÔNG BÁO THÊM THÀNH CÔNG -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Thông Báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Học viên đã được thêm vào lớp thành công!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    
    <script src="../../assets/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>
    
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
    
    <script>
        document.querySelector(".btn-themHV").addEventListener("click", function() {
            // Hiển thị modal
            const themHVModal = new bootstrap.Modal(document.getElementById('themHVModal'));
            themHVModal.show();
        });
    </script>
    
    <?php if (isset($_SESSION['success']) && $_SESSION['success']): ?>
        <script>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    
</body>
</html>

