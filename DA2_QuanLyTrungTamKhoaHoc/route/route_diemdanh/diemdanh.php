<?php

    require_once "../../route/db_connect.php";
    
    class DiemDanh{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_DIEMDANH extends DiemDanh{
        
        // Kiểm tra điểm danh có tồn tại hay không
        public function check_diemdanh_exists($id_hocvien, $id_lichhoc) {
            $conn = $this->conn();
            $query = "SELECT COUNT(*) FROM diemdanh WHERE ID_HocVien = '$id_hocvien' AND ID_LichHoc = '$id_lichhoc'";
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                $row = mysqli_fetch_row($result);
                return $row[0] > 0; // Trả về true nếu có bản ghi, false nếu không có
            } else {
                die("Lỗi khi thực thi truy vấn.");
            }
        }
        
        // Thêm điểm danh
        function add_diemdanh($id_lichhoc, $id_hocvien, $trangthai_DD) {
            $conn = $this->conn();
            $query = "INSERT INTO diemdanh (ID_LichHoc, ID_HocVien, TrangThai_DD) VALUES ('$id_lichhoc', '$id_hocvien', '$trangthai_DD')";
            $query_run = mysqli_query($conn, $query);
            
            if ($query_run) {
                return true; // Thành công
            } else {
                die("Lỗi khi thực thi truy vấn.");
            }
        }
        
        public function get_TrangThai($id_hocvien, $id_lichhoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT TrangThai_DD FROM diemdanh WHERE ID_LichHoc = '$id_lichhoc' AND ID_HocVien = '$id_hocvien'");
            $result = mysqli_fetch_assoc($query);
            return $result['TrangThai_DD'];
        }
        
        public function get_TrangThai_by_ID_HocVien($id_hocvien, $id_lichhoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT TrangThai_DD FROM diemdanh WHERE ID_LichHoc = '$id_lichhoc' AND ID_HocVien = '$id_hocvien'");
            $result = mysqli_fetch_assoc($query);
            return $result['TrangThai_DD'];
        }
        
        // Cập nhật trạng thái điểm danh
        public function update($id_lichhoc, $id_hocvien, $trangthai_DD) {
            $conn = $this->conn();
            $query = "UPDATE diemdanh SET TrangThai_DD = '$trangthai_DD' WHERE ID_HocVien = '$id_hocvien' AND ID_LichHoc = '$id_lichhoc'";
            $query_run = mysqli_query($conn, $query);
            
            if ($query_run) {
                return true; // Thành công
            } else {
                die("Lỗi khi thực thi truy vấn.");
            }
        }
        
        // số buổi học theo từng lớp của học viên
        function SoBuoi_DD($id_hocvien){
            $conn = $this->conn();
            $query = "
                SELECT 
                    COUNT(dd.ID_DiemDanh) AS TongSoBuoiDiemDanh
                FROM 
                    diemdanh dd
                JOIN 
                    lichhoc lich ON dd.ID_LichHoc = lich.ID_LichHoc
                JOIN 
                    lophoc lh ON lich.ID_LopHoc = lh.ID_LopHoc
                WHERE 
                    dd.TrangThai_DD = 'Có mặt' AND dd.ID_HocVien = ?
            ";
            
            // Chuẩn bị câu lệnh
            $stmt = mysqli_prepare($conn, $query);
            $stmt->bind_param("i", $id_hocvien);

            // Thực thi truy vấn
            $stmt->execute();
            $result = $stmt->get_result();

            // Lấy tổng số buổi
            $row = $result->fetch_assoc();
            $tongSoBuoi = $row['TongSoBuoiDiemDanh'] ?? 0; // Đảm bảo trả về 0 nếu không có kết quả

            // Đóng câu lệnh
            $stmt->close();

            // Trả về tổng số buổi
            return $tongSoBuoi;
        }
        
        // Xóa DiemDanh_By_ID_LichHoc
        function delete_diemdanh_by_id_lichhoc($id_lichhoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM diemdanh WHERE ID_LichHoc = '$id_lichhoc'");
            return $query;
        }
        
    }

?>
