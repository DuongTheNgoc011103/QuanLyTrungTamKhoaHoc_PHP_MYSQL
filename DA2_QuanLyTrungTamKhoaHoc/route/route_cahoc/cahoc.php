<?php

    require_once "../../route/db_connect.php";
    
    class CaHoc{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_CAHOC extends CaHoc{
        //show_all
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM cahoc");
            return $query;
        }
        
        // get_TenLop_By_ID_CaHoc
        function get_TenLop_By_id_cahoc($id_cahoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT Ten_CaHoc FROM cahoc WHERE ID_CaHoc = '$id_cahoc'");
            $result = mysqli_fetch_assoc($query);
            return $result['Ten_CaHoc'];
        }
        
        // get
        function get($id_cahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM cahoc WHERE ID_CaHoc = '$id_cahoc'");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        //add_cahoc
        function add_cahoc($tenCH, $gioBD, $gioKT){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO cahoc (Ten_CaHoc, Gio_BD, Gio_KT) VALUES ('$tenCH', '$gioBD', '$gioKT')");
            return $query;
        }
        
        // Hàm update_cahoc
        function update_cahoc($id_cahoc, $tenCH, $gioBD, $gioKT){
            $conn = $this->conn();
            
            // Chuẩn bị câu truy vấn
            $stmt = mysqli_prepare($conn, "UPDATE cahoc SET Ten_CaHoc = ?, Gio_BD = ?, Gio_KT = ? WHERE ID_CaHoc = ?");
            
            if($stmt === false){
                die("Prepare failed: " . $conn->error);
            }

            // Liên kết tham số
            mysqli_stmt_bind_param($stmt, "sssi", $tenCH, $gioBD, $gioKT, $id_cahoc);

            // Thực thi câu lệnh
            $result = mysqli_stmt_execute($stmt);

            // Đóng câu lệnh và kết nối
            mysqli_stmt_close($stmt);
            $conn->close();

            return $result;
        }

        //delete_cahoc
        function delete_cahoc($id_cahoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM cahoc WHERE ID_CaHoc = '$id_cahoc'");
            return $query;
        }
        
        // get_TenLop_By_id_cahoc
        function get_TenCaHoc_By_ID_CaHoc($id_cahoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT Ten_CaHoc FROM CaHoc WHERE id_cahoc = '$id_cahoc'");
            $result = mysqli_fetch_assoc($query);
            return $result['Ten_CaHoc'];
        }
    }

?>