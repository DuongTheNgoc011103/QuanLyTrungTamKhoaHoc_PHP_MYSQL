<?php
    // Giả sử đã bắt đầu session
    session_start();

    // Lấy ID_TaiKhoan từ session
    $id_TaiKhoan_Session = isset($_SESSION['ID_TaiKhoan']) ? $_SESSION['ID_TaiKhoan'] : '';


    require_once "../route_nhanvien/taikhoan_nhanvien.php"; // Điều chỉnh đường dẫn

    $taikhoan = new DS_TAIKHOAN();

    // Lấy từ khóa tìm kiếm từ yêu cầu POST
    $tennv = isset($_POST['Ten_TK']) ? $_POST['Ten_TK'] : '';

    if (!empty($tennv)) {
        // Nếu có từ khóa tìm kiếm, gọi hàm search_hocvien
        $query = $taikhoan->search_taikhoan($tennv);
    } else {
        // Nếu không có từ khóa tìm kiếm, gọi hàm show_all
        $query = $taikhoan->show_all();
    }

    // Kiểm tra và hiển thị kết quả
    if ($query && mysqli_num_rows($query) > 0) {
        echo '<table class="table table-striped table-hover text-center">';
        echo '<thead class="table-dark">
                <tr>
                    <th>ID Tài Khoản</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>';
        echo '<tbody>';
        while ($row_taikhoan = mysqli_fetch_assoc($query)) {
            echo '<tr>
                    <td class="align-middle">' . htmlspecialchars($row_taikhoan['ID_TaiKhoan']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_taikhoan['Ten_TK']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_taikhoan['Email']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row_taikhoan['Role']) . '</td>
                    <td class="align-middle">
                        <button class="btn btn-outline-danger btn-sm px-3" 
                            onclick="confirmDelete(\'../../route/route_nhanvien/delete_taikhoan.php?ID_TaiKhoan=' . $row_taikhoan['ID_TaiKhoan'] . '\', \'' . htmlspecialchars($row_taikhoan['Ten_TK']) . '\')"
                            ' . (($row_taikhoan['ID_TaiKhoan'] == $_SESSION['ID_TaiKhoan']) ? 'disabled' : '') . '>
                            XÓA
                        </button>
                    </td>
                </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<p class='text-center'>Không tìm thấy kết quả nào.</p>";
    }
?>
