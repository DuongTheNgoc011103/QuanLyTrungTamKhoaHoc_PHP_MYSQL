<?php

    require_once "../../route/db_connect.php";
    
    class KhoaHoc{
        function conn(){
            return db_connect();
        }
    }
    
    //lấy tất cả danh sách học viên
    class DS_KHOAHOC extends KhoaHoc{
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM khoahoc ORDER BY SUBSTRING_INDEX(TenKH, ' ', -1) ASC");

            return $query;
        }
        
        // get_name_by_id
        function get_name_by_id($id_khoahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT TenKH FROM khoahoc WHERE ID_KhoaHoc = '$id_khoahoc'");
            $result = mysqli_fetch_assoc($query);
            return $result['TenKH'];
        }        
        
        // get_hocphi_by_id
        function get_hocphi_by_id($id_khoahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT HocPhi FROM khoahoc WHERE ID_KhoaHoc = $id_khoahoc");
            $result = mysqli_fetch_assoc($query);
            return $result['HocPhi'];
        }
        
        // show by Danh Mục
        function show_by_danhmuc($id_danhmuc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM khoahoc WHERE ID_DanhMuc = $id_danhmuc");
            return $query;
        }
        
        //getID
        function get($id_khoahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM khoahoc WHERE ID_KhoaHoc = $id_khoahoc");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // get_HocPhi
        function get_hocphi($id_khoahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT HocPhi FROM khoahoc WHERE ID_KhoaHoc = $id_khoahoc");
            $result = mysqli_fetch_assoc($query);
            return $result['HocPhi'];
        }
        
        // max_id
        function max_id(){
            $conn = $this->conn();
            $query = "SELECT MAX(ID_KhoaHoc) as max_id FROM khoahoc";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            return $row['max_id'];
        }
        
        // tìm kiếm học viên theo tên
        function search_khoahoc($tenkh) {
            $conn = $this->conn();
            // Sử dụng prepared statement để tránh SQL injection
            $stmt = mysqli_prepare($conn, "SELECT * FROM khoahoc WHERE TenKH LIKE ? ORDER BY TenKH ASC");
            $searchTerm = "%{$tenkh}%";
            mysqli_stmt_bind_param($stmt, 's', $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return $result;
        }
        
        
        // xóa học viên theo id
        function delete_khoahoc($id_khoahoc){
            $conn = $this->conn();
            $query = "DELETE FROM khoahoc WHERE ID_KhoaHoc = $id_khoahoc";
            mysqli_query($conn, $query);
        }
        
        // cập nhật học viên
        function update_khoahoc($id_khoahoc, $tenkh, $anhkh, $mota, $hocphi){
            $conn = $this->conn();
            $query = "UPDATE khoahoc SET TenKH = ?, AnhKH = ?, MoTa = ?, HocPhi = ? WHERE ID_KhoaHoc = ?";
            
            $stmt = mysqli_prepare($conn, $query);
            if($stmt == false){
                die("Update failed: " .$conn->error);
            }
            
            $stmt->bind_param("ssssi", $tenkh, $anhkh, $mota, $hocphi, $id_khoahoc);
            
            if($stmt->execute()){
                return true;
            }else{
                echo "Error update khoahoc: ". $stmt->error;
                return false;
            }
        }
        
        function add_khoahoc($id_danhmuc, $tenkh, $anhkh, $mota, $hocphi){
            $conn = $this->conn();
            $query = "INSERT INTO khoahoc (ID_DanhMuc,TenKH,AnhKH,MoTa,HocPhi) VALUES ('$id_danhmuc', '$tenkh', '$anhkh', '$mota', '$hocphi')";
            mysqli_query($conn, $query);
        }
        
        //delete_khoahoc_by_ID_DanhMuc
        function delete_khoahoc_by_ID_DanhMuc($id_danhmuc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM khoahoc WHERE ID_DanhMuc = '$id_danhmuc'");
            return $query;
        }
    }

?>