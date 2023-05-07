<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập và có quyền quản trị hay không
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin.php");
  exit();
}

// Kiểm tra xem người dùng đã nhấn nút Approve hay chưa
if (isset($_POST['approve'])) {
  $order_id = $_POST['order_id'];

  // Cập nhật trạng thái của đơn hàng trong cơ sở dữ liệu
  // Ví dụ: UPDATE orders SET status='approved' WHERE id=$order_id;
  // Sau đó, lưu trạng thái mới vào session để sử dụng trên trang payment_cash.php
  $_SESSION['order_status'] = 'approved';

  // Chuyển hướng người dùng đến trang order_success.php
  header("Location: order_success.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Orders</title>
</head>
<body>
  <h1>Orders</h1>
  <table>
    <tr>
      <th>Order ID</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
    <tr>
      <td>12345</td>
      <td>Pending</td>
      <td>
        <form method="post">
          <input type="hidden" name="order_id" value="12345">
          <button type="submit" name="approve">Approve</button>
        </form>
      </td>
    </tr>
    <!-- các hàng khác -->
  </table>
</body>
</html>
