<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgray; /* Màu nền nhạt */
            color: #721c24; /* Màu chữ cho lỗi */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Chiếm toàn bộ chiều cao của cửa sổ */
            margin: 0;
        }

        .container {
            text-align: center;
            border: 2px solid #f5c6cb; /* Viền xung quanh */
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
        }

        h1 {
            font-size: 5em;
            margin: 0;
            color: #dc3545; /* Màu đỏ */
        }

        h3 {
            font-size: 1.5em;
            color: #856404; /* Màu vàng nhạt */
            margin-top: 10px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545; /* Màu đỏ */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #c82333; /* Màu đỏ tối hơn khi hover */
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h3>THAO TÁC LỖI HÃY QUAY LẠI</h3>
        <a href="./pages/admin_pages/index.php">BACK</a>
        <?php
            if (isset($_GET['error']) && $_GET['error'] === 'student_exists') {
                echo "<p style='color: red;'>Học viên đã tồn tại trong lớp học này.</p>";
            } else {
                echo "<p style='color: red;'>Trang không tồn tại.</p>";
            }
        ?>
    </div>
</body>
</html>
