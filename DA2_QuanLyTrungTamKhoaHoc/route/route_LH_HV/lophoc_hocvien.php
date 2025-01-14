<?php

    require_once "../../route/db_connect.php";
    
    class HocVien_LopHoc{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_HOCVIEN_LOPHOC extends HocVien_LopHoc{
        
        //show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM hocvien_lophoc");
            return $query;
        }
        
        // get_hocvien_by_ID_LopHoc
        function get_hocvien_by_ID_LopHoc($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM hocvien_lophoc WHERE ID_LopHoc = '$id_lophoc'");
            return $query;
        }
        
        //add_lophoc
        function add_hocvien_lophoc($id_hocvien, $id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO hocvien_lophoc (ID_HocVien, ID_LopHoc) VALUES ('$id_hocvien', '$id_lophoc')");
            return $query;
        }
        
        //update_lophoc
        // function update_hocvien_lophoc($id_lophoc, $tenlop, $id_khoahoc, $id_giangvien, $trangthai_lop){
        //     $conn = $this->conn();
        //     $query = mysqli_query($conn, "UPDATE hocvien_lophoc SET TenLop = ?', ID_KHOAHOC = ?, ID_GIANGVEN = ?, TrangThai_Lop = ? WHERE ID_LOPHOC = ?");
            
        //     $stmt = mysqli_prepare($conn, $query);
        //     if($stmt == false){
        //         die("Update failed: " .$conn->error);
        //     }
            
        //     $stmt->bind_param("siisi", $tenlop, $id_khoahoc, $id_giangvien, $trangthai_lop, $id_lophoc);
            
        //     if($stmt->execute()){
        //         return true;
        //     }else{
        //         echo "Error update lophoc: ". $stmt->error;
        //         return false;
        //     }
        // }
        
        // delete_lophoc
        function delete_hocvien_lophoc($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM hocvien_lophoc WHERE ID_Lophoc = '$id_lophoc'");
            return $query;
        }
        
        // delete_lophoc
        function delete_hocvien_lophoc_By_ID_HocVien($id_hocvien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM hocvien_lophoc WHERE ID_HocVien = '$id_hocvien'");
            return $query;
        }
        
        // delete_lophoc
        function delete_hocvien_lophoc_By_ID_KhoaHoc($id_khoahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM hocvien_lophoc WHERE ID_KhoaHoc = '$id_khoahoc'");
            return $query;
        }
        
        
    }

?>