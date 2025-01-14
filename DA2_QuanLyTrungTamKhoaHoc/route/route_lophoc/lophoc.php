<?php

    require_once "../../route/db_connect.php";
    
    class LopHoc{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_LOPHOC extends LopHoc{
        
        //show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM lophoc");
            return $query;
        }
        
        //show_Lop_ConHoc
        function show_Lop_ConHoc(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM lophoc WHERE TrangThai_Lop = 'Đang học'");
            return $query;
        }       
        
        // search_lophoc
        function search_lophoc($tenlop) {
            $conn = $this->conn();
            // Sử dụng prepared statement để tránh SQL injection
            $stmt = mysqli_prepare($conn, "SELECT * FROM lophoc WHERE TenLop LIKE ? ORDER BY TenLop ASC");
            $searchTerm = "%{$tenlop}%";
            mysqli_stmt_bind_param($stmt, 's', $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return $result;
        }
        
        // get
        function get($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM lophoc WHERE ID_LopHoc = '$id_lophoc'");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // get_ID_KhoaHoc
        function get_khoahoc_by_lophoc($id_lophoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT ID_KhoaHoc FROM lophoc WHERE ID_LopHoc = '$id_lophoc'");
            $result = mysqli_fetch_assoc($query);
            return $result['ID_KhoaHoc'];
        }
        
        // get_TenLop_By_ID_LopHoc
        function get_TenLop_By_ID_LopHoc($id_lophoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT TenLop FROM lophoc WHERE ID_LopHoc = '$id_lophoc'");
            $result = mysqli_fetch_assoc($query);
            return $result['TenLop'];
        }
        
        //add_lophoc
        function add_lophoc($tenlop, $id_khoahoc, $id_giangvien){
            $conn = $this->conn();
            mysqli_query($conn, "INSERT INTO lophoc (TenLop, ID_KhoaHoc, ID_GiangVien) VALUES ('$tenlop', '$id_khoahoc', '$id_giangvien')");
            return mysqli_insert_id($conn);
        }
        
        // update_TranThai_Lophoc
        function update_TrangThai_Lophoc($id_lophoc, $trangthai_lop){
            $conn = $this->conn();
            $query = mysqli_query($conn, "UPDATE lophoc SET TrangThai_Lop = '$trangthai_lop' WHERE ID_LopHoc = '$id_lophoc'");
            return $query;
        }
        
        //update_lophoc
        function update_lophoc($id_lophoc, $tenlop, $id_khoahoc, $id_giangvien, $trangthai_lop){
            $conn = $this->conn();
            $query = mysqli_query($conn, "UPDATE lophoc SET TenLop = ?, ID_KHOAHOC = ?, ID_GIANGVEN = ?, TrangThai_Lop = ? WHERE ID_LOPHOC = ?");
            
            $stmt = mysqli_prepare($conn, $query);
            if($stmt == false){
                die("Update failed: " .$conn->error);
            }
            
            $stmt->bind_param("siisi", $tenlop, $id_khoahoc, $id_giangvien, $trangthai_lop, $id_lophoc);
            
            if($stmt->execute()){
                return true;
            }else{
                echo "Error update lophoc: ". $stmt->error;
                return false;
            }
        }
        
        //delete_lophoc
        function delete_lophoc($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM lophoc WHERE ID_LOPHOC = '$id_lophoc'");
            return $query;
        }
        
        // soBuoi_cua_LopHoc
        function soBuoi_cua_LopHoc($id_lophoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT COUNT(*) as SoBuoi FROM lichhoc WHERE ID_LopHoc = '$id_lophoc'");
            $result = mysqli_fetch_assoc($query);
            return $result['SoBuoi'];
        }
    }

?>