<?php
    require_once "../route_hocvien/hocvien.php";
    
    $get_id = isset($_GET['ID_HocVien']) ? intval($_GET['ID_HocVien']) : 0;
    
    $hocvien = new DS_HOCVIEN();
    $hocvien_info = $hocvien->get($get_id);
    $current_status = $hocvien_info['TrangThai_HV'] ?? 'Đang học';
    $current_gender = $hocvien_info['GioiTinh'] ?? 'Nam';
    
    if(isset($_POST['submit'])) {
        $TenHV = $_POST['TenHV'];
        $GioiTinh = $_POST['GioiTinh'];
        $Email = $_POST['Email'];
        $SDT = $_POST['SDT'];
        $NgaySinh = $_POST['NgaySinh'];
        $TrangThai_HV = $_POST['TrangThai_HV'];
        
        // Kiểm tra nếu hình ảnh hocvien được tải lên
        if (isset($_FILES['AnhHV']) && !empty($_FILES['AnhHV']['name'])) {
            $AnhHV = $_FILES['AnhHV']['name'];
            $ext = pathinfo($AnhHV, PATHINFO_EXTENSION);
            $filename = $get_id . '.' . $ext; // Sử dụng ID của hocvien để đặt tên file

            // Di chuyển file từ thư mục tạm vào thư mục đích
            if (move_uploaded_file($_FILES['AnhHV']['tmp_name'], "./AnhHV/" . $filename)) {
                // Cập nhật hocvien vào cơ sở dữ liệu
                if ($hocvien->update_hocvien($get_id, $TenHV, $filename, $GioiTinh, $Email, $SDT, $NgaySinh, $TrangThai_HV)) {
                    header("Location: ../../pages/admin_pages/index.php");
                    exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
                } else {
                    echo '<div class="alert alert-warning text-center">Failed to update hocvien in database.</div>';
                }
            } else {
                echo '<div class="alert alert-warning text-center">Failed to upload file.</div>';
            }
        } else {
            // Nếu không có hình ảnh mới, giữ nguyên giá trị hiện tại
            $filename = $hocvien_info['AnhHV'];

            // Cập nhật hocvien vào cơ sở dữ liệu
            if ($hocvien->update_hocvien($get_id, $TenHV, $filename, $GioiTinh, $Email, $SDT, $NgaySinh, $TrangThai_HV)) {
                echo '<div class="alert alert-success text-center">Update hocvien successful</div>';
                header("Location: ../../pages/admin_pages/index.php");
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            } else {
                echo '<div class="alert alert-warning text-center">Failed to update hocvien in database.</div>';
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="../../assets/images/icons/icon-web.png" rel="shortcut icon" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <title>CẬP NHẬT THÔNG TIN HỌC VIÊN</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html {
            scroll-behavior: smooth;
        }
        ::-webkit-scrollbar {
            display: none;
        }
        body {
            background-image: url(../../assets/images/banner_edit/5.png);
            background-size: cover; /* Để ảnh nền phủ toàn bộ */
        }
        .box-img {
            width: 100%;
            height: 90%;
            border-radius: 20px;
            
        }
        form {
            width: 50vw;
            height: 60vh;
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 20px;
            animation-delay: .2s;
            filter: blur(20px);
            opacity: 0;
            animation: showContent 0.2s 1s linear 1 forwards;
            background-image: url(../../assets/images/banner_edit/6.png);
            background-size: cover;
        }
        @keyframes showContent {
            to {
                opacity: 1;
                filter: blur(0);
            }
        }
        h1{
            animation-delay: .2s;
            filter: blur(20px);
            opacity: 0;
            transform: translateY(-100px);
            animation: showH1 0.2s .5s linear 1 forwards;
        }
        @keyframes showH1 {
            to {
                opacity: 1;
                filter: blur(0);
                transform: translateY(0);
            }
        }
        
        textarea {
            resize: none;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            color: #fff;
            background-color: #1c2f5e;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }

        #preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }
        label {
            color: #5d5d5c;
        }
        .form-control {
            background-color: #fff;
            box-shadow: none;
            color: #1c2f5e;
        }
    </style>
</head>
<body>
    <h1 class="text-center fw-bold fst-italic mt-5 text-light">THÔNG TIN HỌC VIÊN</h1>
    <form action="" method="post" enctype="multipart/form-data" class="row m-0 bg-secondary-subtle">
        <div class="hocvien-image col-5 d-flex flex-column justify-content-between">
            
            <div class="box-img mb-3">
                <img id="preview-image" src="./ANHHV/<?= htmlspecialchars($hocvien_info['AnhHV']) ?>?t=<?= time(); ?>" alt="Ảnh học viên" class="img-fluid rounded">
            </div>
            
            <input type="file" class="form-control w-100" name="AnhHV" id="AnhHV">
            
            <div class="px-2 d-flex justify-content-between align-items-center">
                <div class="TrangThai_HV mt-3 h-100 d-flex align-items-center justify-content-center gap-4">
                    <label class="fw-bold d-flex gap-1">
                        <input type="radio" name="TrangThai_HV" value="Đang học" id="dh-radio" <?= ($current_status === 'Đang học') ? 'checked' : '' ?>>
                        <span class="badge bg-primary">Đang học</span>
                    </label>
                    <label class="fw-bold d-flex gap-1">
                        <input type="radio" name="TrangThai_HV" value="Đã nghỉ học" id="dnh-radio" <?= ($current_status === 'Đã nghỉ học') ? 'checked' : '' ?>>                        
                        <span class="badge bg-danger">Đã nghỉ học</span>
                    </label>
                </div>               
            </div>
            
            <div class="px-2 d-flex justify-content-between align-items-center">
                <div class="GioiTinh mt-3 h-100 d-flex align-items-center justify-content-center gap-4">
                    <label class="fw-bold d-flex gap-1">
                        <input type="radio" name="GioiTinh" value="Nam" id="nam" <?= ($current_gender === 'Nam') ? 'checked' : '' ?>>
                        <span class="badge bg-primary">Nam</span>
                    </label>
                    <label class="fw-bold d-flex gap-1">
                        <input type="radio" name="GioiTinh" value="Nữ" id="nu" <?= ($current_gender === 'Nữ') ? 'checked' : '' ?>>                        
                        <span class="badge bg-danger">Nữ</span>
                    </label>
                    <label class="fw-bold d-flex gap-1">
                        <input type="radio" name="GioiTinh" value="Khác" id="khac" <?= ($current_gender === 'Khác') ? 'checked' : '' ?>>                        
                        <span class="badge bg-success">Khác</span>
                    </label>
                </div>
            </div>
            
        </div>

        <div class="col-7 h-100 d-flex flex-column justify-content-between">
            <div class="mb-3">
                <label for="TenHV" class="form-label fw-bold text-light">Họ và Tên</label>
                <input type="text" class="form-control" id="TenHV" name="TenHV" value="<?= htmlspecialchars($hocvien_info['TenHV']) ?>">
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label fw-bold text-light">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" value="<?= htmlspecialchars($hocvien_info['Email']) ?>">
            </div>
            <div class="mb-3">
                <label for="SDT" class="form-label fw-bold text-light">SĐT</label>
                <input type="text" class="form-control" id="SDT" name="SDT" value="<?= htmlspecialchars($hocvien_info['SDT']) ?>">
            </div>
            <div class="mb-3">
                <label for="NgaySinh" class="form-label fw-bold text-light">Ngày Sinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?= htmlspecialchars(date('Y-m-d', strtotime($hocvien_info['NgaySinh']))) ?>">
            </div>
            <div class="btn-update pt-3 d-flex row justify-content-evenly">
                <button type="submit" name="submit" class="col-5 btn btn-primary fw-bold">EDIT</button>
                <button type="button" onclick="window.location.href='../../pages/admin_pages/index.php'" class="col-5 btn btn-danger fw-bold">CANCEL</button>
            </div>
        </div>
    </form>
    <script>
        document.getElementById('AnhHV').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = document.getElementById('preview-image');
                    image.src = e.target.result;
                    image.style.display = 'block'; // Hiển thị hình ảnh
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
