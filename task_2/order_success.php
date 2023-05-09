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
echo "Đơn Hàng Đã Được Thanh Toán !";
echo "<br>";
echo "<a href='list_items.php'><button>Quay về trang chính</button></a>";

// Đóng kết nối tới cơ sở dữ liệu
$conn->close();
?>
</body>
</html>
