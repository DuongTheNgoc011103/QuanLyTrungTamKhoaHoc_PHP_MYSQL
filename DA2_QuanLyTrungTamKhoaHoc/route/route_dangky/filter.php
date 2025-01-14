<?php
    require_once "./dangky.php";
    require_once "../../route/route_hocvien/hocvien.php";
    require_once "../../route/route_khoahoc/khoahoc.php";

    $dangky = new DS_DANGKY();
    $hocvien = new DS_HOCVIEN();
    $khoahoc = new DS_KHOAHOC();
    
    // Nhận giá trị của trạng thái đăng ký từ yêu cầu GET
    $status = isset($_GET['TrangThai_DK']) ? $_GET['TrangThai_DK'] : '';

    // Tạo câu lệnh SQL để lọc
    $sql = "SELECT * FROM dangky WHERE 1";
    if ($status) {
        $sql .= " AND TrangThai_DK = '" . mysqli_real_escape_string($dangky->conn(), $status) . "'";
    }

    $result = mysqli_query($dangky->conn(), $sql);

    // Kiểm tra và hiển thị kết quả
    if (mysqli_num_rows($result) > 0) {
        while ($row_dk = mysqli_fetch_assoc($result)) {
            require_once "../../route/route_lophoc/lophoc.php";
            $lophoc = new DS_LOPHOC();
            $id_khoahoc = $lophoc->get_khoahoc_by_lophoc($row_dk['ID_LopHoc']);
            
            echo "<tr>";
                echo "<td class='align-middle'>{$hocvien->get_name_by_id($row_dk['ID_HocVien'])}</td>";
                echo "<td class='align-middle'>{$lophoc->get_TenLop_By_ID_LopHoc($row_dk['ID_LopHoc'])}</td>";
                echo "<td class='align-middle'>" . number_format($khoahoc->get_hocphi_by_id($id_khoahoc), 0, ',', '.') . " VNĐ</td>";
                echo "<td class='align-middle'>{$row_dk['NgayDK']}</td>";
                echo "<td class='align-middle'>";
                
                    // Kiểm tra trạng thái đăng ký
                    if ($row_dk['TrangThai_DK'] === 'Chờ xác nhận') {
                        echo "<span class='badge px-3 py-2 bg-primary'>" . htmlspecialchars($row_dk['TrangThai_DK']) . "</span>";
                    } elseif ($row_dk['TrangThai_DK'] === 'Đã sắp lớp') {
                        echo "<span class='badge px-3 py-2 bg-success'>" . htmlspecialchars($row_dk['TrangThai_DK']) . "</span>";
                    } elseif ($row_dk['TrangThai_DK'] === 'Đã xác nhận') {
                        echo "<span class='badge px-3 py-2 bg-secondary'>" . htmlspecialchars($row_dk['TrangThai_DK']) . "</span>";
                    }
        
                echo "</td>";
        
                echo "<td class='align-middle'>";
                
                    // Nút xác nhận
                    if ($row_dk['TrangThai_DK'] === 'Chờ xác nhận') {
                        echo "<button class='btn btn-outline-primary btn-sm px-3 me-1' onclick=\"confirmXacNhan('../../route/route_dangky/xacnhan_dangky.php?ID_DangKy={$row_dk['ID_DangKy']}', '{$hocvien->get_name_by_id($row_dk['ID_HocVien'])}')\">Xác Nhận</button>";
                    } elseif ($row_dk['TrangThai_DK'] === 'Đã xác nhận') {
                        echo "<button class='btn btn-outline-secondary btn-sm px-3 me-1' disabled>Xác Nhận</button>";
                    } elseif ($row_dk['TrangThai_DK'] === 'Đã sắp lớp') {
                        echo "<button class='btn btn-outline-success btn-sm px-3 me-1' disabled>Xác Nhận</button>";
                    }
            
                // Nút xóa
                // echo "<button class='btn btn-outline-danger btn-sm px-3' onclick=\"confirmDelete('../../route/route_dangky/delete_dangky.php?ID_DangKy={$row_dk['ID_DangKy']}', '{$row_dk['ID_DangKy']}')\">XÓA</button>";
                echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Không có kết quả nào.</td></tr>";
    }
    

?>
