<?php

    require_once "../../route/db_connect.php";
    
    class DangKy{
        function conn(){
            return db_connect();
        }
    }
    
    class DS_DANGKY extends DangKy{
        
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM dangky");
            return $query;
        }        
        
        function get($id_dangky){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM dangky  WHERE ID_DangKy = '$id_dangky'");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // get_ID_DK_by_ID_HocVien_AND_ID_LopHoc
        function get_ID_DK_by_ID_HocVien_AND_ID_LopHoc($id_hocvien, $id_lophoc){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM dangky WHERE ID_HocVien = '$id_hocvien' AND ID_LopHoc = '$id_lophoc'");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // get_DS_by_TrangThai_DK
        function get_DS_by_TrangThai_DK(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM dangky WHERE TrangThai_DK = 'Đã xác nhận'");
            return $query;
        }
        
        // add
        function add_dangky($id_hocvien, $id_lophoc, $ngaydk){
            $conn = $this->conn();
            mysqli_query($conn, "INSERT INTO dangky (ID_HocVien, ID_LopHoc, NgayDK) VALUES ('$id_hocvien','$id_lophoc','$ngaydk')");
            return mysqli_insert_id($conn);
        }
        
        // xacnhan_dangky
        function xacnhan_dangky($id_dangky){
            $conn = $this->conn();
            $query = mysqli_query($conn, "UPDATE dangky SET TrangThai_DK = 'Đã xác nhận' WHERE ID_DangKy = $id_dangky");
            return $query;
        }
        
        // tong_hocphi
        function tong_hocphi(){
            $conn = $this->conn();
            // Join the 'dangky' table with the 'KhoaHoc' table and sum the HocPhi where TrangThai_DK = 'Đã xác nhận'
            $query = mysqli_query($conn, "
                SELECT IFNULL(SUM(khoahoc.HocPhi), 0) as TongHocPhi
                FROM dangky
                JOIN lophoc ON dangky.ID_LopHoc = lophoc.ID_LopHoc
                JOIN khoahoc ON lophoc.ID_KhoaHoc = khoahoc.ID_KhoaHoc
                WHERE dangky.TrangThai_DK = 'Đã xác nhận';
            ");
            
            // Fetch the result and return the total tuition fee
            $result = mysqli_fetch_assoc($query);
            return $result['TongHocPhi'] ? $result['TongHocPhi'] : 0;  // Return 0 if no result
        }
        
        // delete
        function delete_dangky($id_dangky){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM dangky WHERE ID_DangKy = $id_dangky");
            return $query;
        }
        
        // delete_by_ID_HocVien
        function delete_dangky_by_ID_HocVien($id_hocvien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "DELETE FROM dangky WHERE ID_HocVien = $id_hocvien");
            return $query;
        }
        
        // update_TrangThai_DK
        function update_TrangThai_DK($id_hocvien, $id_lophoc) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "UPDATE dangky SET TrangThai_DK = 'Đã sắp lớp' WHERE ID_HocVien = '$id_hocvien' AND ID_LopHoc = '$id_lophoc'");
            return $query;
        }
        
        // get_KhoaHoc_By_ID_HocVien
        function get_LopHoc_By_ID_HocVien($id_hocvien) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT ID_LopHoc FROM dangky WHERE ID_HocVien = '$id_hocvien'");
            $lophoc_list = [];
            while ($result = mysqli_fetch_assoc($query)) {
                $lophoc_list[] = $result['ID_LopHoc']; // Thêm tất cả các khóa học vào mảng
            }
            return $lophoc_list;
        }
        
        
        function get_KhoaHoc($ids_dangky, $id_hocvien) {
            $conn = $this->conn();
            $ids_imploded = implode(",", $ids_dangky); // Chuỗi ID_DangKy cách nhau bởi dấu phẩy
            $query = mysqli_query($conn, "SELECT DISTINCT ID_KhoaHoc FROM lophoc JOIN dangky ON lophoc.ID_LopHoc = dangky.ID_LopHoc WHERE ID_DangKy IN ($ids_imploded) AND ID_HocVien = '$id_hocvien'");
            $result = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $result[] = $row['ID_KhoaHoc'];
            }
            return $result; // Trả về danh sách không trùng ID_KhoaHoc
        }
        
        function get_ID_HocVien($id_dangky) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT ID_HocVien FROM dangky WHERE ID_DangKy = '$id_dangky'");
            $result = mysqli_fetch_assoc($query);
            return $result['ID_HocVien'];
        }
        
        function get_ID_KhoaHoc($id_dangky) {
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT ID_KhoaHoc FROM lophoc JOIN dangky ON lophoc.ID_LopHoc = dangky.ID_LopHoc WHERE ID_DangKy = '$id_dangky'");
            $result = mysqli_fetch_assoc($query);
            return $result['ID_KhoaHoc'];
        }
        
        // DSHV_DK_SUCCESS
        function DSHV_DK_SUCCESS($id_hocvien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT DISTINCT ID_DangKy FROM dangky WHERE ID_HocVien = '$id_hocvien'");
            $result = [];
            while ($row = mysqli_fetch_assoc($query)) {
                $result[] = $row['ID_DangKy'];
            }
            return $result; // Trả về danh sách không trùng
        }
        
        // MAIL
        function check_internet_connection($host = '8.8.8.8', $port = 53, $timeout = 5) {
            $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);
            if ($connection) {
                fclose($connection);
                return true;
            }
            return false;
        }
        
        
    }

?>