<?php
// Kiểm tra xem người dùng đã nhấn nút Đăng ký chưa
if (isset($_POST['register'])) {
    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'admin', 'admin', 'form2');

    // Lấy dữ liệu từ biểu mẫu
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra xem tên người dùng đã tồn tại chưa
    $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "Tên người dùng hoặc email đã tồn tại!";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $insertQuery = "INSERT INTO users (username, phone, email, password) VALUES ('$username', '$phone', '$email', '$password')";
        mysqli_query($conn, $insertQuery);
        echo "Đăng ký thành công!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
</head>
<body>
    <h2>Đăng ký</h2>
    <form method="POST" action="register.php">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="register" value="Đăng ký">
    </form>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</body>
</html>
