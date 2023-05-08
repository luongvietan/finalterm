<!DOCTYPE html>
<html>
<head>
    <title>Order Success</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "form2";

// Tạo kết nối tới cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xóa dữ liệu trong bảng "cart"
$sql = "DELETE FROM cart";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu đã được xóa thành công trong bảng cart.";
} else {
    echo "Lỗi khi xóa dữ liệu trong bảng cart: " . $conn->error;
}

// Đóng kết nối tới cơ sở dữ liệu
$conn->close();
?>
</body>
</html>
