<?php

    require_once "../../route/db_connect.php";
    
    class DanhMuc{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_DANHMUC extends DanhMuc{

        // show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM danhmuc_khoahoc");
            return $query;
        }
        
        // get_khoahocByID
        function get_khoahocByID($id_danhmuc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM danhmuc_khoahoc WHERE ID_DanhMuc = $id_danhmuc");
            return $query;
        }
        
        // add_danhmuc
        function add_danhmuc($tendm){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO danhmuc_khoahoc (TenDM) VALUES ('$tendm')");
            return $query;
        }
        
        // update_danhmuc
        function update_danhmuc($id_danhmuc, $tendm){
            $conn = $this->conn();
            $query = "UPDATE danhmuc_khoahoc SET TenDM = ? WHERE ID_DanhMuc = ?";
            
            $stmt = mysqli_prepare($conn, $query);
            if($stmt == false){
                die("Update failed: " .$conn->error);
            }
            
            $stmt->bind_param("si", $tendm, $id_danhmuc);
            if($stmt->execute()){
                return true;
            }
            else{
                echo "Error update danhmuc: " .$stmt->error;
                return false;
            }
        }
        
        // delete_danhmuc
        function delete_danhmuc($id_danhmuc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM danhmuc_khoahoc WHERE ID_DanhMuc = '$id_danhmuc'");
            return $query;
        }
    }

?>