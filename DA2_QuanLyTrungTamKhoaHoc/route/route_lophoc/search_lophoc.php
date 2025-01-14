<?php
    require_once "../route_lophoc/lophoc.php"; // Điều chỉnh đường dẫn

    $lophoc = new DS_LOPHOC();

    // Lấy từ khóa tìm kiếm từ yêu cầu POST
    $tenlop = isset($_POST['TenLop']) ? $_POST['TenLop'] : '';
    
    if (!empty($tenlop)) {
        // Nếu có từ khóa tìm kiếm, gọi hàm search_hocvien
        $query = $lophoc->search_lophoc($tenlop);
    } else {
        // Nếu không có từ khóa tìm kiếm, gọi hàm show_all
        $query = $lophoc->show_all();
    }

    // Kiểm tra và hiển thị kết quả
    if ($query && mysqli_num_rows($query) > 0) {
        echo '<table class="table table-striped table-hover text-center">';
        echo '<thead class="table-dark">
                <tr>
                    <th>Tên Lớp</th>
                    <th>Tên Khóa Học</th>
                    <th>Số Buổi</th>
                    <th>Số Lượng HV</th>
                    <th>Trạng Thái</th>
                    <th>Actions</th>
                </tr>
            </thead>';
        echo '<tbody>';
        while ($row_lh = mysqli_fetch_assoc($query)) {
            
            $id_lophoc = $row_lh['ID_LopHoc'];
            $id_khoahoc = $row_lh['ID_KhoaHoc'];

            require_once "../../route/route_LH_HV/lophoc_hocvien.php";
            $hv_lh = new DS_HOCVIEN_LOPHOC();
            $query_count_hv = mysqli_query($hv_lh->conn(), "SELECT COUNT(*) AS SoLuong_HV FROM hocvien_lophoc WHERE ID_LopHoc = '$id_lophoc'");
            $count_result = mysqli_fetch_assoc($query_count_hv);
            $soLuong_HV = $count_result['SoLuong_HV'];
            
            
            require_once "../../route/route_khoahoc/khoahoc.php";
            $kh = new DS_KHOAHOC();
            $khoahoc_info = $kh->get_name_by_id($id_khoahoc);
            
            require_once "../../route/route_lophoc/lophoc.php";
            $lh = new DS_LOPHOC();
            $soBuoi = $lh->soBuoi_cua_LopHoc($id_lophoc);
            
            echo '<tr>
                    <td class="align-middle">' . htmlspecialchars($row_lh['TenLop']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($khoahoc_info) . '</td>
                    <td class="align-middle">' . htmlspecialchars($soBuoi) . '</td>
                    <td class="align-middle">' . htmlspecialchars($soLuong_HV) . '</td>
                    <td class="align-middle">
                        <span class="badge px-3 py-2 ' . ($row_lh['TrangThai_Lop'] === 'Đang học' ? "bg-primary" : "bg-success") . '">' . htmlspecialchars($row_lh['TrangThai_Lop']) . '</span>
                    </td>
                    <td class="align-middle">
                        <button class="btn btn-outline-primary btn-sm px-3" onclick="location.href=\'../../route/route_lophoc/chitiet_lophoc.php?ID_LopHoc=' . $row_lh['ID_LopHoc'] . '\'">XEM</button>
                        <button class="btn btn-outline-success btn-sm px-3 btn-themHV" disabled data-id_lophoc="' . htmlspecialchars($row_lh['ID_LopHoc']) . '">THÊM HỌC VIÊN</button>
                        <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete(\'../../route/route_lophoc/delete_lophoc.php?ID_LopHoc=' . $row_lh['ID_LopHoc'] . '\', \'' . htmlspecialchars($row_lh['TenLop']) . '\')">XÓA</button>
                    </td>
                </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<p class='text-center'>Không tìm thấy kết quả nào.</p>";
    }
?>
