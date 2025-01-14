<?php
    require "../../route/route_nhanvien/taikhoan_nhanvien.php";
    $taikhoan = new DS_TAIKHOAN();
    
    session_start();

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $matkhau = $_POST['matkhau'];

        $conn = $taikhoan->conn(); // Kết nối CSDL

        // Truy vấn để lấy thông tin người dùng với email đã nhập
        $query = "SELECT * FROM taikhoan WHERE Email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            // Sử dụng matkhau_verify để kiểm tra mật khẩu đã nhập với mã hash trong cơ sở dữ liệu
            if (password_verify($matkhau, $row['MatKhau'])) {
                if ($row['Role'] == 'admin') {
                    $_SESSION['AD_NAME'] = $row['Ten_TK'];
                    $_SESSION['ID_TaiKhoan'] = $row['ID_TaiKhoan'];
                    
                    header('Location: ../admin_pages/index.php');
                    exit(); // Thêm exit để đảm bảo điều hướng');
                } else if ($row['Role'] == 'user') {
                    $_SESSION['GV_NAME'] = $row['Ten_TK'];
                    $_SESSION['ID_TaiKhoan'] = $row['ID_TaiKhoan'];
                    
                    header('Location: ../admin_pages/index.php');
                    exit(); // Thêm exit để đảm bảo điều hướng');
                }
            } else {
                $error[] = 'Sai mật khẩu hoặc email';
            }
        } else {
            $error[] = 'Sai mật khẩu hoặc email';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="../../assets/images/icons/icon-web.png" rel="shortcut icon" role="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/fontawesome-free-6.3.0-web/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/account.css">
    <script src="../../assets/js/password.js"></script>
    <title>LOGIN - ĐĂNG NHẬP TÀI KHOẢN</title>
</head>

<body>
    <section class="row m-0 p-0">
        <div class="position-relative col-md-8 p-0">
            <div class="overlay">
                <h1 class="col-9 fw-bold text-uppercase fst-italic"><span>Welcome Back!</span> <br> Let's Continue Your Learning Adventure!</h1>
            </div>
            <div class="banner">
                <img src="../../assets/images/account/img_login.png" alt="">
            </div>
            
        </div>
        <div class="login-container col-md-4">
            <div class="text-head">
                <span class="top-left"></span>
                <h2 class="d-flex">PAGE 
                    <p class="text-primary m-0 ps-2">LOGIN</p>
                </h2>
                <span class="bottom-right"></span>
            </div>
            
            <div class="social-login">
                <button class="rounded-circle d-flex justify-content-center" onclick="window.location.href='../../home.php'"><i class="fa-brands fa-facebook-f"></i></button>
                <button class="rounded-circle d-flex justify-content-center" onclick="window.location.href='./Google/google_source.php'"><i class="fa-brands fa-google"></i></button>
                <button class="rounded-circle d-flex justify-content-center"><i class="fa-brands fa-linkedin"></i></button>
            </div>
            
            <p>or use your email account</p>
            <form action="" method="post" class="col-8">
                
                 <?php
                    if (isset($error)) {
                        foreach ($error as $error) {
                            echo '<span class="error-msg text-danger mb-3 d-flex justify-content-center">' .$error. '</span>';
                        }
                    }
                ?>
            
                <div class="input-group">
                    <input type="email" class="input form-control bg-opacity-50" id="email" name="email" required>
                    <label for="email" class="form-label">Email</label>
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                </div>

                <div class="input-group">
                    <input type="password" class="input form-control bg-opacity-50" id="password" name="matkhau" required>
                    <label for="password" class="form-label">Password</label>
                    <!-- show-hide password -->
                    <span class="input-group-text" onclick="togglePassword()">
                        <i class="fa-solid fa-lock" id="toggleIcon"></i>
                    </span>
                </div>
                
                <button type="submit" name="login" class="login-btn mx-auto col-12 d-flex justify-content-center">LOGIN</button>
                
                <div class="to-reg text-center mt-3">
                    <span class="text-light">Are you new ?</span>
                    <a href="../account/register.php" class="text-decoration-none nav-link-reg fst-italic text-primary">Create an account.</a>
                </div>
            </form>
        </div>
    </section>

    <!-- script -->
    <script src="./assets/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js "></script>
</body>

</html>