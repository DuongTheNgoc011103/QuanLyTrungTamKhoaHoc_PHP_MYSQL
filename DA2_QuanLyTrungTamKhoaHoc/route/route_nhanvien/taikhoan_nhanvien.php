<?php

    require "../../route/db_connect.php";
    
    class TaiKhoan{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_TAIKHOAN extends TaiKhoan{
        
        // show_all
        function show_all(){
            $conn = $this->conn();
            $sql = "SELECT * FROM taikhoan";
            $result = $conn->query($sql);
            return $result;
        }
        
        // get_name_by_id
        function get_name_by_id($id_taikhoan){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT Ten_TK FROM taikhoan WHERE ID_TaiKhoan = '$id_taikhoan'");
            $result = mysqli_fetch_assoc($query);
            return $result['Ten_TK'];
        }
        
        // Thêm tài khoản mới
        function register($tenTK, $email, $matKhau)
        {
            $conn = $this->conn(); // Gọi phương thức kết nối từ lớp cha
            $username = mysqli_real_escape_string($conn, $tenTK); // Bảo vệ dữ liệu trước khi thêm vào truy vấn
            $email = mysqli_real_escape_string($conn, $email);
            $matKhau = mysqli_real_escape_string($conn, $matKhau);
            $hash = password_hash($matKhau, PASSWORD_DEFAULT);
            $query = "INSERT INTO taikhoan (Ten_TK, Email, MatKhau) VALUES ('$tenTK', '$email', '$hash')";
            return mysqli_query($conn, $query);
        }
        
        // delete_taikhoan
        function delete_taikhoan($id_taiKhoan){
            $conn = $this->conn();
            $sql = "DELETE FROM taikhoan WHERE ID_TaiKhoan = $id_taiKhoan";
            return mysqli_query($conn, $sql);
        }
        
        // tìm kiếm nhân viên theo tên
        function search_taikhoan($tennv) {
            $conn = $this->conn();
            // Sử dụng prepared statement để tránh SQL injection
            $stmt = mysqli_prepare($conn, "SELECT * FROM taikhoan WHERE Ten_TK LIKE ? ORDER BY Ten_TK ASC");
            $searchTerm = "%{$tennv}%";
            mysqli_stmt_bind_param($stmt, 's', $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return $result;
        }
    }

?>