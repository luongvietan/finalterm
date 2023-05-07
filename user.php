<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Hiển thị trang người dùng
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang Người dùng</title>
</head>
<body>
    <h1>Xin chào, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Đây là trang người dùng.</h2>
    <a href="logout.php">Đăng xuất</a>
</body>
</html>
