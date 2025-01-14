<?php
    require_once "../route_giangvien/giangvien.php";

    $giangvien = new DS_GIANGVIEN();

    // Lấy từ khóa tìm kiếm từ yêu cầu POST
    $tengv = isset($_POST['TenGV']) ? $_POST['TenGV'] : '';

    if (!empty($tengv)) {
        // Nếu có từ khóa tìm kiếm, gọi hàm search_giangvien
        $query = $giangvien->search_giangvien($tengv);
    } else {
        // Nếu không có từ khóa tìm kiếm, gọi hàm show_all
        $query = $giangvien->show_all();
    }

    // Kiểm tra và hiển thị kết quả
    if ($query && mysqli_num_rows($query) > 0) {
        echo '<table class="table table-striped table-hover text-center">';
        echo '<thead class="table-dark">
                <tr>
                    <th>Họ và Tên</th>
                    <th>Giới Tính</th>
                    <th>Hình Ảnh</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Ngày Sinh</th>
                    <th>Actions</th>
                </tr>
            </thead>';
        echo '<tbody>';
        while ($row_giangvien = mysqli_fetch_assoc($query)) {
            echo '<tr>
                    <td class="align-middle">' . htmlspecialchars($row_giangvien['TenGV']) . '</td>
                    <td class="align-middle">
                        <img src="../../route/route_giangvien/ANHGV/' . htmlspecialchars($row_giangvien['AnhGV']) . '" alt="Ảnh giảng viên" class="img-fluid rounded">
                    </td>
                    <td class="align-middle">' . htmlspecialchars($row_giangvien['Email']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_giangvien['GioiTinh']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_giangvien['SDT']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_giangvien['NgaySinh']) . '</td>
                    <td class="align-middle">
                        <button class="btn btn-outline-primary btn-sm px-3" onclick="location.href=\'../../route/route_giangvien/edit_giangvien.php?ID_GiangVien=' . $row_giangvien['ID_GiangVien'] . '\'">SỬA</button>
                        <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete(\'../../route/route_giangvien/delete_giangvien.php?ID_GiangVien=' . $row_giangvien['ID_GiangVien'] . '\', \'' . htmlspecialchars($row_giangvien['TenGV']) . '\')">XÓA</button>
                    </td>
                </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<p class='text-center'>Không tìm thấy kết quả nào.</p>";
    }
?>
