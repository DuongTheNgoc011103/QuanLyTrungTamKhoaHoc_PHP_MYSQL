<?php

    require_once "../../route/db_connect.php";
    
    class HocVien{
        function conn(){
            return db_connect();
        }
    }
    
    //lấy tất cả danh sách học viên
    class DS_HOCVIEN extends HocVien{
        function show_all(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM hocvien ORDER BY SUBSTRING_INDEX(TenHV, ' ', -1) ASC");

            return $query;
        }
        
        // get_DS_HV_DangHoc
        function get_DS_HV_DangHoc(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM hocvien WHERE TrangThai_HV = 'Đang học'");
            return $query;
        }
        
        // DSHV_DK_SUCCESS
        function DSHV_DK_SUCCESS(){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM hocvien hv
                                        JOIN dangky dk ON hv.ID_HocVien = dk.ID_HocVien
                                        WHERE dk.TrangThai_DK = 'Đã xác nhận'");
            return $query;
        }
        
        // get_name_by_id
        function get_name_by_id($id_hocvien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT TenHV FROM hocvien WHERE ID_HocVien = $id_hocvien");
            $result = mysqli_fetch_assoc($query);
            return $result['TenHV'];
        }
        
        //getID
        function get($id_hocvien){
            $conn = $this->conn();
            $query = mysqli_query($conn, "SELECT * FROM hocvien WHERE ID_HocVien = $id_hocvien");
            $result = mysqli_fetch_assoc($query);
            return $result;
        }
        
        // max_id
        function max_id(){
            $conn = $this->conn();
            $query = "SELECT MAX(ID_HocVien) as max_id FROM hocvien";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            return $row['max_id'];
        }
        
        // tìm kiếm học viên theo tên
        function search_hocvien($tenhv) {
            $conn = $this->conn();
            // Sử dụng prepared statement để tránh SQL injection
            $stmt = mysqli_prepare($conn, "SELECT * FROM hocvien WHERE TenHV LIKE ? ORDER BY TenHV ASC");
            $searchTerm = "%{$tenhv}%";
            mysqli_stmt_bind_param($stmt, 's', $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return $result;
        }
        
        // xóa học viên theo id
        function delete_hocvien($id_hocvien){
            $conn = $this->conn();
            $query = "DELETE FROM hocvien WHERE ID_HocVien = $id_hocvien";
            mysqli_query($conn, $query);
        }
        
        // cập nhật học viên
        function update_hocvien($id_hocvien, $tenhv, $anhhv, $gioitinh, $email, $sdt, $ngaysinh, $trangthai_hv){
            $conn = $this->conn();
            $query = "UPDATE hocvien SET TenHV = ?, AnhHV = ?, GioiTinh = ?, Email = ?, SDT = ?, NgaySinh = ?, TrangThai_HV = ? WHERE ID_HocVien = ?";
            
            $stmt = mysqli_prepare($conn, $query);
            if($stmt == false){
                die("Update failed: " .$conn->error);
            }
            
            $stmt->bind_param("sssssssi", $tenhv, $anhhv, $gioitinh, $email, $sdt, $ngaysinh, $trangthai_hv, $id_hocvien);
            
            if($stmt->execute()){
                return true;
            }else{
                echo "Error update hocvien: ". $stmt->error;
                return false;
            }
        }
        
        // thêm học viên 	ID_HocVien	TenHV	AnhHV	Email	SDT	NgaySinh	TrangThai_HV	
        function add_hocvien($tenhv, $anhhv, $gioitinh, $email, $sdt, $ngaysinh){
            $conn = $this->conn();
            $query = "INSERT INTO hocvien (TenHV,AnhHV,GioiTInh,Email,SDT,NgaySinh) VALUES ('$tenhv', '$anhhv', '$gioitinh', '$email', '$sdt', '$ngaysinh')";
            mysqli_query($conn, $query);
        }
    }

?>