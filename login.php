<?php
session_start();

// Kiểm tra xem người dùng đã nhấn nút Đăng nhập chưa
if (isset($_POST['login'])) {
    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'admin', 'admin', 'form2');

    // Lấy dữ liệu từ biểu mẫu
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    // Kiểm tra xem người dùng có phải là admin hay không
    if ($usernameOrEmail === 'admin' && $password === 'admin') {
        $_SESSION['username'] = 'admin';
        header('Location: http://localhost/finalterm/admin.php');
        exit();
    }

    // Kiểm tra xem người dùng tồn tại trong cơ sở dữ liệu hay không
    $query = "SELECT * FROM users WHERE (username='$usernameOrEmail' OR email='$usernameOrEmail') AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username'];
        header('Location: http://localhost/finalterm/task_2/list_items.php');
        exit();
    } else {
        echo "Tên người dùng hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="POST" action="login.php">
        <label for="usernameOrEmail">Tên người dùng hoặc Email:</label>
        <input type="text" id="usernameOrEmail" name="usernameOrEmail" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="login" value="Đăng nhập">
    </form>

    <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</body>
</html>
