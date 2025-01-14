<?php
require_once "../../route/route_lichhoc/lichhoc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lophoc = $_POST['id_lophoc'] ?? '';
    $so_tuan = $_POST['so_tuan'] ?? 0;

    if (empty($id_lophoc) || $so_tuan <= 0) {
        echo 'Vui lòng nhập số tuần và chọn lớp học.';
        exit;
    }

    $lichhoc = new DS_LICHHOC();

    // Lấy lịch học hiện tại của lớp
    $query = "SELECT * FROM lichhoc WHERE ID_LopHoc = '$id_lophoc' ORDER BY NgayHoc ASC";
    $result = mysqli_query($lichhoc->conn(), $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $lichhoc_data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $lichhoc_data[] = $row;
        }

        // Sao chép lịch học cho các tuần tiếp theo
        foreach ($lichhoc_data as $lich) {
            $start_date = new DateTime($lich['NgayHoc']);
            for ($i = 1; $i <= $so_tuan; $i++) {
                $start_date->modify('+7 days'); // Cộng thêm 7 ngày
                $new_date = $start_date->format('Y-m-d');

                $query_copy = "INSERT INTO lichhoc (ID_LopHoc, ID_CaHoc, NgayHoc, Phong) 
                               VALUES ('{$lich['ID_LopHoc']}', '{$lich['ID_CaHoc']}', '$new_date', '{$lich['Phong']}')";
                $result_copy = mysqli_query($lichhoc->conn(), $query_copy);

                if (!$result_copy) {
                    echo "Lỗi khi sao chép lịch học cho ngày $new_date.";
                    exit;
                }
            }
        }

        echo "Sao chép lịch học thành công cho $so_tuan tuần!";
    } else {
        echo 'Không tìm thấy lịch học để sao chép.';
    }
}
?>
