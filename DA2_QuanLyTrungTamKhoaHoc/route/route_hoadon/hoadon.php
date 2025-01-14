<?php

    require_once "../../route/db_connect.php";
    
    class HoaDon{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_HOADON extends HoaDon{
        
        // show_all
        function show_by_ID_TaiKhoan($id_taikhoan){
            $conn = $this->conn();
            $sql = mysqli_query($conn, "SELECT * FROM hoadon WHERE ID_TaiKhoan = '$id_taikhoan'");
            return $sql;
        }
        
        // get
        function get($id_hoadon){
            $conn = $this->conn();
            $sql = mysqli_query($conn, "SELECT * FROM hoadon WHERE ID_HoaDon = '$id_hoadon'");
            $result = mysqli_fetch_assoc($sql);
            return $result;
        }
        
        function get_ID_LopHoc($id_hoadon) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT ID_LopHoc FROM hoadon WHERE ID_HoaDon = '$id_hoadon'");
            $result = mysqli_fetch_assoc($query);
            return $result['ID_LopHoc'];
        }
        
        // add_hoadon
        function add_hoadon($id_taikhoan, $id_lophoc, $tongtien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "INSERT INTO hoadon (ID_TaiKhoan, ID_LopHoc, TongTien)
                                    VALUES ('$id_taikhoan', '$id_lophoc', '$tongtien')");
            return $query;
        }
        
        // tongtien
        function tongtien($id_taikhoan){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT SUM(TongTien) As TongTien FROM hoadon WHERE ID_TaiKhoan = '$id_taikhoan'");

            if ($query) {
                $result = mysqli_fetch_assoc($query); // Lấy hàng kết quả đầu tiên
                return $result['TongTien'] ?? 0; // Trả về tổng tiền hoặc 0 nếu không có giá trị
            }

            // Nếu truy vấn thất bại, trả về 0
            return 0;
        }
        
        // delete_hoadon
        function delete_hoadon($id_hoadon){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM hoadon WHERE ID_HoaDon = '$id_hoadon'");
            return $query;
        }
        
        // delete_hoadon
        function delete_hoadon_by_ID_LopHoc($id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM hoadon WHERE ID_LopHoc = '$id_lophoc'");
            return $query;
        }
    }

?>