<?php

    require_once "../../route/db_connect.php";
    
    class NoiDung_KhoaHoc{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_NDKH extends NoiDung_KhoaHoc{
        
        //show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM noidung_khoahoc");
            return $query;
        }
        
        // get
        function get($id_noidung_kh){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM noidung_khoahoc WHERE ID_NoiDung = '$id_noidung_kh'");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // get_By_ID_Khoahoc
        function get_By_ID_Khoahoc($id_khoahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM noidung_khoahoc WHERE ID_KhoaHoc = '$id_khoahoc'");
            return $query;
        }
        
        function get_ID_KhoaHoc($id_noidung_kh){
            $conn = $this->conn();  // Ensure you're getting the connection correctly
            $query = mysqli_query($conn, "SELECT ID_KhoaHoc FROM noidung_khoahoc WHERE ID_NoiDung = '$id_noidung_kh'");
            
            // Check if the query was successful and returned any results
            if ($query && mysqli_num_rows($query) > 0) {
                // Fetch the result and return the ID_KhoaHoc
                $result = mysqli_fetch_assoc($query);
                return $result['ID_KhoaHoc'];
            } else {
                // Handle case where no result is found
                return null;  // Or return an error message depending on your needs
            }
        }
        
        //add_noidung_kh
        function add_noidung_kh($tennd, $tailieu, $id_khoahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO noidung_khoahoc (TenND, TaiLieu, ID_KhoaHoc) VALUES ('$tennd', '$tailieu', '$id_khoahoc')");
            return $query;
        }
        
        //update_noidung_kh
        function update_noidung_kh($id_noidung_kh, $id_khoahoc, $tennd, $tailieu){
            $conn = $this->conn();
            $query = "UPDATE noidung_khoahoc SET TenND = ?, TaiLieu = ?, ID_KhoaHoc = ? WHERE ID_NoiDung = ?";
            
            $stmt = mysqli_prepare($conn, $query);
            if($stmt == false){
                die("Update failed: " .$conn->error);
            }
            
            $stmt->bind_param("ssii", $tennd, $tailieu, $id_khoahoc, $id_noidung_kh);
            
            if($stmt->execute()){
                return true;
            }else{
                echo "Error update noidung_khoahoc: ". $stmt->error;
                return false;
            }
        }
        
        //delete_noidung_kh
        function delete_noidung_kh($id_noidung_kh){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM noidung_khoahoc WHERE ID_NoiDung = '$id_noidung_kh'");
            return $query;
        }
        // max_id
        function max_id(){
            $conn = $this->conn();
            $query = "SELECT MAX(ID_NoiDung) as max_id FROM noidung_khoahoc";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            return $row['max_id'];
        }
        
        
    }

?>