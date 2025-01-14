<?php

    session_start();    
    
    if (!isset($_SESSION['AD_NAME']) && !isset($_SESSION['GV_NAME'])) {
        header("Location: ../../pages/account/login.php");
        exit();
    }

    // Kiểm tra xem $_SESSION['AD_NAME'] có tồn tại trước khi gán giá trị cho biến $AD_NAME
    $AD_NAME = isset($_SESSION['AD_NAME']) ? $_SESSION['AD_NAME'] : '';
    $GV_NAME = isset($_SESSION['GV_NAME']) ? $_SESSION['GV_NAME'] : '';
    $id_TK = isset($_SESSION['ID_TaiKhoan']) ? $_SESSION['ID_TaiKhoan'] : '';
    
    ob_start();

    ///////////////////////////////////////////////////////////////////////////////////////////////
    // NHÂN VIÊN
    require "../../route/route_nhanvien/taikhoan_nhanvien.php";
    $nhanvien = new DS_TAIKHOAN();
    $query_nv = $nhanvien->show_all();
    $count_nhanvien = mysqli_num_rows($query_nv);
    
    ///////////////////////////////////////////////////////////////////////////////////////////////
    // HỌC VIÊN
    require "../../route/route_hocvien/hocvien.php";
    $hocvien = new DS_HOCVIEN();
    $query = $hocvien->show_all();
    $count_hocvien = mysqli_num_rows($query);

    if (isset($_POST['submit'])) {
        $tenhv = $_POST['tenhv'];
        $gioitinh = $_POST['gioitinh'];
        $email = $_POST['email'];
        $sdt = $_POST['sdt'];
        $ngaysinh = $_POST['ngaysinh'];

        if (isset($_FILES['anhhv']) && !empty($_FILES['anhhv']['name'])) {
            $anhhv = $_FILES['anhhv']['name'];

            // Lấy phần mở rộng của file ảnh
            $ext = pathinfo($anhhv, PATHINFO_EXTENSION);
            $get_num = $hocvien->max_id() + 1; // Giả sử hàm max_id() lấy ID lớn nhất hiện có
            $filename = $get_num . '.' . $ext; // Tạo tên file mới với ID và phần mở rộng

            $target_dir = __DIR__ . '../../../route/route_hocvien/ANHHV/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . $filename;

            if (move_uploaded_file($_FILES['anhhv']['tmp_name'], $target_file)) {
                // Thêm slide vào cơ sở dữ liệu
                $hocvien->add_hocvien($tenhv, $filename, $gioitinh, $email, $sdt, $ngaysinh);
                
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm học viên thành công!.";
                $_SESSION['status_type'] = "success"; // success, error, warning
                
                // Làm mới trang sau khi thêm thành công
                header("Location: " . $_SERVER['PHP_SELF']);
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            } else {
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm khóa học không thành công!.";
                $_SESSION['status_type'] = "error"; // success, error, warning
            }
        } else {
            echo '<div class="alert alert-warning text-center">Thiếu Ảnh học viên</div>';
        }
    }

    // Lấy từ khóa tìm kiếm từ form nếu có
    $tenhv = isset($_POST['TenHV']) ? $_POST['TenHV'] : '';


    // Kiểm tra nếu có từ khóa tìm kiếm
    if (!empty($tenhv)) {
        // Sử dụng truy vấn chuẩn bị (prepared statement) để tránh SQL Injection
        $hocvien->search_hocvien($tenhv);
    } else {
        // Nếu không có từ khóa tìm kiếm, lấy tất cả học viên
        $query = $hocvien->show_all();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    // GIẢNG VIÊN
    require "../../route/route_giangvien/giangvien.php";
    $giangvien = new DS_GIANGVIEN();
    $query_gv = $giangvien->show_all();
    $count_giangvien = mysqli_num_rows($query_gv);

    if (isset($_POST['submit'])) {
        $tengv = $_POST['tengv'];
        $gioitinh = $_POST['gioitinh'];
        $email = $_POST['email'];
        $sdt = $_POST['sdt'];
        $ngaysinh = $_POST['ngaysinh'];

        if (isset($_FILES['anhgv']) && !empty($_FILES['anhgv']['name'])) {
            $anhgv = $_FILES['anhgv']['name'];

            // Lấy phần mở rộng của file ảnh
            $ext = pathinfo($anhgv, PATHINFO_EXTENSION);
            $get_num = $giangvien->max_id() + 1; // Giả sử hàm max_id() lấy ID l��n nhất hiện có
            $filename = $get_num . '.' . $ext; // Tạo tên file mới với ID và phần mở rộng

            $target_dir = __DIR__ . '../../../route/route_giangvien/ANHGV/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . $filename;

            if (move_uploaded_file($_FILES['anhgv']['tmp_name'], $target_file)) {
                $giangvien->add_giangvien($tengv, $filename, $gioitinh, $email, $sdt, $ngaysinh);
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm giảng viên thành công!.";
                $_SESSION['status_type'] = "success"; // success, error, warning

                header("location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm giảng viên không thành công!.";
                $_SESSION['status_type'] = "error"; // success, error, warning
            }
        } else {
            echo '<div class="alert alert-warning text-center">Thiếu ảnh giảng viên</div>';
        }
    }

    // Lấy từ khóa tìm kiếm từ form nếu có
    $tengv = isset($_POST['TenGV']) ? $_POST['TenGV'] : '';


    // Kiểm tra nếu có từ khóa tìm kiếm
    if (!empty($tengv)) {
        // Sử dụng truy vấn chuẩn bị (prepared statement) để tránh SQL Injection
        $giangvien->search_giangvien($tengv);
    } else {
        // Nếu không có từ khóa tìm kiếm, lấy tất cả học viên
        $queryGV = $giangvien->show_all();
    }


    ///////////////////////////////////////////////////////////////////////////
    // DANH MỤC
    require "../../route/route_danhmuc/danhmuc.php";
    $danhmuc = new DS_DANHMUC();
    $query_dm = $danhmuc->show_all();

    if (isset($_POST['submit'])) {
        $TenDM = $_POST['TenDM'];
        $danhmuc->add_danhmuc($TenDM);
        
        // Sau khi thêm, xóa, hoặc cập nhật thành công:
        $_SESSION['status_message'] = "Thêm danh mục khóa học thành công!.";
        $_SESSION['status_type'] = "success"; // success, error, warning
        
        header("location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // option DANH MỤC
    $options = '';
    while ($row_dmOption = mysqli_fetch_assoc($query_dm)) {
        $options .= '<option name="id_danhmuc" value="' . htmlspecialchars($row_dmOption['ID_DanhMuc']) . '">' . htmlspecialchars($row_dmOption['ID_DanhMuc']) . ' - ' . htmlspecialchars($row_dmOption['TenDM']) . '</option>';
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////
    // KHÓA HỌC
    require "../../route/route_khoahoc/khoahoc.php";
    $khoahoc = new DS_KHOAHOC();

    if (isset($_POST['submitKH'])) {
        $id_danhmuc = $_POST['id_danhmuc'];
        $tenkh = $_POST['tenkh'];
        $mota = $_POST['mota'];
        $hocphi = $_POST['hocphi'];

        if (isset($_FILES['anhkh']) && !empty($_FILES['anhkh']['name'])) {
            $anhkh = $_FILES['anhkh']['name'];

            // Lấy phần mở rộng của file ảnh
            $ext = pathinfo($anhkh, PATHINFO_EXTENSION);
            $get_num = $khoahoc->max_id() + 1; // Giả sử hàm max_id() lấy ID lớn nhất hiện có
            $filename = $get_num . '.' . $ext; // Tạo tên file mới với ID và phần mở rộng

            $target_dir = __DIR__ . '../../../route/route_khoahoc/ANHKH/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . $filename;

            if (move_uploaded_file($_FILES['anhkh']['tmp_name'], $target_file)) {
                // Thêm slide vào cơ sở dữ liệu
                $khoahoc->add_khoahoc($id_danhmuc, $tenkh, $filename, $mota, $hocphi);
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm khóa học thành công!.";
                $_SESSION['status_type'] = "success"; // success, error, warning

                // Làm mới trang sau khi thêm thành công
                header("Location: " . $_SERVER['PHP_SELF']);
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            } else {
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm lớp học không thành công!.";
                $_SESSION['status_type'] = "error"; // success, error, warning
            }
        } else {
            echo '<div class="alert alert-warning text-center">Thiếu Ảnh khóa học </div>';
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////
    // ĐĂNG KÝ
    
    require "../../route/route_dangky/PHPMailer-master/src/PHPMailer.php";
    require "../../route/route_dangky/PHPMailer-master/src/SMTP.php";
    require "../../route/route_dangky/PHPMailer-master/src/Exception.php";
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require "../../route/route_dangky/dangky.php";
    $dangky = new DS_DANGKY();
    $dk = $dangky->show_all();

    $query_khdk = $khoahoc->show_all();
    // option KHÓA HỌC
    $optionsKH = '';
    while ($row_khOption = mysqli_fetch_assoc($query_khdk)) {
        $optionsKH .= '<option name="id_khoahoc" value="' . htmlspecialchars($row_khOption['ID_KhoaHoc']) . '">' . htmlspecialchars($row_khOption['ID_KhoaHoc']) . ' - ' . htmlspecialchars($row_khOption['TenKH']) . '</option>';
    }
    

    //add ĐĂNG KÝ
    if (isset($_POST['submitDK'])) {
        $id_hocvien = $_POST['id_hocvien'];
        $id_lophoc = $_POST['id_lophoc'];
        $ngaydk = $_POST['ngaydk'];

        // Thêm đăng ký và lấy ID_DangKy
        $id_dangky = $dangky->add_dangky($id_hocvien, $id_lophoc, $ngaydk);
                
        // KHÓA HỌC
        require_once "../../route/route_khoahoc/khoahoc.php";
        $hocphi = new DS_KHOAHOC();
        
        if ($id_dangky) { // Kiểm tra nếu thêm thành công
            // // Thêm hóa đơn
            // require_once "../../route/route_hoadon/hoadon.php";
            // $hoadon = new DS_HOADON();
            
            require_once "../../route/route_lophoc/lophoc.php";
            $lophoc = new DS_LOPHOC();
            // $id_khoahoc = $lophoc->get_khoahoc_by_lophoc($id_lophoc);
            // $hoadon->add_hoadon($id_TK, $id_dangky, $ngaydk, $hocphi->get_hocphi($id_khoahoc));
    
            // Thông báo thành công
            $_SESSION['status_message'] = "Đăng ký khóa học thành công!";
            $_SESSION['status_type'] = "success";
        } else {
            // Thông báo lỗi nếu thêm đăng ký thất bại
            $_SESSION['status_message'] = "Lỗi khi đăng ký!";
            $_SESSION['status_type'] = "error";
        }

        
        // Sau khi thêm, xóa, hoặc cập nhật thành công:
        $_SESSION['status_message'] = "Đăng ký khóa học thành công!.";
        $_SESSION['status_type'] = "success"; // success, error, warning
        
        // Gửi email đăng ký
        $tt_hocvien = $hocvien->get($id_hocvien);
        $tt_lophoc = $lophoc->get($id_lophoc);
        $tt_khoahoc = $khoahoc->get($tt_lophoc['ID_KhoaHoc']);
        
        if ($tt_hocvien && $tt_lophoc && $tt_khoahoc) {
            if ($dangky->check_internet_connection()){
                $email = $tt_hocvien['Email'];
                $tenhocvien = $tt_hocvien['TenHV'];
                $tenlop = $tt_lophoc['TenLop'];
                $tenkhoahoc = $tt_khoahoc['TenKH'];
                $giakhoahoc = $tt_khoahoc['HocPhi'];    
                
                $mail = new PHPMailer(true);
        
                try {
                    // Cấu hình server SMTP
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';  // Máy chủ SMTP của Gmail
                    $mail->SMTPAuth = true;
                    $mail->Username = 'duongthengoc01112003@gmail.com';  // Thay bằng email của bạn
                    $mail->Password = 'plvz fszq ewbb gbzf';  // Sử dụng mật khẩu ứng dụng của Gmail
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Bảo mật STARTTLS
                    $mail->Port = 587;  // Cổng cho TLS
                
                    // Người gửi và người nhận
                    $mail->setFrom('duongthengoc01112003@gmail.com', mb_encode_mimeheader('Trung Tâm Khóa Học STYDU', 'UTF-8'));
                    $mail->addAddress($email, mb_encode_mimeheader($tenhocvien, 'UTF-8'));
                
                    // Format the price using number_format
                    $formatted_price = number_format($giakhoahoc, 0, ',', '.') . " VNĐ";
                
                    // Thiết lập nội dung email
                    $mail->isHTML(true);
                    $mail->Subject = mb_encode_mimeheader('Thông báo đăng ký lớp học thành công', 'UTF-8');
                    $mail->Body = "
                        <h3>Hóa đơn đăng ký lớp học</h3>
                        <p>Chào $tenhocvien,</p>
                        <p>Cảm ơn bạn đã đăng ký khóa học <strong>$tenkhoahoc</strong> của lớp <strong>$tenlop</strong> vào ngày <strong>$ngaydk</strong>.</p>
                        <p>Thông tin hóa đơn của bạn:</p>
                        <table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
                            <tr>
                                <th>Khóa học</th>
                                <th>Ngày đăng ký</th>
                                <th>Số tiền</th>
                            </tr>
                            <tr>
                                <td style='text-align: center;'>$tenkhoahoc</td>
                                <td style='text-align: center;'>$ngaydk</td>
                                <td style='text-align: center;'>$formatted_price</td>
                            </tr>
                        </table>
                        <p>Chúng tôi sẽ xác nhận và thông báo lịch học đến bạn sau. Vui lòng chú ý gmail phản hồi của chúng tôi.</p>
                        <p>Chúc bạn có trải nghiệm học tập tốt!</p>
                    ";
                
                    // Gửi email
                    $mail->send();
                    echo '<div class="alert alert-info text-center">Email thông báo đã được gửi.</div>';
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger text-center">Gửi email thất bại: ', $mail->ErrorInfo, '</div>';
                }
            }
            else {
                // Thông báo không có kết nối mạng
                echo '<div class="alert alert-warning text-center">Không có kết nối mạng. Email sẽ không được gửi.</div>';
            }             
        }

        // Làm mới trang sau khi đăng ký thành công
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    // LỚP HỌC
    // option GIẢNG VIÊN
    $query_gv = $giangvien->show_all();
    $optionsGV = '';
    while ($row_gvOption = mysqli_fetch_assoc($query_gv)) {
        $optionsGV .= '<option name="id_giangvien" value="' . htmlspecialchars($row_gvOption['ID_GiangVien']) . '">' . htmlspecialchars($row_gvOption['ID_GiangVien']) . ' - ' . htmlspecialchars($row_gvOption['TenGV']) . '</option>';
    }

    require "../../route/route_lophoc/lophoc.php";
    $lophoc = new DS_LOPHOC();
    $query_lh = $lophoc->show_all();
    $count_lophoc = mysqli_num_rows($query_lh);

    if (isset($_POST['submitLH'])) {
        $tenlop = $_POST['tenlop'];
        $id_khoahoc = $_POST['id_khoahoc'];
        $id_giangvien = $_POST['id_giangvien'];

        $id_lophoc = $lophoc->add_lophoc($tenlop, $id_khoahoc, $id_giangvien);
        
        require_once "../../route/route_hoadon/hoadon.php";
        $hoadon = new DS_HOADON();
        $hoadon->add_hoadon($id_TK, $id_lophoc, $tongtien);
        // Sau khi thêm, xóa, hoặc cập nhật thành công:
        $_SESSION['status_message'] = "Thêm lớp học thành công!.";
        $_SESSION['status_type'] = "success"; // success, error, warning

        // Làm mới trang sau khi đăng ký thành công
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
    }

    ////////////////////////////////////////////////////////
    // HỌC VIÊN - LỚP HỌC
    require "../../route/route_LH_HV/lophoc_hocvien.php";
    $LH_HV = new DS_HOCVIEN_LOPHOC();

    if (isset($_POST['submitAddHV'])) {
        // Lấy dữ liệu từ form
        $id_hocvien = $_POST['id_hocvien'];
        $id_lophoc = $_POST['id_lophoc'];

        // Kiểm tra xem học viên đã có trong lớp học chưa
        $checkExistQuery = "SELECT COUNT(*) FROM hocvien_lophoc WHERE ID_HocVien = '$id_hocvien' AND ID_LopHoc = '$id_lophoc'";
        $result = mysqli_query($LH_HV->conn(), $checkExistQuery);
        $row = mysqli_fetch_row($result);

        if ($row[0] > 0) {
            // Sau khi thêm, xóa, hoặc cập nhật thành công:
            $_SESSION['status_message'] = "Học viên này đã tồn tại trong lớp này.";
            $_SESSION['status_type'] = "error"; // success, error, warning
            
            // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            
            // Lấy danh sách khóa học mà học viên đã đăng ký
            $lophoc_dangky = $dangky->get_LopHoc_By_ID_HocVien($id_hocvien);


            // Kiểm tra xem khóa học của lớp có nằm trong danh sách khóa học mà học viên đã đăng ký
            if (in_array($id_lophoc, $lophoc_dangky)) {
                require_once "../../route/route_dangkythi/dangky_thi.php";
                $dkTHI = new DS_DKTHI();

                $trangthai_DKTHI = $dkTHI->get_LopHoc($id_lophoc);
                if ($trangthai_DKTHI == 'Đang thi' || $trangthai_DKTHI == 'Thi xong') {
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Không thể thêm học viên vào lớp này được nữa!";
                    $_SESSION['status_type'] = "error"; // success, error, warning

                    // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                } else {
                    // Nếu chưa tồn tại, thêm học viên vào lớp
                    $LH_HV->add_hocvien_lophoc($id_hocvien, $id_lophoc);
                    
                    // Cập nhật trạng thái đăng ký khóa học
                    $dangky->update_TrangThai_DK($id_hocvien, $id_lophoc);
                    
                    // CẬP NHẬT TỔNG TIỀN CHO HÓA ĐƠN
                    
                    require_once "../../route/route_lophoc/lophoc.php";
                    $lophoc = new DS_LOPHOC();
                    $lophoc_info = $lophoc->get($id_lophoc);
                    
                    require_once "../../route/route_khoahoc/khoahoc.php";
                    $khoahoc = new DS_KHOAHOC();
                    $id_khoahoc = $lophoc_info['ID_KhoaHoc'];
                    $price_khoahoc = $khoahoc->get_hocphi($id_khoahoc);
                    
                    require_once "../../route/route_hoadon/hoadon.php";
                    $hoadon = new DS_HOADON();
                    $updateTongTien = "UPDATE hoadon SET TongTien = TongTien + $price_khoahoc WHERE ID_LopHoc = '$id_lophoc'";
                    mysqli_query($hoadon->conn(), $updateTongTien);
                    
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Thêm học viên cho lớp học thành công!";
                    $_SESSION['status_type'] = "success"; // success, error, warning

                    // Cập nhật số lượng học viên trong lớp
                    $updateSL = "UPDATE lophoc SET SoLuong_HV = SoLuong_HV + 1 WHERE ID_LopHoc = '$id_lophoc'";
                    mysqli_query($LH_HV->conn(), $updateSL);

                    // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
            } else {
                $_SESSION['status_message'] = "Sắp sai lớp cho học viên!";
                $_SESSION['status_type'] = "error"; // success, error, warning

                // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    }

    $query_hvdk = $hocvien->DSHV_DK_SUCCESS();    
    $optionsHV = '';
    
    // Tạo mảng lưu trữ các tổ hợp đã thêm vào danh sách
    $addedOptions = [];
    
    while ($row_hvOption = mysqli_fetch_assoc($query_hvdk)) {
        // Lấy danh sách ID_DangKy
        $list_ID_DangKy = $dangky->DSHV_DK_SUCCESS($row_hvOption['ID_HocVien']);
        
        // Lấy danh sách ID_KhoaHoc
        $list_ID_KhoaHoc = $dangky->get_KhoaHoc($list_ID_DangKy, $row_hvOption['ID_HocVien']);
    
        // Loại bỏ các ID_KhoaHoc trùng lặp
        $unique_KhoaHoc = array_unique($list_ID_KhoaHoc);
    
        // Lấy tên các khóa học và thêm vào danh sách nếu chưa tồn tại
        foreach ($unique_KhoaHoc as $id_khoahoc) {
            if (!empty($id_khoahoc)) { // Kiểm tra ID hợp lệ
                $get_Ten_KH = $khoahoc->get_name_by_id($id_khoahoc);
                
                // Tạo một khóa (key) duy nhất để kiểm tra
                $key = $row_hvOption['ID_HocVien'] . '-' . $id_khoahoc;
    
                // Kiểm tra xem tổ hợp này đã được thêm chưa
                if (!in_array($key, $addedOptions)) {
                    // Thêm vào danh sách nếu chưa tồn tại
                    $optionsHV .= '<option name="id_hocvien" value="' . htmlspecialchars($row_hvOption['ID_HocVien']) . '">' 
                                . htmlspecialchars($row_hvOption['ID_HocVien']) . ' - ' 
                                . htmlspecialchars($row_hvOption['TenHV']) . ' - ' 
                                . htmlspecialchars($get_Ten_KH) . '</option>';
                    
                    // Đánh dấu tổ hợp này là đã xử lý
                    $addedOptions[] = $key;
                }
            }
        }
    }
    


    // OPTIONS HOC VIÊN ĐANG HỌC
    $query_hvdh = $hocvien->get_DS_HV_DangHoc();
    $optionsHVDH = '';
    while ($row_hvOption = mysqli_fetch_assoc($query_hvdh)) {
        $optionsHVDH .= '<option name="id_hocvien" value="' . htmlspecialchars($row_hvOption['ID_HocVien']) . '">' . htmlspecialchars($row_hvOption['ID_HocVien']) . ' - ' . htmlspecialchars($row_hvOption['TenHV']) . '</option>';
    }

    
    ////////////////////////////////////////////////////////////////////
    // CA HỌC
    
    require "../../route/route_cahoc/cahoc.php";
    $cahoc = new DS_CAHOC();
    $query_cahoc = $cahoc->show_all();
    
    // ADD CAHOC
    if (isset($_POST['submitCH'])) {
        $tenCH = $_POST['tenCH'];
        $gio_BD = $_POST['gio_BD'];
        $gio_KT = $_POST['gio_KT'];
        
        $cahoc->add_cahoc($tenCH, $gio_BD, $gio_KT);
        // Sau khi thêm, xóa, hoặc cập nhật thành công:
        $_SESSION['status_message'] = "Thêm ca học thành công!";
        $_SESSION['status_type'] = "success"; // success, error, warning
        
        // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    
    // UPDATE CAHOC
    if (isset($_POST['updateCH'])) {
        $id_cahoc = $_POST['id_cahoc'];
        $tenCH = $_POST['tenCH'];
        $gio_BD = $_POST['gio_BD'];
        $gio_KT = $_POST['gio_KT'];
        
        $cahoc->update_cahoc($id_cahoc, $tenCH, $gio_BD, $gio_KT);
        // Sau khi thêm, xóa, hoặc cập nhật thành công:
        $_SESSION['status_message'] = "Cập nhật ca học thành công!";
        $_SESSION['status_type'] = "success"; // success, error, warning
        
        // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    
    // OPTIONS CA HỌC
    $query_cahoc_option = $cahoc->show_all();
    $optionsCH = '';
    while ($row_cahocOption = mysqli_fetch_assoc($query_cahoc_option)) {
        $optionsCH .= '<option name="id_cahoc" value="' . htmlspecialchars($row_cahocOption['ID_CaHoc']) . '">' . htmlspecialchars($row_cahocOption['Ten_CaHoc']) . ' ( ' . htmlspecialchars($row_cahocOption['Gio_BD']) . ' - ' . htmlspecialchars($row_cahocOption['Gio_KT']) . ' )</option>';
    }
    
    // OPTIONS LỚP HỌC
    $query_lophoc_option = $lophoc->show_all();
    $optionsLH = '';
    while ($row_lophocOption = mysqli_fetch_assoc($query_lophoc_option)) {
        $optionsLH.= '<option name="id_lophoc" value="'. htmlspecialchars($row_lophocOption['ID_LopHoc']). '">' . htmlspecialchars($row_lophocOption['TenLop']). ' - '. htmlspecialchars($khoahoc->get_name_by_id($row_lophocOption['ID_KhoaHoc'])). '</option>';
    }
    
    // OPTIONS LỚP HỌC-Còn Học
    $query_lophoc_option_ConHoc = $lophoc->show_Lop_ConHoc();
    $optionsLHCH = '';
    while ($row_lophocOption = mysqli_fetch_assoc($query_lophoc_option_ConHoc)) {
        $optionsLHCH.= '<option name="id_lophoc" value="'. htmlspecialchars($row_lophocOption['ID_LopHoc']). '">' . htmlspecialchars($row_lophocOption['TenLop']). ' - '. htmlspecialchars($khoahoc->get_name_by_id($row_lophocOption['ID_KhoaHoc'])). '</option>';
    }
    
    ////////////////////////////////////////////////////////////////////
    // LỊCH HỌC
    
    require "../../route/route_lichhoc/lichhoc.php";
    $lichhoc = new DS_LICHHOC();
    $query_lichhoc = $lichhoc->show_by_NgayHoc();
    
    // ADD LICHHOC
    if (isset($_POST['submitSapLich'])) {
        $id_cahoc = $_POST['id_cahoc'];
        $id_lophoc = $_POST['id_lophoc'];
        $ngayhoc = $_POST['ngayhoc'];
        $phong = $_POST['phong'];
        
        if ($lichhoc->check_lichhoc_exists($id_cahoc, $id_lophoc, $ngayhoc)) {
            // Ghi thông báo lỗi vào session
            $_SESSION['status_message'] = "Lịch học đã tồn tại. Vui lòng kiểm tra lại.";
            $_SESSION['status_type'] = "error"; // success, error, warning
        } else {
            $lichhoc->add_lichhoc($id_lophoc, $id_cahoc, $ngayhoc, $phong);
            // Sau khi thêm, xóa, hoặc cập nhật thành công:
            $_SESSION['status_message'] = "Thêm lịch học thành công!";
            $_SESSION['status_type'] = "success"; // success, error, warning
        }
        
        // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
        header("Location: ". $_SERVER['PHP_SELF']);
        exit;
    }
    
    
    /////////////////////////////////////////////////////////////////////
    // ĐĂNG KÝ THI
    
    require "../../route/route_dangkythi/dangky_thi.php";
    $dangkythi = new DS_DKTHI();
    $query_dangkythi = $dangkythi->show_all();
    
    if (isset($_POST['submitDKTHI'])) {
        $id_lophoc = isset($_POST['id_lophoc']) ? (int)$_POST['id_lophoc'] : null;
        $id_cahoc = $_POST['id_cahoc'];
        $ngaythi = $_POST['ngaydk_thi'];
        $phong = $_POST['phong'];
        
        // Kiểm tra số lần đăng ký
        $soLanDangKy = $dangkythi->COUNT_LopHoc_IN_DS_DKTHI($id_lophoc);
    
        if($soLanDangKy >= 6){
            $_SESSION['status_message'] = "Không thể thêm lịch thi vì lớp học đã đạt tối đa số lần đăng ký (6 lần).";
            $_SESSION['status_type'] = "error";

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();            
        }
        else{
            // Kiểm tra trạng thái "Đang học" của lớp học
            if ($lichhoc->check_lophoc_danghoc($id_lophoc)) {
                $_SESSION['status_message'] = "Không thể thêm lịch thi vì lớp học vẫn còn lịch học với trạng thái Đang học.";
                $_SESSION['status_type'] = "error";
                
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else if($lichhoc->check_lichhoc($id_lophoc) === false){
                $_SESSION['status_message'] = "Không thể thêm lịch thi vì lớp học này vẫn chưa có lịch học.";
                $_SESSION['status_type'] = "error";
                
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }else {
                // Kiểm tra lịch thi trùng
                if ($dangkythi->check_lichthi_exists($id_cahoc, $id_lophoc, $ngaythi) || $dangkythi->check_lichthi_trung_phong($id_cahoc, $id_lophoc, $ngaythi, $phong)) {
                    $_SESSION['status_message'] = "Lịch thi đã tồn tại. Vui lòng kiểm tra lại.";
                    $_SESSION['status_type'] = "error";
                    
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    // Thêm lịch thi
                    $dangkythi->dangkythi($id_lophoc, $id_cahoc, $ngaythi, $phong);
                    $lophoc->update_TrangThai_Lophoc($id_lophoc, 'Học xong');
                    $_SESSION['status_message'] = "Thêm Lớp Thi thành công!";
                    $_SESSION['status_type'] = "success";
                    
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
        }
    }
    
    
    ////////////////////////////////////////////////////////////////
    // HÓA ĐƠN
    require_once "../../route/route_hoadon/hoadon.php";
    $hoadon = new DS_HOADON();
    $query_hoadon = $hoadon->show_by_ID_TaiKhoan($id_TK);
    
    // tongtien
    $tongtien = $hoadon->tongtien($id_TK);
    
    
    
    // /////////////////////////////
    // CHART DANH SÁCH ĐĂNG KÝ THEO THÁNG
    // Truy vấn số lượng đăng ký theo tháng
    $query_DSDK_Theo_Thang = mysqli_query($dangky->conn(), "SELECT MONTH(NgayDK) AS Thang, COUNT(*) AS SoLuong FROM dangky GROUP BY Thang");

    // Lưu dữ liệu vào mảng
    $data_labels = [];
    $data_values = [];

    if ($query_DSDK_Theo_Thang) {
        while ($row = $query_DSDK_Theo_Thang->fetch_assoc()) {
            $data_labels[] = "Tháng " . $row['Thang']; // Ví dụ: 'Tháng 1', 'Tháng 2'
            $data_values[] = $row['SoLuong']; // Số lượng đăng ký trong tháng
        }
    }

    // Encode dữ liệu thành JSON để chuyển sang JavaScript
    $json_labels = json_encode($data_labels);
    $json_values = json_encode($data_values);
    
    
    // /////////////////////////////
    // CHART TRẠNG THÁI HỌC VIÊN
    // Truy vấn số lượng học viên theo trạng thái
    $query_TrangThai_HV = mysqli_query($hocvien->conn(), "SELECT TrangThai_HV, COUNT(*) AS SoLuong FROM hocvien GROUP BY TrangThai_HV");

    // Lưu dữ liệu vào mảng
    $data_labelsPIE = [];
    $data_valuesPIE = [];

    if ($query_TrangThai_HV) {
        while ($row = $query_TrangThai_HV->fetch_assoc()) {
            $data_labelsPIE[] = $row['TrangThai_HV']; // Lưu trạng thái "Đang học" hoặc "Đã nghỉ học"
            $data_valuesPIE[] = $row['SoLuong']; // Lưu số lượng học viên trong mỗi trạng thái
        }
    }

    // Encode dữ liệu thành JSON để chuyển sang JavaScript
    $json_labelsPIE = json_encode($data_labelsPIE);
    $json_valuesPIE = json_encode($data_valuesPIE);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../../assets/images/icons/icon-web.png" rel="shortcut icon" role="image/png">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/fontawesome-free-6.3.0-web/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../assets/css/main.css">
    
    <!-- SDT -->
    <script src="../../assets/js/validateSDT.js"></script>
    
    <!-- XÓA -->
    <script src="../../assets/js/confirmDelete.js"></script>
    
    <!-- XÁC NHẬN -->
    <script src="../../assets/js/confirm.js"></script>

    <title>Quản Lý</title>
</head>

<body class="bg-secondary-subtle">

    <?php
        $disableTabs = isset($_SESSION['GV_NAME']);
        $activeTab = !$disableTabs ? 'tab0' : 'tab6'; // Chỉ định tab mặc định nếu bị disable
    ?>

    <div id="sidebar" class="sidebar collapse show" id="myTab" role="tablist">
        <a href="#" class="text-decoration-none">
            <h3 class="text-center text-white fw-bold pb-3" style="letter-spacing: 3px;">STY<span>DU</span></h3>
        </a>

        <a href="#tab0" class="nav-sidebar <?= $disableTabs ? 'disabled' : 'active'; ?>  <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="accordionExample" id="tab0-tab" data-bs-toggle="tab" role="tab" aria-controls="tab0"
            aria-selected="true">
            <img src="../../assets/images/icons/dashboard.png" class="icon" alt="">
            Quản Lý Chung
        </a>

        <a href="#tab1" class="nav-sidebar <?= $disableTabs ? 'disabled' : ''; ?> <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="accordionExample" id="tab1-tab" data-bs-toggle="tab" role="tab" aria-controls="tab1"
            aria-selected="false">
            <img src="../../assets/images/icons/course.png" class="icon" alt="">
            Quản Lý Khóa Học
        </a>

        <a href="#tab2" class="nav-sidebar <?= $disableTabs ? 'disabled' : ''; ?> <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="tab2-tab" data-bs-toggle="tab" role="tab" aria-controls="tab2"
            aria-selected="false">
            <img src="../../assets/images/icons/students.png" class="icon" alt="">
            Quản Lý Học Viên
        </a>

        <a href="#tab3" class="nav-sidebar <?= $disableTabs ? 'disabled' : ''; ?> <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="tab3-tab" data-bs-toggle="tab" role="tab" aria-controls="tab3"
            aria-selected="false">
            <img src="../../assets/images/icons/teacher.png" class="icon" alt="">
            Quản Lý Giảng Viên
        </a>

        <a href="#tab4" class="nav-sidebar <?= $disableTabs ? 'disabled' : ''; ?> <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="tab4-tab" data-bs-toggle="tab" role="tab" aria-controls="tab4"
            aria-selected="false">
            <img src="../../assets/images/icons/register.png" class="icon" alt="">
            Quản Lý Đăng Ký
        </a>

        <a href="#tab5" class="nav-sidebar <?= $disableTabs ? 'disabled' : ''; ?> <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="tab5-tab" data-bs-toggle="tab" role="tab" aria-controls="tab5"
            aria-selected="false">
            <img src="../../assets/images/icons/class.png" class="icon" alt="">
            Quản Lý Lớp Học
        </a>

        <a href="#tab6" class="nav-sidebar" id="tab6-tab" data-bs-toggle="tab" role="tab" aria-controls="tab6"
            aria-selected="false">
            <img src="../../assets/images/icons/schedule.png" class="icon" alt="">
            Quản Lý Lịch Học
        </a>

        <a href="#tab7" class="nav-sidebar <?= $disableTabs ? 'disabled' : ''; ?> <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="tab7-tab" data-bs-toggle="tab" role="tab" aria-controls="tab7"
            aria-selected="false">
            <img src="../../assets/images/icons/nhanvien.png" class="icon" alt="">
            Quản Lý Tài Khoản
        </a>

        <a href="#tab8" class="nav-sidebar" id="tab8-tab" data-bs-toggle="tab" role="tab" aria-controls="tab8"
            aria-selected="false">
            <img src="../../assets/images/icons/list.png" class="icon" alt="">
            Quản Lý Danh Sách Thi
        </a>

        <a href="#tab9" class="nav-sidebar <?= $disableTabs ? 'disabled' : ''; ?> <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" id="tab9-tab" data-bs-toggle="tab" role="tab" aria-controls="tab9"
            aria-selected="false">
            <img src="../../assets/images/icons/bill.png" class="icon" alt="">
            Quản Lý Hóa Đơn
        </a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid d-flex justify-content-between">
                <a class="navbar-brand d-flex ps-xl-0 ps-lg-0 ps-md-3" href="." data-bs-toggle="collapse"
                    data-bs-target="#sidebar">
                    <span><i class="fa-solid fa"></i></span>
                    <span class="fw-semibold ps-2  text-light">
                        <img src="../../assets/images/icons/menu-bar.png" style="width: 50px; height: 50px;" alt="">
                    </span>
                </a>

                <h2 class="mx-auto text-light fw-bold my-0">QUẢN LÝ TRUNG TÂM KHÓA HỌC</h2>
                
                <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
                    <div class="dropdown ms-auto ">
                        <button class="btn btn-account dropdown-toggle text-light fw-bold" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo isset($_SESSION['AD_NAME']) ? $AD_NAME : $GV_NAME;  ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item text-light" href="../account/logout.php">LOGOUT</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="mt-4">
            <div class="tab-content">

                <div class="tab-pane fade <?= $activeTab === 'tab0' ? 'show active' : ''; ?>" id="tab0" role="tabpanel" aria-labelledby="tab0-tab">
                    <div class="container mt-4">
                        <h3 class="text-start fw-bold">QUẢN LÝ CHUNG</h3>

                        <!-- Cards Section -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Số Lượng Học Viên</h5>
                                    <p class="card-text fs-3"><?php echo $count_hocvien?></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Số Lượng Giảng Viên</h5>
                                    <p class="card-text fs-3"><?php echo $count_giangvien?></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-warning mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Số Lượng Lớp Học</h5>
                                    <p class="card-text fs-3"><?php echo $count_lophoc?></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-danger mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Số Lượng Nhân Viên</h5>
                                    <p class="card-text fs-3"><?php echo $count_nhanvien?></p>
                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart Section -->
                        <div class="row mt-2">
                            <div class="col-md-8">
                                <canvas id="barChart"></canvas>
                            </div>
                            <div class="col-md-4">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Chart.js Script -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    // Dữ liệu từ PHP
                    const labels = <?php echo $json_labels; ?>; // Nhãn theo tháng
                    const values = <?php echo $json_values; ?>; // Số lượng đăng ký

                    // Vẽ biểu đồ
                    const ctxBar = document.getElementById('barChart').getContext('2d');
                    new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: labels, // Dữ liệu nhãn (tháng)
                            datasets: [{
                                label: 'Số lượng đăng ký trong tháng là ',
                                data: values, // Dữ liệu số lượng đăng ký
                                backgroundColor: 'rgb(57, 169, 178)',
                                borderColor: 'rgb(57, 169, 178)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'top' }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Pie Chart
                    // Dữ liệu từ PHP
                    const labelsPIE = <?php echo $json_labelsPIE; ?>;
                    const dataPIE = <?php echo $json_valuesPIE; ?>;

                    const ctxPie = document.getElementById('pieChart').getContext('2d');
                    new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: labelsPIE, // Labels từ dữ liệu PHP
                            datasets: [{
                                label: 'Tỷ Lệ Học Viên',
                                data: dataPIE, // Dữ liệu số lượng học viên từ PHP
                                backgroundColor: [
                                    'rgb(255, 99, 71)',  // Màu cho "Đã nghỉ học"
                                    'rgb(0, 169, 255)'   // Màu cho "Đang học"
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    });
                </script>
            
                <!-- tab-content-KHÓA HỌC -->
                <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                    <div class="row m-0 gap-3">
                        <!-- DANH MỤC KHÓA HỌC (Tab categories) -->
                        <div class="col-3 p-0 col-dm">
                            <h3 class="text-center fw-bold">DANH MỤC</h3>
                            <button class="btn w-100 btn-themDM rounded-0 px-4 py-3" style="margin-top: 13px;"><i class="fa-solid fa-plus me-2"></i>THÊM DANH MỤC</button>
                            <!-- Danh mục tab list -->
                            <ul class="nav nav-pills flex-column" id="danhmucTab" role="tablist">
                                <?php foreach ($query_dm as $key => $dm) : ?>
                                    <li class="li-tab py-2 d-flex justify-content-between" role="presentation">
                                        <a class="tab-dm p-2 d-block rounded-0 text-light fw-bold text-decoration-none <?= $key === 0 ? 'active' : '' ?>"
                                            id="danhmucTab<?= $key ?>-tab"
                                            data-bs-toggle="pill"
                                            href="#danhmucTab<?= $key ?>"
                                            role="tab"
                                            aria-controls="danhmucTab<?= $key ?>"
                                            aria-selected="<?= $key === 0 ? 'true' : 'false' ?>"
                                            style="letter-spacing: 2px;">
                                            <?= htmlspecialchars($dm['TenDM']) ?>
                                        </a>
                                        <div class="d-flex">
                                            <button class="btn btn-danger btn-sm px-3" onclick="confirmDelete('../../route/route_danhmuc/delete_danhmuc.php?ID_DanhMuc=<?=$dm['ID_DanhMuc']?>', '<?=$dm['TenDM']?>')"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- KHÓA HỌC (Course details) -->
                        <div class="col pt-0 pb-0 ps-0">
                            <div class="action-top mb-3">
                                <div class="container d-flex justify-content-between pe-0">
                                    <h3 class="text-center fw-bold">DANH SÁCH KHÓA HỌC</h3>
                                    <button class="btn btn-them rounded-0 px-4"><i class="fa-solid fa-plus me-2"></i>THÊM KHÓA HỌC</button>
                                </div>
                            </div>

                            <!-- Nội dung tab -->
                            <div class="tab-content" id="courseCategoriesContent">
                                <?php foreach ($query_dm as $key => $dm) : ?>
                                    <?php
                                    // Gọi hàm show_by_danhmuc để lấy danh sách khóa học theo ID_DanhMuc
                                    $query_kh = $khoahoc->show_by_danhmuc($dm['ID_DanhMuc']);
                                    ?>

                                    <div class="tab-pane fade <?= $key === 0 ? 'show active' : '' ?>" id="danhmucTab<?= $key ?>" role="tabpanel" aria-labelledby="danhmucTab<?= $key ?>-tab">
                                        <!-- Hiển thị tên danh mục -->
                                        <!-- <h4><?= htmlspecialchars($dm['ID_DanhMuc']) ?> - <?= htmlspecialchars($dm['TenDM']) ?></h4> -->
                                        <div style="max-height: 78vh; overflow-y: scroll;">
                                            <table class="table table-striped table-hover text-center">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Ảnh Khóa Học</th>
                                                        <th>Tên Khóa Học</th>
                                                        <th style="width: 250px;">Mô Tả</th>
                                                        <th>Học Phí</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="khoahocTable">
                                                    <?php if (mysqli_num_rows($query_kh) > 0) : ?>
                                                        <?php while ($kh = mysqli_fetch_assoc($query_kh)) : ?>
                                                            <tr>
                                                                <td class="align-middle"><img src="../../route/route_khoahoc/ANHKH/<?= htmlspecialchars($kh['AnhKH']) ?>?t=<?= time(); ?>" alt="" class="img-fluid" style="height: 70px!important; width: 120px!important;"></td>
                                                                <td class="align-middle"><?= htmlspecialchars($kh['TenKH']) ?></td>
                                                                <td class="align-middle" style="width: 250px;"><?= htmlspecialchars($kh['MoTa']) ?></td>
                                                                <td class="align-middle"><?php echo number_format($kh['HocPhi'], 0, ',', '.') . "VNĐ"?></td>
                                                                <td class="align-middle">
                                                                    <button class="btn btn-outline-primary btn-sm px-3 mb-1" onclick="location.href='../../route/route_khoahoc/edit_khoahoc.php?ID_KhoaHoc=<?= $kh['ID_KhoaHoc'] ?>'">SỬA</button>
                                                                    <button class="btn btn-outline-danger btn-sm px-3 mb-1" onclick="confirmDelete('../../route/route_khoahoc/delete_khoahoc.php?ID_KhoaHoc=<?= $kh['ID_KhoaHoc'] ?>', '<?= $kh['TenKH']; ?>')">XÓA</button>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center">Không có khóa học nào trong danh mục này.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- tab-content-HỌC VIÊN -->
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                    <div class="mx-2 mt-4">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <h3 class="text-uppercase fw-bold m-0">Danh sách học viên</h3>
                            <div class="col-4">
                                <form id="searchForm" class="form-group d-flex mx-auto">
                                    <input type="text" name="TenHV" id="searchInput" class="form-control me-2" placeholder="Nhập từ khóa tìm kiếm...">
                                    <button class="btn btn-outline-light px-4" type="submit" id="searchButton">
                                        <i class="fa-solid fa-search" id="btnSearch"></i>
                                    </button>
                                </form>
                            </div>
                            <form action="../../route/route_hocvien/import_hocvien.php" method="post" enctype="multipart/form-data" class="d-flex col-3 gap-1">
                                <div class="form-group">
                                    <input type="file" name="file" id="file" class="form-control" required placeholder="Vui lòng nhập đủ thông tin...">
                                </div>
                                <button type="submit" name="import" class="btn btn-primary">Import</button>
                            </form>
                            <button class="btn btn-them rounded-0 px-4"><i class="fa-solid fa-plus me-2"></i>THÊM</button>
                        </div>
                        <div id="hocvienTable">
                            <table class="table table-striped table-hover text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="align-middle">Họ và Tên</th>
                                        <th class="align-middle">Hình Ảnh</th>
                                        <th class="align-middle">Giới Tính</th>
                                        <th class="align-middle">Email</th>
                                        <th class="align-middle">SĐT</th>
                                        <th class="align-middle">Ngày Sinh</th>
                                        <th class="align-middle">Trạng Thái</th>
                                        <th class="align-middle">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row_hocvien = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <!-- <td class="align-middle"><?= $row_hocvien['ID_HocVien'] ?></td> -->
                                            <td class="align-middle"><?= $row_hocvien['TenHV'] ?></td>
                                            <td class="align-middle">
                                                <img src="../../route/route_hocvien/ANHHV/<?= $row_hocvien['AnhHV'] ?>?t=<?= time(); ?>" alt="Ảnh học viên" class="img-fluid rounded">
                                            </td>
                                            <td class="align-middle"><?= $row_hocvien['GioiTinh'] ?></td>
                                            <td class="align-middle"><?= $row_hocvien['Email'] ?></td>
                                            <td class="align-middle"><?= $row_hocvien['SDT'] ?></td>
                                            <td class="align-middle"><?= $row_hocvien['NgaySinh'] ?></td>
                                            <td class="align-middle">
                                                <span class="badge px-3 py-2 <?= $row_hocvien['TrangThai_HV']  === 'Đang học' ? "bg-success" : "bg-danger" ?>">
                                                    <?= $row_hocvien['TrangThai_HV'] ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-outline-primary btn-sm px-3" onclick="location.href='../../route/route_hocvien/edit_hocvien.php?ID_HocVien=<?= $row_hocvien['ID_HocVien'] ?>'">SỬA</button>
                                                <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete('../../route/route_hocvien/delete_hocvien.php?ID_HocVien=<?= $row_hocvien['ID_HocVien'] ?>', '<?= $row_hocvien['TenHV']; ?>')">XÓA</button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- script SEARCH HỌC VIÊN -->
                <script>
                    document.getElementById("searchForm").addEventListener("submit", function(event) {
                        event.preventDefault(); // Ngăn không cho tải lại trang

                        var searchQuery = document.getElementById("searchInput").value;

                        // Gửi yêu cầu AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "../../route/route_hocvien/search_hocvien.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Hiển thị kết quả vào #hocvienTable
                                document.getElementById("hocvienTable").innerHTML = xhr.responseText;
                            }
                        };
                        xhr.send("TenHV=" + encodeURIComponent(searchQuery));
                    });

                    // search
                    const searchInput = document.getElementById("searchInput");
                    const searchButton = document.getElementById("searchButton");
                    const searchIcon = document.getElementById("btnSearch");

                    // Thay đ��i icon khi nhấn vào biểu tượng search
                    searchButton.addEventListener('click', function() {
                        if (searchIcon.classList.contains("fa-search") && searchInput.value != "") {
                            searchIcon.classList.remove("fa-search");
                            searchIcon.classList.add("fa-times");
                            searchInput.focus(); // Đưa focus vào �� input
                        } else if (searchIcon.classList.contains("fa-times")) {
                            searchIcon.classList.remove("fa-times");
                            searchIcon.classList.add("fa-search");
                            searchInput.value = "";
                        }
                    });
                </script>

                <!-- tab-content-GIẢNG VIÊN -->
                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                    <div class="mx-2 mt-4">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <h3 class="text-uppercase fw-bold m-0">Danh sách giảng viên</h3>
                            <div class="col-6">
                                <form id="searchFormGV" class="form-group d-flex mx-auto">
                                    <input type="text" name="TenGV" id="searchInputGV" class="form-control me-2" placeholder="Nhập từ khóa tìm kiếm...">
                                    <button class="btn btn-outline-light px-4" type="submit" id="searchButtonGV">
                                        <i class="fa-solid fa-search" id="btnSearchGV"></i>
                                    </button>
                                </form>
                            </div>
                            <button class="btn btn-them rounded-0 px-4"><i class="fa-solid fa-plus me-2"></i>THÊM</button>
                        </div>
                        <div id="giangvienTable">
                            <table class="table table-striped table-hover text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>Họ và Tên</th>
                                        <th>Hình Ảnh</th>
                                        <th>Giới Tính</th>
                                        <th>Email</th>
                                        <th>SĐT</th>
                                        <th>Ngày Sinh</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row_giangvien = mysqli_fetch_assoc($queryGV)) {
                                    ?>
                                        <tr>
                                            <!-- <td class="align-middle">GV001</td> -->
                                            <td class="align-middle"><?= $row_giangvien['TenGV'] ?></td>
                                            <td class="align-middle">
                                                <img src="../../route/route_giangvien/ANHGV/<?= $row_giangvien['AnhGV'] ?>?t=<?= time(); ?>" alt="Ảnh giảng viên" class="img-fluid rounded">
                                            </td>
                                            <td class="align-middle"><?= $row_giangvien['GioiTinh'] ?></td>
                                            <td class="align-middle"><?= $row_giangvien['Email'] ?></td>
                                            <td class="align-middle"><?= $row_giangvien['SDT'] ?></td>
                                            <td class="align-middle"><?= $row_giangvien['NgaySinh'] ?></td>
                                            <td class="align-middle">
                                                <button class="btn btn-outline-primary btn-sm px-3" onclick="location.href='../../route/route_giangvien/edit_giangvien.php?ID_GiangVien=<?= $row_giangvien['ID_GiangVien'] ?>'">SỬA</button>
                                                <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete('../../route/route_giangvien/delete_giangvien.php?ID_GiangVien=<?= $row_giangvien['ID_GiangVien'] ?>', '<?= $row_giangvien['TenGV']; ?>')">XÓA</button>
                                            </td>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- script SEARCH GIẢNG VIÊN -->
                <script>
                    document.getElementById("searchFormGV").addEventListener("submit", function(event) {
                        event.preventDefault(); // Ngăn không cho tải lại trang

                        var searchQueryGV = document.getElementById("searchInputGV").value;

                        // Gửi yêu cầu AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "../../route/route_giangvien/search_giangvien.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Hiển thị kết quả vào #hocvienTable
                                document.getElementById("giangvienTable").innerHTML = xhr.responseText;
                            }
                        };
                        xhr.send("TenGV=" + encodeURIComponent(searchQueryGV));
                    });

                    // search
                    const searchInputGV = document.getElementById("searchInputGV");
                    const searchButtonGV = document.getElementById("searchButtonGV");
                    const searchIconGV = document.getElementById("btnSearchGV");

                    // Thay đ��i icon khi nhấn vào biểu tượng search
                    searchButtonGV.addEventListener('click', function() {
                        if (searchIconGV.classList.contains("fa-search") && searchInputGV.value != "") {
                            searchIconGV.classList.remove("fa-search");
                            searchIconGV.classList.add("fa-times");
                            searchInputGV.focus(); // Đưa focus vào �� input
                        } else if (searchIconGV.classList.contains("fa-times")) {
                            searchIconGV.classList.remove("fa-times");
                            searchIconGV.classList.add("fa-search");
                            searchInputGV.value = "";
                        }
                    });
                </script>

                <!-- Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content px-4 py-3">
                            <div class="modal-header">
                                <h5 class="modal-title text-uppercase" id="addModalLabel">Thêm mới</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addForm" action="" method="post" enctype="multipart/form-data">
                                    <!-- Nội dung form sẽ được chèn tự động bằng JavaScript -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Content for ĐĂNG KÝ -->
                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                    <div class="mx-2 mt-4">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <h3 class="text-uppercase fw-bold m-0">Danh sách Đăng ký</h3>

                            <form id="filter-form">
                                <label>
                                    <input type="radio" name="TrangThai_DK" value="Đã xác nhận" onclick="filterData()"
                                        <?php echo (isset($_GET['TrangThai_DK']) && $_GET['TrangThai_DK'] === 'Đã xác nhận') ? 'checked' : ''; ?>>
                                    <span class="badge bg-success">Đã xác nhận</span>
                                </label>
                                <label>
                                    <input type="radio" name="TrangThai_DK" value="Chờ xác nhận" onclick="filterData()"
                                        <?php echo (isset($_GET['TrangThai_DK']) && $_GET['TrangThai_DK'] === 'Chờ xác nhận') ? 'checked' : ''; ?>>
                                    <span class="badge bg-primary">Chờ xác nhận</span>
                                </label>

                                <!-- Nút Refresh -->
                                <button type="button" onclick="refreshData()" class="btn btn-outline-primary">
                                    <img src="../../assets/images/icons/reload.png" class="icon" alt="">
                                    Refresh
                                </button>
                            </form>

                            <button class="btn btn-primary rounded-0 px-4" onclick="location.href='../../route/route_dangky/danhsach_DK.php'">
                                <img src="../../assets/images/icons/dsHocVien.png" class="icon" alt="">
                                DANH SÁCH HỌC VIÊN
                            </button>
                            
                            <!-- HocPhi -->
                            <div class="hocphi">
                                <span class="badge bg-black text-light position-absolute translate-middle-y">
                                    Tổng Tiền :
                                </span>
                                <span class="badge px-3 py-2 bg-info fs-5 mt-1">
                                    <?php echo number_format($dangky->tong_hocphi(), 0, ',', '.') . "VNĐ" ?>
                                </span>
                            </div>
                            
                            <button class="btn btn-them rounded-0 px-4"><i class="fa-solid fa-plus me-2"></i>THÊM</button>
                        </div>
                        <table class="table table-striped table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Học Viên</th>
                                    <th>Lớp Học</th>
                                    <th>Học Phí</th>
                                    <th>Ngày Đăng Ký</th>
                                    <th>Trạng Thái Đăng Ký</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php
                                    while ($row_dk = mysqli_fetch_assoc($dk)) {
                                        
                                        require_once "../../route/route_lophoc/lophoc.php";
                                        $lophoc = new DS_LOPHOC();
                                        $id_khoahoc = $lophoc->get_khoahoc_by_lophoc($row_dk['ID_LopHoc']);
                                ?>
                                    <tr>
                                        <td class="align-middle"><?php echo $hocvien->get_name_by_id($row_dk['ID_HocVien']) ?></td>
                                        <td class="align-middle"><?php echo $lophoc->get_TenLop_By_ID_LopHoc($row_dk['ID_LopHoc']) ?></td>
                                        <td class="align-middle"><?php echo number_format($khoahoc->get_hocphi_by_id($id_khoahoc), 0, ',', '.') . "VNĐ" ?></td>
                                        <td class="align-middle"><?= $row_dk['NgayDK'] ?></td>
                                        <td class="align-middle">
                                            <?php if ($row_dk['TrangThai_DK'] === 'Chờ xác nhận'): ?>
                                                <span class="badge px-3 py-2 bg-primary">
                                                    <?= htmlspecialchars($row_dk['TrangThai_DK']) ?>
                                                </span>
                                            <?php elseif ($row_dk['TrangThai_DK'] === 'Đã sắp lớp'): ?>
                                                <span class="badge px-3 py-2 bg-success">
                                                    <?= htmlspecialchars($row_dk['TrangThai_DK']) ?>
                                                </span>
                                            <?php elseif ($row_dk['TrangThai_DK'] === 'Đã xác nhận'): ?>
                                                <span class="badge px-3 py-2 bg-secondary">
                                                    <?= htmlspecialchars($row_dk['TrangThai_DK']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">

                                            <?php if ($row_dk['TrangThai_DK'] === 'Chờ xác nhận') : ?>
                                                <button class="btn btn-outline-primary btn-sm px-3" onclick="confirmXacNhan('../../route/route_dangky/xacnhan_dangky.php?ID_DangKy=<?= $row_dk['ID_DangKy'] ?>', '<?= $hocvien->get_name_by_id($row_dk['ID_HocVien']) ?>')">Xác Nhận</button>
                                            <?php elseif ($row_dk['TrangThai_DK'] === 'Đã xác nhận') : ?>
                                                <button class="btn bg-secondary btn-sm px-3" disabled onclick="confirmXacNhan('../../route/route_dangky/xacnhan_dangky.php?ID_DangKy=<?= $row_dk['ID_DangKy'] ?>', '<?= $hocvien->get_name_by_id($row_dk['ID_HocVien']) ?>')">Xác Nhận</button>
                                            <?php elseif ($row_dk['TrangThai_DK'] === 'Đã sắp lớp') : ?>
                                                <button class="btn bg-success btn-sm px-3" disabled onclick="confirmXacNhan('../../route/route_dangky/xacnhan_dangky.php?ID_DangKy=<?= $row_dk['ID_DangKy'] ?>', '<?= $hocvien->get_name_by_id($row_dk['ID_HocVien']) ?>')">Xác Nhận</button>
                                            <?php endif; ?>

                                            <!-- <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete('../../route/route_dangky/delete_dangky.php?ID_DangKy=<?= $row_dk['ID_DangKy'] ?>', '<?= $row_dk['ID_DangKy']; ?>')">XÓA</button> -->

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>                    
                </div>

                <!-- script LỌC TRẠNG THÁI ĐĂNG KÝ -->
                <script>
                    function filterData() {
                        // Lấy giá trị của radio button đã chọn
                        const status = document.querySelector('input[name="TrangThai_DK"]:checked').value;

                        // Tạo một đối tượng XMLHttpRequest
                        const xhr = new XMLHttpRequest();

                        // Xác định phương thức và URL cho yêu cầu AJAX
                        xhr.open("GET", "../../route/route_dangky/filter.php?TrangThai_DK=" + status, true);

                        // Xử lý phản hồi từ server
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Cập nhật nội dung của tbody với dữ liệu trả về từ server
                                document.getElementById("table-body").innerHTML = xhr.responseText;
                            }
                        };

                        // Gửi yêu cầu AJAX
                        xhr.send();
                    }

                    function refreshData() {
                        // Tạo một đối tượng XMLHttpRequest
                        const xhr = new XMLHttpRequest();

                        // Xác định phương thức và URL cho yêu cầu AJAX (không có bộ lọc)
                        xhr.open("GET", "../../route/route_dangky/filter.php", true);

                        // Xử lý phản hồi từ server
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Cập nhật nội dung của tbody với dữ liệu trả về từ server
                                document.getElementById("table-body").innerHTML = xhr.responseText;

                                // Bỏ chọn radio button để hiển thị trạng thái không lọc
                                document.querySelectorAll('input[name="TrangThai_DK"]').forEach(radio => radio.checked = false);
                            }
                        };

                        // Gửi yêu cầu AJAX
                        xhr.send();
                    }
                </script>

                <!-- tab-content-LỚP HỌC -->
                <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                    <div class="mx-2 mt-4">
                        <div class="row">
                            <!-- Bảng lớp học -->
                            <div class="col-md-9">
                                <div class="row mb-3">
                                    <h3 class="col-4 text-uppercase fw-bold">Lớp học</h3>
                                </div>
                                
                                <div id="lophocTable">
                                    <table class="table table-striped table-hover text-center">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Tên Lớp</th>
                                                <th>Tên Khóa Học</th>
                                                <th>Số Buổi</th>
                                                <th>Số Lượng HV</th>
                                                <th>Trạng Thái</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            while ($row_lh = mysqli_fetch_assoc($query_lh)) {

                                                $id_lophoc = $row_lh['ID_LopHoc'];
                                                $id_khoahoc = $row_lh['ID_KhoaHoc'];

                                                require_once "../../route/route_LH_HV/lophoc_hocvien.php";
                                                $hv_lh = new DS_HOCVIEN_LOPHOC();
                                                $query_count_hv = mysqli_query($hv_lh->conn(), "SELECT COUNT(*) AS SoLuong_HV FROM hocvien_lophoc WHERE ID_LopHoc = '$id_lophoc'");
                                                $count_result = mysqli_fetch_assoc($query_count_hv);
                                                $soLuong_HV = $count_result['SoLuong_HV'];
                                                
                                                
                                                require_once "../../route/route_khoahoc/khoahoc.php";
                                                $kh = new DS_KHOAHOC();
                                                $khoahoc_info = $kh->get_name_by_id($id_khoahoc);
                                                
                                                require_once "../../route/route_lophoc/lophoc.php";
                                                $lh = new DS_LOPHOC();
                                                $soBuoi = $lh->soBuoi_cua_LopHoc($id_lophoc);
                                            ?>
                                                <tr>
                                                    <td class="align-middle"><?= $row_lh['TenLop'] ?></td>
                                                    <td class="align-middle"><?= $khoahoc_info ?></td>
                                                    <td class="align-middle"><?php echo $soBuoi ?></td>
                                                    <td class="align-middle"><?= $soLuong_HV ?></td>
                                                    <td class="align-middle">
                                                        <span class="badge px-3 py-2 <?= $row_lh['TrangThai_Lop'] === 'Đang học' ? "bg-primary" : "bg-success" ?>">
                                                            <?= $row_lh['TrangThai_Lop'] ?>
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <button class="btn btn-outline-primary btn-sm px-3" onclick="location.href='../../route/route_lophoc/chitiet_lophoc.php?ID_LopHoc=<?= $row_lh['ID_LopHoc'] ?>'">XEM</button>
                                                        <button class="btn btn-outline-success btn-sm px-3 btn-themHV" data-id_lophoc="<?= $row_lh['ID_LopHoc'] ?>">THÊM HỌC VIÊN</button>
                                                        <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete('../../route/route_lophoc/delete_lophoc.php?ID_LopHoc=<?= $row_lh['ID_LopHoc'] ?>', '<?= $row_lh['TenLop']; ?>')">XÓA</button>
                                                    </td>
                                                </tr>

                                                <!-- Modal Them Hoc Vien -->
                                                <div class="modal fade" id="themHVModal<?= $row_lh['ID_LopHoc'] ?>" tabindex="-1" aria-labelledby="themHVModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content px-4 py-3">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-uppercase" id="themHVModalLabel">Thêm Học Viên</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="" method="POST">
                                                                    <?php
                                                                        $error = '';
                                                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                            $id_hocvien = $_POST['id_hocvien'] ?? '';

                                                                            if (empty($id_hocvien)) {
                                                                                $error = "Vui lòng chọn một học viên.";
                                                                            } else {
                                                                                // Xử lý form khi đã có lựa chọn hợp lệ cho học viên
                                                                            }
                                                                        }
                                                                    ?>

                                                                    <div class="mb-3">
                                                                        <label for="id_hocvien" class="form-label fw-bold">Chọn Học Viên</label>
                                                                        <select class="form-select" id="id_hocvien" name="id_hocvien" required>
                                                                            <option value="" selected disabled>Chọn Học Viên</option>
                                                                            <?= $optionsHV ?> <!-- Nạp các tùy chọn học viên từ PHP -->
                                                                        </select>
                                                                    </div>

                                                                    <input type="hidden" name="id_lophoc" value="<?= $row_lh['ID_LopHoc'] ?>">

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                                                                        <button type="submit" class="btn btn-primary" name="submitAddHV">XÁC NHẬN</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                        </tbody>
                                    </table>    
                                </div>
                                
                            </div>

                            <!-- Form Thêm Lớp Học -->
                            <div class="col-md-3">
                                <form method="post" action="">
                                    <div class="mb-3">
                                        <select class="form-select" id="id_khoahoc" name="id_khoahoc" required>
                                            <option selected disabled>Chọn Khóa Học</option>
                                            <?= $optionsKH ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="tenlop" name="tenlop" placeholder="Nhập tên lớp mới..." required placeholder="Vui lòng nhập đủ thông tin...">
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" id="id_giangvien" name="id_giangvien" required>
                                            <option selected disabled>Chọn Giảng Viên</option>
                                            <?= $optionsGV ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary col-12" name="submitLH">Thêm Lớp</button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- tab-content-LỊCH HỌC -->
                <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab6-tab">
                    <div class="mx-2 mt-4">
                        <div class="row justify-content-between">
                            
                            <!-- Bảng Ca Học -->
                            <div class="col-md-8 <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <h3 class="text-uppercase fw-bold m-0">Ca Học</h3>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <button class="btn btn-primary rounded-0 w-50 btn-themCaHoc">THÊM CA HỌC</button>
                                    </div>
                                </div>
                                <table class="table table-striped table-hover text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Ca Học</th>
                                            <th>Giờ Bắt Đầu</th>
                                            <th>Giờ Kết Thúc</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while ($row_ch = mysqli_fetch_assoc($query_cahoc)){
                                        ?>
                                            <tr>
                                                <td class="align-middle"><?=$row_ch['Ten_CaHoc']?></td>
                                                <td class="align-middle"><?=$row_ch['Gio_BD']?></td>
                                                <td class="align-middle"><?=$row_ch['Gio_KT']?></td>
                                                <td class="align-middle">
                                                    <button class="btn btn-outline-primary btn-sm px-3 _TKCaHoc" data-id_cahoc="<?= $row_ch['ID_CaHoc'] ?>">SỬA</button>
                                                    <button class="btn btn-outline-danger btn-sm px-3 btn-xoa" onclick="confirmDelete('../../route/route_cahoc/delete_cahoc.php?ID_CaHoc=<?= $row_ch['ID_CaHoc'] ?>', '<?= $row_ch['Ten_CaHoc']; ?>')">XÓA</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Form thêm lịch học -->
                            <div class="col-md-4 <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>">
                                <form action="" method="post" id="formSapLich">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" id="ngayhoc" name="ngayhoc" required placeholder="Chọn ngày học">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="phong" name="phong" required placeholder="Nhập phòng học">
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" id="id_cahoc" name="id_cahoc" required>
                                            <option value="" selected disabled>Chọn Ca Học</option>
                                            <?= $optionsCH ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" id="id_lophoc" name="id_lophoc" required>
                                            <option value="" selected disabled>Chọn Lớp Học</option>
                                            <?= $optionsLH ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-secondary col-12" name="submitSapLich">Thêm Lịch Học</button>
                                </form>

                                <!-- Input và button sao chép lịch học -->
                                <div class="mt-4 row m-0 gap-1">
                                    <input type="number" class="form-control w-75 col fs-6" id="soLuongTuan" min="1" placeholder="Số tuần muốn sao chép lịch" required>
                                    <button class="btn btn-success col-4" id="btnSaoChep">Xác Nhận</button>
                                </div>
                            </div>
                            
                            <!-- Khu vực hiển thị lịch học -->                                                
                            <div class="pb-4 position-sticky">
                                <div class="d-flex justify-content-between m-0">
                                    <h3 class="col-4 text-uppercase text-center mb-3 fw-bold">DANH SÁCH LỚP CÓ LỊCH HỌC</h3>
                                    <div class="mb-3">
                                        <select class="form-select" id="ID_LopHoc" name="ID_LopHoc" required>
                                            <option value="" selected disabled>Chọn Lớp Học</option>
                                            <?= $optionsLH ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div id="scheduleTable" class="overflow-x-scroll">
                                    <p class="text-center">Vui lòng chọn một lớp học để hiển thị lịch học.</p>
                                </div>
                            </div>
                            
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <!-- LOAD LỊCH HỌC BY ID_LOPHOC -->
                            <script>
                                $(document).ready(function () {
                                    $('#ID_LopHoc').on('change', function () {
                                        var idLopHoc = $(this).val();

                                        if (idLopHoc) {
                                            $.ajax({
                                                url: '/DA2_QuanLyTrungTamKhoaHoc/route/route_lichhoc/load_lichhoc_by_LopHoc.php', // File xử lý AJAX
                                                type: 'POST',
                                                data: { id_lophoc: idLopHoc },
                                                beforeSend: function () {
                                                    $('#scheduleTable').html('<p class="text-center">Đang tải dữ liệu...</p>');
                                                },
                                                success: function (response) {
                                                    console.log("Phản hồi từ server: ", response); // Thêm dòng này để debug
                                                    $('#scheduleTable').html(response);
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error("Lỗi AJAX: ", error); // Thêm dòng này để debug
                                                    $('#scheduleTable').html('<p class="text-center text-danger">Không thể tải dữ liệu. Vui lòng thử lại.</p>');
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>
                            
                            <!-- SAO CHÉP LỊCH HỌC -->
                            <script>
                                $(document).ready(function () {

                                    // Xử lý sao chép lịch học
                                    $('#btnSaoChep').on('click', function () {
                                        const soTuan = $('#soLuongTuan').val();
                                        const idLopHoc = $('#id_lophoc').val();                                    

                                        if (!soTuan || !idLopHoc) {
                                            alert('Vui lòng nhập số tuần và chọn lớp học.');
                                            return;
                                        }

                                        $.ajax({
                                            url: '/DA2_QuanLyTrungTamKhoaHoc/route/route_lichhoc/saochep_lichhoc.php',
                                            type: 'POST',
                                            data: { so_tuan: soTuan, id_lophoc: idLopHoc },
                                            beforeSend: function () {
                                                alert('Đang xử lý sao chép lịch học...');
                                            },
                                            success: function (response) {
                                                alert(response);
                                                // Tải lại lịch học sau khi sao chép
                                                $('#ID_LopHoc').trigger('change');
                                            },
                                            error: function (xhr, status, error) {
                                                console.error('Lỗi:', error);
                                                alert('Không thể sao chép lịch học.');
                                            }
                                        });
                                    });
                                    
                                });
                            </script>
                           
                        </div>
                    </div>
                </div>

                <!-- tab-content-NHÂN VIÊN -->
                <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="tab7-tab">
                    <div class="mx-2 mt-4">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <h3 class="text-uppercase fw-bold m-0">Danh sách tài khoản</h3>
                            <div class="col-6">
                                <form id="searchFormNV" class="form-group d-flex mx-auto">
                                    <input type="text" name="Ten_TK" id="searchInputNV" class="form-control me-2" placeholder="Nhập từ khóa tìm kiếm...">
                                    <button class="btn btn-outline-light px-4" type="submit" id="searchButtonNV">
                                        <i class="fa-solid fa-search" id="btnSearchNV"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div id="nhanvienTable">
                            <table class="table table-striped table-hover text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="align-middle">ID Tài Khoản</th>
                                        <th class="align-middle">Họ và Tên</th>
                                        <th class="align-middle">Email</th>
                                        <th class="align-middle">Role</th>
                                        <th class="align-middle">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        while ($row_nhanvien = mysqli_fetch_assoc($query_nv)) {
                                    ?>
                                        <tr>
                                            <td class="align-middle"><?= $row_nhanvien['ID_TaiKhoan'] ?></td>
                                            <td class="align-middle"><?= $row_nhanvien['Ten_TK'] ?></td>
                                            <td class="align-middle"><?= $row_nhanvien['Email'] ?></td>
                                            <td class="align-middle">
                                                <span class="badge <?= $row_nhanvien['Role'] == 'admin' ? 'bg-danger' : 'bg-success' ?>"><?= $row_nhanvien['Role'] ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-outline-danger btn-sm px-3" onclick="confirmDelete('../../route/route_nhanvien/delete_taikhoan.php?ID_TaiKhoan=<?= $row_nhanvien['ID_TaiKhoan'] ?>', '<?= $row_nhanvien['Ten_TK']; ?>')" <?= ($row_nhanvien['ID_TaiKhoan'] == $id_TK) ? 'disabled' : ''; ?>>XÓA</button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>                   
                </div>
                
                <!-- script SEARCH TÀI KHOẢN -->
                <script>
                    document.getElementById("searchFormNV").addEventListener("submit", function(event) {
                        event.preventDefault(); // Ngăn không cho tải lại trang

                        var searchQueryNV = document.getElementById("searchInputNV").value;

                        // Gửi yêu cầu AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "../../route/route_nhanvien/search_nhanvien.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Hiển thị kết quả vào #hocvienTable
                                document.getElementById("nhanvienTable").innerHTML = xhr.responseText;
                            }
                        };
                        xhr.send("Ten_TK=" + encodeURIComponent(searchQueryNV));
                    });

                    // search
                    const searchInputNV = document.getElementById("searchInputNV");
                    const searchButtonNV = document.getElementById("searchButtonNV");
                    const searchIconNV = document.getElementById("btnSearchNV");

                    // Thay đ��i icon khi nhấn vào biểu tượng search
                    searchButtonNV.addEventListener('click', function() {
                        if (searchIconNV.classList.contains("fa-search") && searchInputNV.value != "") {
                            searchIconNV.classList.remove("fa-search");
                            searchIconNV.classList.add("fa-times");
                            searchInputNV.focus(); // Đưa focus vào �� input
                        } else if (searchIconNV.classList.contains("fa-times")) {
                            searchIconNV.classList.remove("fa-times");
                            searchIconNV.classList.add("fa-search");
                            searchInputNV.value = "";
                        }
                    });
                </script>
                
                <!-- tab-content-DANH SÁCH THI -->
                <div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="tab8-tab">
                    <div class="mx-2 mt-4">
                        
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <h3 class="text-uppercase fw-bold m-0">Danh sách Lớp Thi</h3>
                            <form id="filter-form-DKTHI">
                                <label>
                                    <input type="radio" name="TrangThai_DKThi" value="Thi xong" onclick="filterDataDKTHI()"
                                        <?php echo (isset($_GET['TrangThai_DKThi']) && $_GET['TrangThai_DKThi'] === 'Thi xong') ? 'checked' : ''; ?>>
                                    <span class="badge px-3 py-2 bg-success">Thi xong</span>
                                </label>
                                <label>
                                    <input type="radio" name="TrangThai_DKThi" value="Đang thi" onclick="filterDataDKTHI()"
                                        <?php echo (isset($_GET['TrangThai_DKThi']) && $_GET['TrangThai_DKThi'] === 'Đang thi') ? 'checked' : ''; ?>>
                                    <span class="badge px-3 py-2 bg-primary">Đang thi</span>
                                </label>

                                <!-- Nút Refresh -->
                                <button type="button" onclick="refreshDataDKTHI()" class="btn btn-outline-primary">
                                    <img src="../../assets/images/icons/reload.png" class="icon" alt="">
                                    Refresh
                                </button>
                            </form>
                            <button class="btn btn-them rounded-0 px-4 <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>"><i class="fa-solid fa-plus me-2"></i>THÊM</button>
                        </div>
                        <table class="table table-striped table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th class="align-middle">Tên Lớp</th>
                                    <th class="align-middle">Ca Thi</th>
                                    <th class="align-middle">Ngày Thi</th>
                                    <th class="align-middle">Phòng Thi</th>
                                    <th class="align-middle">Trạng Thái Thi</th>
                                    <th class="align-middle">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body-DKTHI">

                                <?php
                                    if (mysqli_num_rows($query_dangkythi) > 0) { 
                                        while ($row_thi = mysqli_fetch_assoc($query_dangkythi)) {
                                            require_once "../../route/route_lophoc/lophoc.php";
                                            $lophoc = new DS_LOPHOC();
                                            $id_lophoc = $row_thi['ID_LopHoc'];
                                            $lophoc_info = $lophoc->get_TenLop_By_ID_LopHoc($id_lophoc);
                                            
                                            require_once "../../route/route_cahoc/cahoc.php";
                                            $cahoc = new DS_CAHOC();
                                            $id_cahoc = $row_thi['ID_CaHoc'];
                                            $cahoc_info = $cahoc->get_TenCaHoc_By_ID_CaHoc($id_cahoc);
                                    ?>
                                            <tr>
                                                <td class="align-middle"><?php echo $lophoc_info ?></td>
                                                <td class="align-middle"><?php echo $cahoc_info ?></td>
                                                <td class="align-middle"><?= $row_thi['NgayDK_Thi'] ?></td>
                                                <td class="align-middle"><?= $row_thi['Phong'] ?></td>
                                                <td class="align-middle">
                                                    <span class="badge <?= $row_thi['TrangThai_DKThi'] == 'Đang thi' ? 'bg-primary' : 'bg-success' ?> px-3 py-2"><?= $row_thi['TrangThai_DKThi'] ?></span>
                                                </td>
                                                <td class="align-middle">
                                                    <button class="btn btn-outline-success" onclick="location.href='../../route/route_dangkythi/chitiet_lopthi.php?ID_LopHoc=<?= $row_thi['ID_LopHoc'] ?>'">NHẬP ĐIỂM</button>
                                                    <button class="btn btn-outline-danger <?= isset($_SESSION['GV_NAME']) ? 'd-none' : ''; ?>" onclick="confirmDelete('../../route/route_dangkythi/delete_dangkythi.php?ID_DKThi=<?= $row_thi['ID_DKThi'] ?>', '<?php echo $lophoc_info ?>')">XÓA</button>
                                                </td>
                                            </tr>
                                    <?php 
                                        }
                                    } else { 
                                    ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dữ liệu đăng ký thi.</td>
                                        </tr>
                                    <?php 
                                    } 
                                    ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- script LỌC TRẠNG THÁI ĐĂNG KÝ THI-->
                <script>
                    function filterDataDKTHI() {
                        // Lấy giá trị của radio button đã chọn
                        const status = document.querySelector('input[name="TrangThai_DKThi"]:checked').value;

                        // Tạo một đối tượng XMLHttpRequest
                        const xhr = new XMLHttpRequest();

                        // Xác định phương thức và URL cho yêu cầu AJAX
                        xhr.open("GET", "../../route/route_dangkythi/filter_DKTHI.php?TrangThai_DKThi=" + status, true);

                        // Xử lý phản hồi từ server
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Cập nhật nội dung của tbody với dữ liệu trả về từ server
                                document.getElementById("table-body-DKTHI").innerHTML = xhr.responseText;
                            }
                        };

                        // Gửi yêu cầu AJAX
                        xhr.send();
                    }

                    function refreshDataDKTHI() {
                        // Tạo một đối tượng XMLHttpRequest
                        const xhr = new XMLHttpRequest();

                        // Xác định phương thức và URL cho yêu cầu AJAX (không có bộ lọc)
                        xhr.open("GET", "../../route/route_dangkythi/filter_DKTHI.php", true);

                        // Xử lý phản hồi từ server
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Cập nhật nội dung của tbody với dữ liệu trả về từ server
                                document.getElementById("table-body-DKTHI").innerHTML = xhr.responseText;

                                // Bỏ chọn radio button để hiển thị trạng thái không lọc
                                document.querySelectorAll('input[name="TrangThai_DKThi"]').forEach(radio => radio.checked = false);
                            }
                        };

                        // Gửi yêu cầu AJAX
                        xhr.send();
                    }
                </script>
                
                <!-- DANH SÁCH HÓA ĐƠN -->
                <div class="tab-pane fade" id="tab9" role="tabpanel" aria-labelledby="tab9-tab">
                    <div class="mx-2 mt-4">
                        <div class="row mb-3 mx-0">
                            <h3 class="text-uppercase fw-bold col-9">QUẢN LÝ HÓA ĐƠN</h3>
                            <div class="col text-end">
                                <span class="badge bg-black text-light">
                                    Tổng Tiền :
                                </span>
                                <span class="badge bg-info px-3 py-2 fs-6 fw-bold">
                                    <?php echo number_format($tongtien, 0, ',', '.') . " VNĐ"; ?>
                                </span>
                            </div>
                        </div>

                        <!-- Nội dung bảng -->
                        <table class="table table-striped table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px;">STT</th>
                                    <th>Tên Nhân Viên</th>
                                    <th>Tên Lớp Học</th>
                                    <th>Tên Khóa Học</th>
                                    <th>Tổng Tiền</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $num = 1;
                                while ($row_hd = mysqli_fetch_assoc($query_hoadon)) {
                                    require_once "../../route/route_dangky/dangky.php";
                                    $dk = new DS_DANGKY();
                                    
                                    require_once "../../route/route_lophoc/lophoc.php";
                                    $lh = new DS_LOPHOC();
                                    $lophoc_info = $lh->get_TenLop_By_ID_LopHoc($row_hd['ID_LopHoc']);
                                    $id_khoahoc = $lh->get_khoahoc_by_lophoc($row_hd['ID_LopHoc']);
                                    
                                    require_once "../../route/route_khoahoc/khoahoc.php";
                                    $kh = new DS_KHOAHOC();
                                    $khoahoc_info = $kh->get_name_by_id($id_khoahoc);
                                    
                                    require_once "../../route/route_nhanvien/taikhoan_nhanvien.php";
                                    $tk = new DS_TAIKHOAN();
                                    $taikhoan_info = $tk->get_name_by_id($row_hd['ID_TaiKhoan']);
                                ?>
                                    <tr>
                                        <td><?php echo $num++; ?></td>
                                        <td><?php echo htmlspecialchars($taikhoan_info); ?></td>
                                        <td><?php echo htmlspecialchars($lophoc_info); ?></td>
                                        <td><?php echo htmlspecialchars($khoahoc_info); ?></td>
                                        <td><?php echo number_format($row_hd['TongTien'], 0, ',', '.') . " VNĐ"; ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="location.href='../../route/route_hoadon/chitiet_hoadon.php?ID_HoaDon=<?=$row_hd['ID_HoaDon']?>'">
                                                CHI TIẾT
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('../../route/route_hoadon/delete_hoadon.php?ID_HoaDon=<?php echo $row_hd['ID_HoaDon']; ?>', 'Hóa đơn này')">
                                                XÓA
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.querySelectorAll('.nav-sidebar').forEach(tab => {
            if (tab.classList.contains('disabled')) {
                tab.addEventListener('click', function (e) {
                    e.preventDefault(); // Ngăn chuyển tab
                });
            }
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Kiểm tra thông báo trong session PHP
            <?php if (isset($_SESSION['status_message'])): ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['status_type']; ?>', // success, error, warning
                title: '<?php echo $_SESSION['status_message']; ?>',
                showConfirmButton: false,
                timer: 3000
            });
            <?php unset($_SESSION['status_message'], $_SESSION['status_type']); ?>
            <?php endif; ?>
        });
    </script>
                                            
    <!-- Them -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addForm = document.getElementById("addForm");

            document.querySelectorAll(".btn-them").forEach(btn => {
                btn.addEventListener("click", function() {
                    const tabId = this.closest(".tab-pane").id;
                    addForm.innerHTML = ''; // Xóa nội dung form trước đó

                    if (tabId === "tab1") {
                        // Form dành cho "KHÓA HỌC"
                        addForm.innerHTML = `
                            <div class="mb-3">
                                <label for="tenkh" class="form-label fw-bold">Tên Khóa Học</label>
                                <input type="text" class="form-control" id="tenkh" name="tenkh" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3">
                                <?php
                                $error = '';
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $id_danhmuc = $_POST['id_danhmuc'] ?? '';

                                    if (empty($id_danhmuc)) {
                                        $error = "Vui lòng chọn một danh mục.";
                                    } else {
                                        // Xử lý form khi đã có lựa chọn hợp lệ cho học viên
                                    }
                                }
                                ?>
                                <label for="danhmuc" class="form-label fw-bold">Chọn Danh Mục</label>
                                <select class="form-select" id="id_danhmuc" name="id_danhmuc" required>
                                    <option value="" selected disabled>Chọn Danh Mục</option>
                                    <?= $options ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mota" class="form-label fw-bold">Mô Tả</label>
                                <textarea class="form-control" id="mota" name="mota" required placeholder="Vui lòng nhập đủ thông tin..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="hocphi" class="form-label fw-bold">Giá Khóa Học</label>
                                <input type="text" class="form-control" id="hocphi" name="hocphi" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3">
                                <label for="anhkh" class="form-label fw-bold">Ảnh Khóa Học</label>
                                <input type="file" class="form-control" id="anhkh" name="anhkh" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                                <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submitKH">XÁC NHẬN</button>
                            </div>
                        `;
                    } else if (tabId === "tab2") {
                        // Form dành cho "HỌC VIÊN"
                        addForm.innerHTML = `
                            <div class="mb-3">
                                <label for="tenhv" class="form-label fw-bold">Họ và Tên</label>
                                <input type="text" class="form-control" id="tenhv" name="tenhv" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3 row">
                                <label class="form-label fw-bold">Giới Tính</label>
                                <div class="col">
                                    <div>
                                        <input type="radio" id="gioitinh_nam" name="gioitinh" value="Nam" required placeholder="Vui lòng nhập đủ thông tin...">
                                        <label for="gioitinh_nam">Nam</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <input type="radio" id="gioitinh_nu" name="gioitinh" value="Nữ" required placeholder="Vui lòng nhập đủ thông tin...">
                                        <label for="gioitinh_nu">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3">
                                <label for="sdt" class="form-label fw-bold">SĐT</label>
                                <input type="text" class="form-control" id="sdt" name="sdt" required
                                    placeholder="Vui lòng nhập đủ thông tin..."
                                    oninput="validatePhoneNumber(this)"
                                    />
                                <small id="error-message" style="color: red; display: none;">SĐT phải bắt đầu bằng số 0 và có đúng 10 số.</small>
                            </div>
                            <div class="mb-3">
                                <label for="ngaysinh" class="form-label fw-bold">Ngày Sinh</label>
                                <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3">
                                <label for="anhhv" class="form-label fw-bold">Ảnh Học viên</label>
                                <input type="file" class="form-control" id="anhhv" name="anhhv" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                                <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submit">XÁC NHẬN</button>
                            </div>
                        `;
                    } else if (tabId === "tab3") {
                        // Form dành cho "GIẢNG VIÊN"
                        addForm.innerHTML = `
                            <div class="mb-3">
                                <label for="tengv" class="form-label fw-bold">Họ và Tên</label>
                                <input type="text" class="form-control" id="tengv" name="tengv" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3 row">
                                <label class="form-label fw-bold">Giới Tính</label>
                                <div class="col">
                                    <div>
                                        <input type="radio" id="gioitinh_nam" name="gioitinh" value="Nam" required placeholder="Vui lòng nhập đủ thông tin...">
                                        <label for="gioitinh_nam">Nam</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <input type="radio" id="gioitinh_nu" name="gioitinh" value="Nữ" required placeholder="Vui lòng nhập đủ thông tin...">
                                        <label for="gioitinh_nu">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3">
                                <label for="sdt" class="form-label fw-bold">SĐT</label>
                                <input type="text" class="form-control" id="sdt" name="sdt" required
                                    placeholder="Vui lòng nhập đủ thông tin..."
                                    oninput="validatePhoneNumber(this)"
                                    />
                                <small id="error-message" style="color: red; display: none;">SĐT phải bắt đầu bằng số 0 và có đúng 10 số.</small>
                            </div>
                            <div class="mb-3">
                                <label for="ngaysinh" class="form-label fw-bold">Ngày Sinh</label>
                                <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3">
                                <label for="anhgv" class="form-label fw-bold">Ảnh Giảng viên</label>
                                <input type="file" class="form-control" id="anhgv" name="anhgv" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                                <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submit">XÁC NHẬN</button>
                            </div>
                        `;
                    } else if (tabId === "tab4") {
                        addForm.innerHTML = `
                            <div class="mb-3">
                                <?php
                                $error = '';
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $id_hocvien = $_POST['id_hocvien'] ?? '';

                                    if (empty($id_hocvien)) {
                                        $error = "Vui lòng chọn một học viên.";
                                    } else {
                                        // Xử lý form khi đã có lựa chọn hợp lệ cho học viên
                                    }
                                }
                                ?>
                                <label for="hocvien" class="form-label fw-bold">Chọn Học Viên</label>
                                <select class="form-select" id="id_hocvien" name="id_hocvien" required>
                                    <option value="" selected disabled>Chọn Học Viên</option>
                                    <?= $optionsHVDH ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <?php
                                $error = '';
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $id_lophoc = $_POST['id_lophoc'] ?? '';

                                    if (empty($id_lophoc)) {
                                        $error = "Vui lòng chọn một Lớp học.";
                                    } else {
                                        // Xử lý form khi đã có lựa chọn hợp lệ cho học viên
                                    }
                                }
                                ?>
                                <label for="khoahoc" class="form-label fw-bold">Chọn Khóa Học</label>
                                <select class="form-select" id="id_lophoc" name="id_lophoc" required>
                                    <option value="" selected disabled>Chọn Lớp Học</option>
                                    <?= $optionsLHCH ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ngaydk" class="form-label fw-bold">Ngày Đăng Ký</label>
                                <input type="date" class="form-control" id="ngaydk" name="ngaydk" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                                <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submitDK">XÁC NHẬN</button>
                            </div>
                        `;
                    }else if (tabId === "tab8") {
                        addForm.innerHTML = `
                            <div class="mb-3">
                                <?php
                                $error = '';
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $id_cahoc = $_POST['id_cahoc'] ?? '';

                                    if (empty($id_cahoc)) {
                                        $error = "Vui lòng chọn một ca học.";
                                    } 
                                }
                                ?>
                                <select class="form-select" id="id_cahoc" name="id_cahoc" required>
                                    <option value="" selected disabled>Chọn Ca Thi</option>
                                    <?= $optionsCH ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <?php
                                $error = '';
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $id_lophoc = $_POST['id_lophoc'] ?? '';

                                    if (empty($id_lophoc)) {
                                        $error = "Vui lòng chọn một lớp học.";
                                    } 
                                }
                                ?>
                                <select class="form-select" id="id_lophoc" name="id_lophoc" required>
                                    <option value="" selected disabled>Chọn Lớp Thi</option>
                                    <?= $optionsLH ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ngaydk_thi" class="form-label fw-bold">Ngày Đăng Ký Thi</label>
                                <input type="date" class="form-control" id="ngaydk_thi" name="ngaydk_thi" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="mb-3">
                                <label for="phong" class="form-label fw-bold">Phòng Thi</label>
                                <input type="text" class="form-control" id="phong" name="phong" required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                                <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submitDKTHI">XÁC NHẬN</button>
                            </div>
                        `;
                    }
                    
                    // Hiển thị modal
                    const addModal = new bootstrap.Modal(document.getElementById("addModal"));
                    addModal.show();
                });
            });

            document.querySelectorAll(".btn-themHV").forEach(btn => {
                btn.addEventListener("click", function() {
                    const idLopHoc = this.getAttribute("data-id_lophoc"); // Lấy id_lophoc từ thuộc tính data-id_lophoc

                    // Tạo id modal dựa trên id_lophoc
                    const modalId = `themHVModal${idLopHoc}`;

                    // Lấy modal tương ứng
                    const themHVModal = new bootstrap.Modal(document.getElementById(modalId));
                    themHVModal.show();

                    // Đặt giá trị id_lophoc vào form (nếu cần thiết)
                    const inputLopHoc = document.querySelector(`#${modalId} input[name="id_lophoc"]`);
                    inputLopHoc.value = idLopHoc;
                });
            });

            document.querySelectorAll(".btn-themDM").forEach(btn => {
                btn.addEventListener("click", function() {
                    const tabId = this.closest(".tab-pane").id;
                    addForm.innerHTML = ''; // Xóa nội dung form trước đó

                    if (tabId == "tab1") {
                        addForm.innerHTML = `
                            <div class="mb-3">
                                <label for="TenDM" class="form-label fw-bold">Tên Danh Mục</label>
                                 <input type="text" class="form-control" id="TenDM" name="TenDM" placeholder="Nhập tên danh mục..." required placeholder="Vui lòng nhập đủ thông tin...">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                                <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submit">XÁC NHẬN</button>
                            </div>
                        `;
                    }

                    // Hiển thị modal
                    const addModal = new bootstrap.Modal(document.getElementById("addModal"));
                    addModal.show();
                });
            });
        });
    </script>

    <!-- Lịch Học-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addForm = document.getElementById("addForm");

            document.querySelectorAll("._TKCaHoc").forEach(button => {
                button.addEventListener("click", function() {
                    // Tìm hàng (tr) chứa nút được nhấn
                    const row = button.closest("tr");

                    // Lấy nội dung từ các ô (td) trong hàng
                    const tenCH = row.children[0].textContent.trim();

                    const gio_BD = row.children[1].textContent.trim();
                    
                    const gio_KT = row.children[2].textContent.trim();

                    const idCaHoc = button.getAttribute("data-id_cahoc");
                    addForm.innerHTML = `
                        <input type="hidden" name="id_cahoc" value="${idCaHoc}">
                        <div class="mb-3">
                            <label for="tenCH">Tên Ca Học</label>
                            <input type="text" class="form-control" name="tenCH" id="tenCH" value="${tenCH}">
                        </div>
                        <div class="mb-3">
                            <label for="gio_BD">Giờ Bắt Đầu</label>
                            <input type="text" class="form-control" name="gio_BD" id="gio_BD" value="${gio_BD}">
                        </div>
                        <div class="mb-3">
                            <label for="gio_KT">Giờ Kết Thúc</label>
                            <input type="text" class="form-control" name="gio_KT" id="gio_KT" value="${gio_KT}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                            <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="updateCH">XÁC NHẬN</button>
                        </div>
                    `;


                    // Hiển thị modal
                    const modal = new bootstrap.Modal(document.getElementById("addModal"));
                    modal.show();
                });
            });
            
            document.querySelectorAll(".btn-themCaHoc").forEach(button => {
                button.addEventListener("click", function() {

                    addForm.innerHTML = `
                        <div class="mb-3">
                            <label for="tenCH" class="form-label fw-bold">Tên Ca Học</label>
                            <input type="text" class="form-control" id="tenCH" name="tenCH" required placeholder="Vui lòng nhập đủ thông tin...">
                        </div>
                        <div class="mb-3">
                            <label for="gio_BD" class="form-label fw-bold">Giờ Bắt Đầu</label>
                            <input type="text" class="form-control" id="gio_BD" name="gio_BD" required placeholder="Vui lòng nhập đủ thông tin...">
                        </div>
                        <div class="mb-3">
                            <label for="gio_KT" class="form-label fw-bold">Giờ Kết Thúc</label>
                            <input type="text" class="form-control" id="gio_KT" name="gio_KT" required placeholder="Vui lòng nhập đủ thông tin...">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                            <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submitCH">XÁC NHẬN</button>
                        </div>
                    `;

                    // Hiển thị modal
                    const modal = new bootstrap.Modal(document.getElementById("addModal"));
                    modal.show();
                });
            });

        });
    </script>

    <script src="../../assets/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>