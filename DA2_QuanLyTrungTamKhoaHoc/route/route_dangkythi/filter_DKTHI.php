<?php
    session_start();

    require_once "./dangky_thi.php";
    require_once "../../route/route_lophoc/lophoc.php";
    require_once "../../route/route_cahoc/cahoc.php";

    $dangkythi = new DS_DKTHI();
    $lophoc = new DS_LOPHOC();
    $cahoc = new DS_CAHOC();
    
    // Nhận giá trị của trạng thái đăng ký từ yêu cầu GET
    $status = isset($_GET['TrangThai_DKThi']) ? $_GET['TrangThai_DKThi'] : '';

    // Tạo câu lệnh SQL để lọc
    $sql = "SELECT * FROM dangkythi WHERE 1";
    if ($status) {
        $sql .= " AND TrangThai_DKThi = '" . mysqli_real_escape_string($dangkythi->conn(), $status) . "'";
    }

    $result = mysqli_query($dangkythi->conn(), $sql);

    // Kiểm tra và hiển thị kết quả
    if (mysqli_num_rows($result) > 0) {
        while ($row_dkthi = mysqli_fetch_assoc($result)) {
            echo "<tr>";
                echo "<td class='align-middle'>{$lophoc->get_TenLop_By_ID_LopHoc($row_dkthi['ID_LopHoc'])}</td>";
                echo "<td class='align-middle'>{$cahoc->get_TenCaHoc_By_ID_CaHoc($row_dkthi['ID_CaHoc'])}</td>";
                echo "<td class='align-middle'>{$row_dkthi['NgayDK_Thi']}</td>";
                echo "<td class='align-middle'>{$row_dkthi['Phong']}</td>";
                echo "<td class='align-middle'>";
                
                    // Kiểm tra trạng thái đăng ký
                    if ($row_dkthi['TrangThai_DKThi'] === 'Đang thi') {
                        echo "<span class='badge px-3 py-2 bg-primary'>" . htmlspecialchars($row_dkthi['TrangThai_DKThi']) . "</span>";
                    } elseif ($row_dkthi['TrangThai_DKThi'] === 'Thi xong') {
                        echo "<span class='badge px-3 py-2 bg-success'>" . htmlspecialchars($row_dkthi['TrangThai_DKThi']) . "</span>";
                    }
        
                echo "</td>";
        
                echo "<td class='align-middle'>";
    
                    echo "<button class='btn btn-outline-success me-1' onclick='location.href=\"../../route/route_dangkythi/chitiet_lopthi.php?ID_DKThi=" . $row_dkthi['ID_DKThi'] . "\"'>NHẬP ĐIỂM</button>";
                    echo "<button class='btn btn-outline-danger " . (isset($_SESSION['GV_NAME']) ? 'd-none' : '') . "' onclick='confirmDelete(\"../../route/route_dangkythi/delete_dangkythi.php?ID_DKThi=" . $row_dkthi['ID_DKThi'] . "\", \"" . addslashes($lophoc->get_TenLop_By_ID_LopHoc($row_dkthi['ID_LopHoc'])) . "\")'>XÓA</button>";

                echo "</td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Không có kết quả nào.</td></tr>";
    }
    

?>
