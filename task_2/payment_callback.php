<?php
// Kết nối cơ sở dữ liệu
$db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'username', 'password');

// Lấy thông tin đơn hàng từ tham số URL
$order_id = $_GET['orderId'];
$order = $db->prepare('SELECT * FROM orders WHERE id = ?');
$order->execute([$order_id]);
$order = $order->fetch(PDO::FETCH_ASSOC);

// Nếu không tìm thấy đơn hàng, trả về lỗi
if (!$order) {
  http_response_code(400);
  die('Invalid order ID');
}

// Kiểm tra trạng thái thanh toán của đơn hàng
// Nếu đã thanh toán rồi, không cần xử lý lại
if ($order['status'] == 'paid') {
  http_response_code(200);
  die('OK');
}

// Kiểm tra kết quả thanh toán và cập nhật trạng thái của đơn hàng
if ($_GET['errorCode'] == 0 && $_GET['amount'] == $order['quantity'] * $order['price']) {
  $db->prepare('UPDATE orders SET status = "paid" WHERE id = ?')->execute([$order_id]);
  http_response_code(200);
  die('OK');
} else {
  http_response_code(400);
  die('Invalid payment');
}