<?php

    require_once "../../route/db_connect.php";
    
    class DangKyThi{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_DKTHI extends DangKyThi{
        //show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM dangkythi");
            return $query;
        }
        
        // get_ID_DangKy_by_ID_LopHoc
        function get_ID_DangKyThi_by_ID_LopHoc($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT ID_DKThi FROM dangkythi WHERE ID_LopHoc = '$id_lophoc'");
            $result = mysqli_fetch_assoc($query);
            return $result['ID_DKThi'];
        }
        
        //add_LichHoc
        function dangkythi($id_lophoc, $id_cahoc, $ngayhoc, $phong){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO dangkythi (ID_LopHoc, ID_CaHoc, NgayDK_Thi, Phong) VALUES ('$id_lophoc', '$id_cahoc', '$ngayhoc', '$phong')");
            return $query;
        }
        
        // Kiểm tra điểm danh có tồn tại hay không
        public function check_lichthi_exists($id_cahoc, $id_lophoc, $ngayDKThi) {
            $conn = $this->conn();
            $query = "SELECT COUNT(*) FROM dangkythi WHERE ID_CaHoc = '$id_cahoc' AND ID_LopHoc = '$id_lophoc' AND NgayDK_Thi = '$ngayDKThi'";
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                $row = mysqli_fetch_row($result);
                return $row[0] > 0; // Trả về true nếu có bản ghi, false nếu không có
            } else {
                die("Lỗi khi thực thi truy vấn.");
            }
        }
        
        // Kiểm tra lịch thi trùng ngày, ca, và phòng
        public function check_lichthi_trung_phong($id_cahoc, $ngayDKThi, $phong) {
            $conn = $this->conn();
            $query = "SELECT COUNT(*) FROM dangkythi 
                    WHERE ID_CaHoc = '$id_cahoc' AND NgayDK_Thi = '$ngayDKThi' AND Phong = '$phong'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_row($result);
                return $row[0] > 0; // Trả về true nếu có bản ghi, false nếu không có
            } else {
                die("Lỗi khi thực thi truy vấn.");
            }
        }
        
        
        // get_LopHoc_By_ID_DKThi
        function get($id_dkthi){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM dangkythi WHERE ID_DKThi = '$id_dkthi'");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // get_LopHoc_By_ID_DKThi
        function get_LopHoc($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, 
                "SELECT TrangThai_DKThi FROM dangkythi dkthi
                JOIN lophoc lh ON dkthi.ID_LopHoc = lh.ID_LopHoc
                WHERE lh.ID_LopHoc = $id_lophoc
                ");
            $result = mysqli_fetch_assoc($query);
            return $result['TrangThai_DKThi'];
        }
        
        // get_ID_LopHoc
        function get_ID_LopHoc($id_dkthi){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT ID_LopHoc FROM dangkythi WHERE ID_DKThi = '$id_dkthi'");
            $result = mysqli_fetch_assoc($query);
            return $result['ID_LopHoc'];
        }
        
        // update_trangThaiDKTHI
        function update_trangThaiDKTHI($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "UPDATE dangkythi SET TrangThai_DKThi = 'Thi xong' WHERE ID_LopHoc = '$id_lophoc'");
            return $query;
        }
        
        // delete_dangkythi
        function delete_dangkythi($id_dkthi){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM dangkythi WHERE ID_DKThi = '$id_dkthi'");
            return $query;
        }
        
        // COUNT_LopHoc_IN_DS_DKTHI
        function COUNT_LopHoc_IN_DS_DKTHI($id_lophoc) {
            $conn = $this->conn(); // Kết nối cơ sở dữ liệu
        
            // Xây dựng câu lệnh SQL
            $sql = "SELECT ID_LopHoc, COUNT(*) AS SoLanDangKy 
                    FROM dangkythi 
                    WHERE ID_LopHoc = ? 
                    GROUP BY ID_LopHoc";
        
            $stmt = $conn->prepare($sql); // Chuẩn bị truy vấn SQL
            $stmt->bind_param("i", $id_lophoc); // Gán tham số nếu có
            $stmt->execute(); // Thực thi truy vấn
            $result = $stmt->get_result();
        
            if ($result) {
                $row = $result->fetch_assoc();
                return $row['SoLanDangKy'] ?? 0; // Trả về số lần đăng ký hoặc 0 nếu không có
            } else {
                die("Lỗi khi thực thi truy vấn: " . $stmt->error); // Thông báo lỗi
            }
        }
        
    }

?>