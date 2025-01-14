<?php

    require_once "../../route/db_connect.php";
    
    class GiangVien{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_GIANGVIEN extends GiangVien{

        // show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM giangvien");
            return $query;
        }
        
        // getID
        function get($id_giangvien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM giangvien WHERE ID_GiangVien = $id_giangvien");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // max_id
        function max_id(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT MAX(ID_GiangVien) as max_id FROM giangvien");
            $result = mysqli_fetch_assoc($query);
            return $result['max_id'];
        }
        
        // search giangvien
        function search_giangvien($tengv){
            $conn = $this->conn();
            $query = mysqli_prepare($conn, "SELECT * FROM giangvien WHERE TenGV LIKE ? ORDER BY TenGV ASC");
            $search = "%{$tengv}%";
            mysqli_stmt_bind_param($query, 's', $search);
            mysqli_stmt_execute($query);
            
            $result = mysqli_stmt_get_result($query);
            return $result;
        }
        
        // add_giangvien
        function add_giangvien($tengv, $anhgv, $gioitinh, $email, $sdt, $ngaysinh){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO giangvien (TenGV, AnhGV, GioiTinh, Email, SDT, NgaySinh) VALUES ('$tengv','$anhgv','$gioitinh','$email','$sdt','$ngaysinh')");
            return $query;
        }
        
        // update_giangvien
        function update_giangvien($id_giangvien, $tengv, $anhgv, $gioitinh, $email, $sdt, $ngaysinh){
            $conn = $this->conn();
            $query = "UPDATE giangvien SET TenGV = ?, AnhGV = ?, GioiTinh = ?, Email = ?, SDT = ?, NgaySinh = ? WHERE ID_GiangVien = ?";
            
            $stmt = mysqli_prepare($conn, $query);
            if($stmt == false){
                die("Update failed: " .$conn->error);
            }
            
            $stmt->bind_param("ssssssi", $tengv, $anhgv, $gioitinh, $email, $sdt, $ngaysinh, $id_giangvien);
            if($stmt->execute()){
                return true;
            }
            else{
                echo "Error update giangvien: " .$stmt->error;
                return false;
            }
        }
        
        // delete_giangvien
        function delete_giangvien($id_giangvien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM giangvien WHERE ID_GiangVien = $id_giangvien");
            return $query;
        }
    }

?>