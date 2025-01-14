<?php
    session_start();

    require_once "../../route/route_khoahoc/khoahoc.php";

    $get_id = $_GET['ID_KhoaHoc'];

    $khoahoc = new DS_KHOAHOC();
    $khoahoc_info = $khoahoc->get($get_id);

    if (isset($_POST['submit'])) {
        $TenKH = $_POST['tenkh'];
        $MoTa = $_POST['mota'];
        $HocPhi = $_POST['hocphi'];

        if (isset($_FILES['anhkh']) && !empty($_FILES['anhkh']['name'])) {
            $anhkh = $_FILES['anhkh']['name'];
            $ext = pathinfo($anhkh, PATHINFO_EXTENSION);
            $filename = $get_id . '.' . $ext;

            if (move_uploaded_file($_FILES['anhkh']['tmp_name'], "./anhkh/" . $filename)) {
                if ($khoahoc->update_khoahoc($get_id, $tenkh, $filename, $mota, $hocphi)) {
                    header("Location: ../../pages/admin_pages/index.php");
                    exit();
                } else {
                    echo "Cập nhật thất bại!";
                }
            } else {
                echo "Lỗi upload ảnh!";
            }
        } else {
            // Nếu không có hình ảnh mới, giữ nguyên giá trị hiện tại
            $filename = $khoahoc_info['AnhKH'];

            // Cập nhật hocvien vào cơ sở dữ liệu
            if ($khoahoc->update_khoahoc($get_id, $TenKH, $filename, $MoTa, $HocPhi)) {
                echo '<div class="alert alert-success text-center">Update khoahoc successful</div>';
                header("Location: ../../pages/admin_pages/index.php");
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            } else {
                echo '<div class="alert alert-warning text-center">Failed to update khoahoc in database.</div>';
            }
        }
    }
    
    
    require_once "../../route/route_noidung/noidung_khoahoc.php";
    $noidung = new DS_NDKH();
    $noidung_info = $noidung->get_By_ID_Khoahoc($get_id);
    
    if(isset($_POST['submitNDBH'])){
        $tennd = $_POST['tennd'];
        
        if (isset($_FILES['tailieu']) && !empty($_FILES['tailieu']['name'])) {
            $tailieu = $_FILES['tailieu']['name'];

            // Lấy phần mở rộng của file ảnh
            $ext = pathinfo($tailieu, PATHINFO_EXTENSION);
            $get_num = $noidung->max_id() + 1; // Giả sử hàm max_id() lấy ID lớn nhất hiện có
            $filename = $get_num . '.' . $ext; // Tạo tên file mới với ID và phần mở rộng

            $target_dir = __DIR__ . ' ../../../route/route_noidung/TAILIEU/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $target_file = $target_dir . $filename;

            if (move_uploaded_file($_FILES['tailieu']['tmp_name'], $target_file)) {
                // Thêm slide vào cơ sở dữ liệu
                $noidung->add_noidung_kh($tennd, $filename, $get_id);
                        
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm nội dung bài học thành công!";
                $_SESSION['status_type'] = "success"; // success, error, warning

                // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            } else {
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Thêm nội dung bài học không thành công!.";
                $_SESSION['status_type'] = "error"; // success, error, warning
                
                // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            }
        } else {
            echo '<div class="alert alert-warning text-center">Thiếu file tài liệu</div>';
        }
        
        // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
        header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
        exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
    }
    
    
    if(isset($_POST['updateNDBH'])){
        $tennd = $_POST['tennd'];
        $id_noidung = $_POST['id_noidung'];
        
        if (isset($_FILES['tailieu']) && !empty($_FILES['tailieu']['name'])) {
            $tailieu = $_FILES['tailieu']['name'];
            $ext = pathinfo($tailieu, PATHINFO_EXTENSION);
            $filename = $get_id . '.' . $ext;

            if (move_uploaded_file($_FILES['tailieu']['tmp_name'], "./tailieu/" . $filename)) {
                if ($noidung->update_noidung_kh($id_noidung, $get_id, $tennd, $filename)) {
                    
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Sửa nội dung bài học thành công!";
                    $_SESSION['status_type'] = "success"; // success, error, warning

                    // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                    header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
                    exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
                } else {
                    // Sau khi thêm, xóa, hoặc cập nhật thành công:
                    $_SESSION['status_message'] = "Sửa nội dung bài học không thành công!.";
                    $_SESSION['status_type'] = "error"; // success, error, warning
                    
                    // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                    header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
                    exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
                }
            } else {
                echo '<div class="alert alert-warning text-center">Thiếu file tài liệu</div>';
            }
        } else {
            // Nếu không có hình ảnh mới, giữ nguyên giá trị hiện tại
            $filename = $noidung_info['TaiLieu'];
            
            // Cập nhật hocvien vào cơ sở dữ liệu
            if ($noidung->update_noidung_kh($id_noidung, $get_id, $tennd, $filename)) {
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Sửa nội dung bài học thành công!";
                $_SESSION['status_type'] = "success"; // success, error, warning

                // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            } else {
                // Sau khi thêm, xóa, hoặc cập nhật thành công:
                $_SESSION['status_message'] = "Sửa nội dung bài học không thành công!.";
                $_SESSION['status_type'] = "error"; // success, error, warning
                
                // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
                header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
                exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
            }
        }
        
        // Chuyển hướng đến trang thành công (hoặc trang khác nếu cần)
        header("Location: " . $_SERVER['PHP_SELF'] . "?ID_KhoaHoc=" . urlencode($get_id));
        exit(); // Đảm bảo script dừng lại sau khi chuyển hướng
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="../../assets/images/icons/icon-web.png" rel="shortcut icon" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="../../assets/js/confirmDelete.js"></script>
    <title>CẬP NHẬT THÔNG TIN KHÓA HỌC</title>
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
            background-size: cover;
            /* Để ảnh nền phủ toàn bộ */
        }

        .box-img {
            width: 100%;
            height: 90%;
            border-radius: 20px;

        }

        .formKH {
            width: 45vw;
            height: 60vh;
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 25%;
            transform: translate(-50%, -50%);
            border-radius: 20px;
            animation-delay: .2s;
            filter: blur(20px);
            opacity: 0;
            animation: showContent 0.2s 1s linear 1 forwards;
            background-image: url(../../assets/images/banner_edit/6.png);
            background-size: cover;
        }

        .danhsach {
            position: absolute;
            top: 50%;
            right: 25%;
            transform: translate(0%, 40%);
            width: 45vw;
            height: 60vh;
            padding: 20px;
            top: 0;
            right: 0;
            animation-delay: .2s;
            filter: blur(20px);
            opacity: 0;
            animation: showContent 0.2s 1s linear 1 forwards;
        }

        @keyframes showContent {
            to {
                opacity: 1;
                filter: blur(0);
            }
        }

        h1 {
            animation-delay: .2s;
            filter: blur(20px);
            opacity: 0;
            transform: translateY(-100px);
            animation: showH1 0.2s .5s linear 1 forwards;
        }
        
        .btn-themND{
            animation-delay: .2s;
            filter: blur(20px);
            opacity: 0;
            transform: translateX(100px);
            animation: showBtnND 0.2s .5s linear 1 forwards;
        }
        
        @keyframes showBtnND {
            to {
                opacity: 1;
                filter: blur(0);
                transform: translateX(0);
            }
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
        .list-group{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .list-group-item{
            background: transparent!important;
            border: none !important;
        }

    </style>
</head>

<body>
    <div class="content row">
        <div class="col">
            <h1 class="text-center fw-bold fst-italic mt-5 text-light">THÔNG TIN KHÓA HỌC</h1>
            <form action="" method="post" enctype="multipart/form-data" class="row m-0 formKH">
                <div class="hocvien-image col-5 d-flex flex-column justify-content-between">

                    <div class="box-img mb-3">
                        <img id="preview-image" src="./ANHKH/<?= htmlspecialchars($khoahoc_info['AnhKH']) ?>?t=<?= time(); ?>" alt="Ảnh khóa học" class="img-fluid rounded object-fit-contain">
                    </div>

                    <input type="file" class="form-control w-100" name="anhkh" id="anhkh">

                </div>

                <div class="col-7 h-100 d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <label for="tenkh" class="form-label fw-bold text-light">Tên Khóa Học</label>
                        <input type="text" class="form-control" id="tenkh" name="tenkh" value="<?= htmlspecialchars($khoahoc_info['TenKH']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mota" class="form-label fw-bold text-light">Mô Tả</label>
                        <textarea type="mota" class="form-control" rows="4" id="mota" name="mota"><?= htmlspecialchars($khoahoc_info['MoTa']) ?></textarea>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label for="hocphi" class="form-label fw-bold text-light">Học Phí</label>
                            <input type="text" class="form-control" id="hocphi" name="hocphi" value="<?= htmlspecialchars($khoahoc_info['HocPhi']) ?>">
                        </div>
                    </div>
                    <div class="btn-update pt-3 d-flex row justify-content-evenly">
                        <button type="submit" name="submit" class="col-5 btn btn-primary fw-bold">EDIT</button>
                        <button type="button" onclick="window.location.href='../../pages/admin_pages/index.php'" class="col-5 btn btn-danger fw-bold">CANCEL</button>
                    </div>
                </div>
            </form>
        </div>
        
        <button class="btn btn-primary position-fixed end-0 rounded-0 btn-themND" style="width: 200px; top: 0px;">Thêm Nội Dung Bài Học</button>
        
        <ul class="p-0 danhsach col">
            <?php
                while ($row_ndkh = mysqli_fetch_assoc($noidung_info)){
            ?>
            
                <li class="list-group-item bg-transparent row py-2">
                    <span><?=$row_ndkh['TenND']?></span>
                    <a href="../route_noidung/TAILIEU/<?=$row_ndkh['TaiLieu']?>" class="fst-italic" download="<?=$row_ndkh['TaiLieu']?>">Tài liệu</a>
                    <button class="btn btn-success rounded-0 btn-editND py-0 ms-5" style="width: 70px;" data-id="<?= $row_ndkh['ID_NoiDung'] ?>">SỬA</button>
                    <button class="btn btn-danger rounded-0 btn-editND py-0" style="width: 70px;" onclick="confirmDelete('../route_noidung/delete_noidung.php?ID_NoiDung=<?=$row_ndkh['ID_NoiDung']?>', '<?= $row_ndkh['TenND']; ?>')">XÓA</button>
                </li>
            
            <?php } ?>
        </ul>
    </div>
    
    <!-- Modal-ADD -->
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
    
    <!-- Modal-EDIT -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content px-4 py-3">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="editModalLabel">Chỉnh sửa nội dung bài học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="" method="post" enctype="multipart/form-data">
                        <!-- Nội dung form sẽ được chèn động bằng JavaScript -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- addModal -->
    <script>
        document.getElementById('anhkh').addEventListener('change', function(event) {
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
    
    <!-- editModal -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".btn-editND").forEach(button => {
                button.addEventListener("click", function () {
                    const id = this.getAttribute("data-id");

                    // Gửi yêu cầu AJAX đến máy chủ để lấy dữ liệu của ID_NoiDung
                    fetch(`../route_noidung/get_noidung.php?ID_NoiDung=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Chèn dữ liệu vào form trong modal
                                const editForm = document.getElementById("editForm");
                                editForm.innerHTML = `
                                    <input type="hidden" name="id_noidung" value="${id}"/>
                                    <div class="mb-3">
                                        <label for="tennd" class="form-label fw-bold">Tên Bài Học</label>
                                        <input type="text" class="form-control" id="tennd" name="tennd" value="${data.TenND}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tailieu" class="form-label fw-bold">File Tài Liệu</label>
                                        <input type="file" class="form-control" id="tailieu" name="tailieu">
                                        <small>Hiện tại: ${data.TaiLieu}</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary" name="updateNDBH" value="${id}">Lưu thay đổi</button>
                                    </div>
                                `;

                                // Hiển thị modal
                                const modal = new bootstrap.Modal(document.getElementById("editModal"));
                                modal.show();
                            }
                        })
                        .catch(error => {
                            console.error("Error fetching data:", error);
                        });
                });
            });
        });
    </script>
    
    <!-- Lịch Học-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addForm = document.getElementById("addForm");

            document.querySelectorAll(".btn-themND").forEach(button => {
                button.addEventListener("click", function() {
                    
                    addForm.innerHTML = `
                        <div class="mb-3">
                            <label for="tennd" class="form-label fw-bold">Tên Bài Học</label>
                            <input type="text" class="form-control" id="tennd" name="tennd" required placeholder="Vui lòng nhập đủ thông tin...">
                        </div>
                        <div class="mb-3">
                            <label for="tailieu" class="form-label fw-bold">File Tài Liệu</label>
                            <input type="file" class="form-control" id="tailieu" name="tailieu" required placeholder="Vui lòng nhập đủ thông tin...">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn px-3 btn-secondary" data-bs-dismiss="modal">ĐÓNG</button>
                            <button type="submit" class="btn px-4 btn-primary" id="saveBtn" name="submitNDBH">XÁC NHẬN</button>
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
</body>

</html>