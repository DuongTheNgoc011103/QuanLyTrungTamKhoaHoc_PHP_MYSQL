<?php

session_start();    

$GV_NAME = isset($_SESSION['GV_NAME']) ? $_SESSION['GV_NAME'] : '';
$id_TK = isset($_SESSION['ID_TaiKhoan']) ? $_SESSION['ID_TaiKhoan'] : '';

require_once "../../route/route_lichhoc/lichhoc.php";
$lichhoc = new DS_LICHHOC();

$id_lophoc = isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';

if (!empty($id_lophoc)) {
    // Lấy danh sách các ngày học từ cơ sở dữ liệu
    $query_days = "SELECT DISTINCT NgayHoc FROM lichhoc WHERE ID_LopHoc = '$id_lophoc' ORDER BY NgayHoc ASC";
    $result_days = mysqli_query($lichhoc->conn(), $query_days);

    $days = [];
    while ($row_day = mysqli_fetch_assoc($result_days)) {
        $days[] = $row_day['NgayHoc'];
    }

    require_once "../../route/route_cahoc/cahoc.php";
    $cahoc = new DS_CAHOC();
    $query_cahoc = "SELECT * FROM cahoc";
    $result_cahoc = mysqli_query($cahoc->conn(), $query_cahoc);

    if ($result_cahoc->num_rows > 0) {
        echo '<table class="table table-striped table-hover text-center">';
        echo '<thead>';
        echo '<tr>';
        echo '<th class="align-middle bg-dark text-light" style="width: 100px;">Ca Học\Ngày</th>';

        foreach ($days as $day) {
            echo "<th class='align-middle bg-secondary text-light' style='width: 200px;'>" . date("d/m/Y", strtotime($day)) . "</th>";
        }

        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row_cahoc = $result_cahoc->fetch_assoc()) {
            echo '<tr>';
            echo "<td  class='align-middle bg-secondary text-light' style='width: 100px;'>" . htmlspecialchars($row_cahoc['Ten_CaHoc']) . " ({$row_cahoc['Gio_BD']} - {$row_cahoc['Gio_KT']})</td>";

            foreach ($days as $day) {
                $query_lichhoc = "
                    SELECT * FROM lichhoc 
                    WHERE ID_CaHoc = '{$row_cahoc['ID_CaHoc']}' 
                    AND NgayHoc = '$day' 
                    AND ID_LopHoc = '$id_lophoc'";
                $result_lichhoc = mysqli_query($lichhoc->conn(), $query_lichhoc);

                if (mysqli_num_rows($result_lichhoc) > 0) {
                    $row_lichhoc = mysqli_fetch_assoc($result_lichhoc);
                    
                    require_once "../../route/route_lophoc/lophoc.php";
                    $lophoc = new DS_LOPHOC();
                    $lophoc_info = $lophoc->get($row_lichhoc['ID_LopHoc']);
                    
                    $id_giangvien = $lophoc_info['ID_GiangVien'];
                    require_once "../../route/route_giangvien/giangvien.php";
                    $giangvien = new DS_GIANGVIEN();
                    $giangvien_info = $giangvien->get($id_giangvien);
                    
                    require_once "../../route/route_khoahoc/khoahoc.php";
                    $khoahoc = new DS_KHOAHOC();
                    $id_khoahoc = $lophoc->get_khoahoc_by_lophoc($row_lichhoc['ID_LopHoc']);
                    
                    $khoahoc_info = $khoahoc->get_name_by_id($id_khoahoc);
                    
                    // Thay đổi màu dựa trên trạng thái
                    if ($row_lichhoc['TrangThai_Lich'] === 'Đã điểm danh') {
                        $badge_class = 'bg-success'; // Màu xanh cho 'Đã điểm danh'
                    } elseif ($row_lichhoc['TrangThai_Lich'] === 'Đang học') {
                        $badge_class = 'bg-primary'; // Màu đỏ cho 'Chưa học'
                    }

                    echo "<td class='align-middle'>
                            <div class='badge {$badge_class} px-3 py-2' style='height: 140px; width: 100%;'>
                                <div class='lophoc_info_head d-flex justify-content-between'>
                                    <span class='d-flex align-items-center justify-content-center me-2'>" . htmlspecialchars($lophoc_info['TenLop']) . "</span>  
                                    <button class='btn btn-light btn-sm py-0 me-1' onclick=\"location.href='../../route/route_lichhoc/chitiet_lichhoc.php?ID_LichHoc={$row_lichhoc['ID_LichHoc']}'\">XEM</button>
                                    <button class='btn btn-danger btn-sm py-0 " . (isset($_SESSION['GV_NAME']) ? 'd-none' : '') . "' onclick=\"confirmDelete('../../route/route_lichhoc/delete_lichhoc.php?ID_LichHoc={$row_lichhoc['ID_LichHoc']}', 'Lịch học này')\">XÓA</button>
                                </div>
                                <div class='lophoc_body mt-3 text-start d-flex justify-content-around flex-column'>
                                    <span>" . htmlspecialchars($khoahoc_info) . "</span>  
                                    <br />
                                    <span>Giảng viên: " . htmlspecialchars($giangvien_info['TenGV']) . "</span>  
                                    <br />
                                    <span>Phòng học: " . htmlspecialchars($row_lichhoc['Phong']) . "</span>  
                                </div>
                            </div>
                        </td>";

                } else {
                    echo "<td class='align-middle'><button class='btn btn-secondary btn-sm'></button></td>";
                }
            }

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="text-center text-danger">Không tìm thấy ca học nào.</p>';
    }
} else {
    echo '<p class="text-center text-danger">Vui lòng chọn một lớp học.</p>';
}

?>
