<?php

    require_once "../../route/db_connect.php";
    
    class DiemThi{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_DIEMTHI extends DiemThi{
        
        // Kiểm tra điểm danh có tồn tại hay không
        public function check_diemthi_exists($id_hocvien, $id_dkthi) {
            $conn = $this->conn();
            $stmt = $conn->prepare("SELECT COUNT(*) FROM diemthi WHERE ID_HocVien = ? AND ID_DKThi = ?");
            $stmt->bind_param("ii", $id_hocvien, $id_dkthi);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            return $count > 0;
        }
            
        
        // Thêm điểm danh
        function add_diemthi($id_dkthi, $id_hocvien, $cot1, $cot2, $cot3, $cot4, $cot5, $cot6, $diem_tb) {
            $conn = $this->conn();
            $query = "INSERT INTO diemthi (ID_DKThi, ID_HocVien, Cot1, Cot2, Cot3, Cot4, Cot5, Cot6, Diem_TB) 
                      VALUES ('$id_dkthi', '$id_hocvien', '$cot1', '$cot2', '$cot3', '$cot4', '$cot5', '$cot6', '$diem_tb')";
            $query_run = mysqli_query($conn, $query);
            
            if ($query_run) {
                return true; // Thành công
            } else {
                die("Lỗi khi thực thi truy vấn: " . mysqli_error($conn));
            }
        }
        
        
        public function get_DiemThi($id_hocvien, $id_dkthi) {
            $conn = $this->conn();
            $query = "SELECT Cot1, Cot2, Cot3, Cot4, Cot5, Cot6, Diem_TB FROM diemthi WHERE ID_DKThi = '$id_dkthi' AND ID_HocVien = '$id_hocvien'";
            $result = mysqli_query($conn, $query);
        
            if ($result) {
                return mysqli_fetch_assoc($result); // Trả về mảng kết hợp chứa các cột điểm
            } else {
                return null; // Không tìm thấy dữ liệu
            }
        }
        
        
        public function get_TrangThai_by_ID_HocVien($id_hocvien, $id_dkthi) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT DiemThi FROM diemthi WHERE id_dkthi = '$id_dkthi' AND ID_HocVien = '$id_hocvien'");
            $result = mysqli_fetch_assoc($query);
            return $result['DiemThi'];
        }
        
        // Cập nhật trạng thái điểm danh
        function update($id_dkthi, $id_hocvien, $cot1, $cot2, $cot3, $cot4, $cot5, $cot6, $diem_tb) {
            $conn = $this->conn();
            $query = "UPDATE diemthi 
                      SET Cot1 = '$cot1', Cot2 = '$cot2', Cot3 = '$cot3', Cot4 = '$cot4', Cot5 = '$cot5', Cot6 = '$cot6', Diem_TB = '$diem_tb' 
                      WHERE ID_HocVien = '$id_hocvien' AND ID_DKThi = '$id_dkthi'";
            $query_run = mysqli_query($conn, $query);
        
            if ($query_run) {
                return true;
            } else {
                die("Lỗi khi thực thi truy vấn: " . mysqli_error($conn));
            }
        }        
        
        // get_diem_HocVien
        function get_diem_hocvien($id_dkthi, $id_hocvien) {
            $conn = $this->conn();
            $query = "SELECT Cot1, Cot2, Cot3, Cot4, Cot5, Cot6, Diem_TB FROM diemthi WHERE ID_DKThi = '$id_dkthi' AND ID_HocVien = '$id_hocvien'";
            $result = mysqli_query($conn, $query);
        
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                return $row; // Trả về mảng kết hợp chứa tất cả các cột điểm
            } else {
                return null; // Trả về null nếu không tìm thấy bản ghi
            }
        }
        
    }

?>
