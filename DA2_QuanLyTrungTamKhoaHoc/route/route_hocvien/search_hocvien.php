<?php
    require_once "../route_hocvien/hocvien.php"; // Điều chỉnh đường dẫn

    $hocvien = new DS_HOCVIEN();

    // Lấy từ khóa tìm kiếm từ yêu cầu POST
    $tenhv = isset($_POST['TenHV']) ? $_POST['TenHV'] : '';

    if (!empty($tenhv)) {
        // Nếu có từ khóa tìm kiếm, gọi hàm search_hocvien
        $query = $hocvien->search_hocvien($tenhv);
    } else {
        // Nếu không có từ khóa tìm kiếm, gọi hàm show_all
        $query = $hocvien->show_all();
    }

    // Kiểm tra và hiển thị kết quả
    if ($query && mysqli_num_rows($query) > 0) {
        echo '<table class="table table-striped table-hover text-center">';
        echo '<thead class="table-dark">
                <tr>
                    <th>Họ và Tên</th>
                    <th>Hình Ảnh</th>
                    <th>Email</th>
                    <th>Giới Tính</th>
                    <th>SĐT</th>
                    <th>Ngày Sinh</th>
                    <th>Trạng Thái</th>
                    <th>Actions</th>
                </tr>
            </thead>';
        echo '<tbody>';
        while ($row_hocvien = mysqli_fetch_assoc($query)) {
            echo '<tr>
                    <td class="align-middle">' . htmlspecialchars($row_hocvien['TenHV']) . '</td>
                    <td class="align-middle">
                        <img src="../../route/route_hocvien/ANHHV/' . htmlspecialchars($row_hocvien['AnhHV']) . '" alt="Ảnh học viên" class="img-fluid rounded">
                    </td>
                    <td class="align-middle">' . htmlspecialchars($row_hocvien['Email']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_hocvien['GioiTinh']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_hocvien['SDT']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_hocvien['NgaySinh']) . '</td>
                    <td class="align-middle">
                        <span class="badge px-3 py-2 ' . ($row_hocvien['TrangThai_HV'] === 'Đang học' ? "bg-success" : "bg-danger") . '">' . htmlspecialchars($row_hocvien['TrangThai_HV']) . '</span>
                    </td>
                    <td class="align-middle">
                        <button class="btn btn-outline-primary btn-sm px-3" onclick="location.href=\'../../route/route_hocvien/edit_hocvien.php?ID_HocVien=' . $row_hocvien['ID_HocVien'] . '\'">SỬA</button>
                        <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete(\'../../route/route_hocvien/delete_hocvien.php?ID_HocVien=' . $row_hocvien['ID_HocVien'] . '\', \'' . htmlspecialchars($row_hocvien['TenHV']) . '\')">XÓA</button>
                    </td>
                </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<p class='text-center'>Không tìm thấy kết quả nào.</p>";
    }
?>
