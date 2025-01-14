<?php

    require_once "../../route/db_connect.php";
    
    class LichHoc{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_LICHHOC extends LichHoc{
        //show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM lichhoc");
            return $query;
        }
            
        //show_by_NgayHoc
        function show_by_NgayHoc(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM lichhoc ORDER BY NgayHoc ASC");
            return $query;
        }
        
        // Kiểm tra điểm danh có tồn tại hay không
        public function check_lichhoc_exists($id_cahoc, $id_lophoc, $ngayhoc) {
            $conn = $this->conn();
            $query = "SELECT COUNT(*) FROM lichhoc WHERE ID_CaHoc = '$id_cahoc' AND ID_LopHoc = '$id_lophoc' AND NgayHoc = '$ngayhoc'";
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                $row = mysqli_fetch_row($result);
                return $row[0] > 0; // Trả về true nếu có bản ghi, false nếu không có
            } else {
                die("Lỗi khi thực thi truy vấn.");
            }
        }
        
        // Kiểm tra lớp đó có lịch học chưa
        public function check_lichhoc($id_lophoc) {
            $conn = $this->conn();
            $query = "SELECT COUNT(*) FROM lichhoc WHERE ID_LopHoc = '$id_lophoc'";
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                $row = mysqli_fetch_row($result);
                return $row[0] > 0; // Trả về true nếu có bản ghi, false nếu không có
            } else {
                die("Lỗi khi thực thi truy vấn.");
            }
        }
        
        // Kiểm tra lớp học đang học
        public function check_lophoc_danghoc($id_lophoc) {
            $conn = $this->conn();
        
            // Truy vấn kiểm tra trạng thái "Đang học"
            $sql = "SELECT COUNT(*) AS Total 
                    FROM lichhoc 
                    WHERE ID_LopHoc = '$id_lophoc' AND TRIM(TrangThai_Lich) = 'Đang học'";
            $result = mysqli_query($conn, $sql);
        
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                return (int)$row['Total'] > 0; // Trả về true nếu có bản ghi với trạng thái "Đang học"
            } else {
                die("Lỗi khi thực thi truy vấn: " . mysqli_error($conn));
            }
        }
        
        // get
        function get($id_lichhoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM lichhoc WHERE ID_LichHoc = '$id_lichhoc'");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }        
        
        //add_LichHoc
        function add_lichhoc($id_lophoc, $id_cahoc, $ngayhoc, $phong){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO lichhoc (ID_LopHoc, ID_CaHoc, NgayHoc, Phong) VALUES ('$id_lophoc', '$id_cahoc', '$ngayhoc', '$phong')");
            return $query;
        }
        
        // Hàm update_LichHoc
        function update_lichhoc($id_lichhoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "UPDATE lichhoc SET TrangThai_Lich = 'Đã điểm danh' WHERE ID_LichHoc = '$id_lichhoc'");
            return $query;
        }
        
        // Hàm update_LichHoc
        function update_ngayhoc_phong($id_lichhoc, $ngayhoc, $phong){
            $conn = $this->conn();
            $query = mysqli_query($conn, "UPDATE lichhoc SET NgayHoc = '$ngayhoc', Phong = '$phong' WHERE ID_LichHoc = '$id_lichhoc'");
            return $query;
        }

        //delete_LichHoc
        function delete_lichhoc($id_lichhoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM lichhoc WHERE ID_LichHoc = '$id_lichhoc'");
            return $query;
        }
        
        //delete_LichHoc
        function delete_lichhoc_by_ID_LopHoc($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM lichhoc WHERE ID_LopHoc = '$id_lophoc'");
            return $query;
        }
        
        //delete_LichHoc
        function delete_lichhoc_by_ID_CaHoc($id_cahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM lichhoc WHERE ID_CaHoc = '$id_cahoc'");
            return $query;
        }
        
        // get_by_cahoc_and_ngayhoc
        function get_by_cahoc_and_ngayhoc($id_cahoc, $ngayhoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM lichhoc WHERE ID_CaHoc = '$id_cahoc' AND NgayHoc = '$ngayhoc'");
            return $query;
        }
        
        
        
    }

?>