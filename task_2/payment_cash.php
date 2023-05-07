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

?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment - Cash</title>
</head>
<body>
  <h1>Payment - Cash</h1>
  <p>Your order is being processed. Please wait for approval from the administrator.</p>
</body>
</html>
