<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// Kiểm tra xem đơn hàng đã được duyệt hay chưa
$status = isset($_SESSION['order_status']) ? $_SESSION['order_status'] : "pending";
if ($status === "approved") {
  header("Location: order_success.php");
  exit();
}

// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'admin', 'admin', 'form2');

// Lấy thông tin giỏ hàng từ session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

// Lấy thông tin người dùng từ session
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Lưu thông tin giỏ hàng vào bảng orders
foreach ($cart as $item) {
  $itemId = $item['id'];
  $itemName = $item['name'];
  $itemDes = $item['description'];
  $itemPrice = $item['price'];
  $paymentMethod = 'Cash';
  $orderStatus = 'pending';
  $quantity = $item['quantity'];
  
  // Chuẩn bị truy vấn SQL
  $query = "INSERT INTO orders (agent_name, item_id, item_name, item_des, item_price, payment_method, order_status, quantity, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  
  // Gán giá trị vào các tham số trong truy vấn
  mysqli_stmt_bind_param($stmt, "ssssdssis", $_SESSION['username'], $itemId, $itemName, $itemDes, $itemPrice, $paymentMethod, $orderStatus, $quantity, $email);
  
  // Thực thi truy vấn
  mysqli_stmt_execute($stmt);
}

// Xóa thông tin giỏ hàng
unset($_SESSION['cart']);

// Chuyển hướng đến trang thông báo đặt hàng thành công
header("Location: order_success.php");
exit();
?>
