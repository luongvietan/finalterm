<?php
// Kết nối cơ sở dữ liệu
$db = new PDO('mysql:host=localhost;dbname=form2;charset=utf8', 'admin', 'admin');

// Lấy thông tin đơn hàng từ tham số URL
$order_id = $_GET['order_id'];
$order = $db->prepare('SELECT * FROM orders WHERE order_id = ?');
$order->execute([$order_id]);
$order = $order->fetch(PDO::FETCH_ASSOC);

// Nếu không tìm thấy đơn hàng, chuyển hướng về trang danh sách mặt hàng
if (!$order) {
  header('Location: list_items.php');
  exit();
}

// Cập nhật trạng thái đơn hàng và giảm số lượng hàng trong kho
$db->beginTransaction();
$db->exec('UPDATE orders SET order_status = "paid" WHERE order_id = ' . $order_id);
$db->exec('UPDATE category SET Category_Quantity = Category_Quantity - ' . $order['quantity'] . ' WHERE Category_ID = ' . $order['order_id']);
$db->commit();
?>

<h2>Payment successful</h2>

<p>Your order has been paid in cash. Thank you for your purchase!</p>

<p><a href="order_status.php?order_id=<?php echo $order_id; ?>">Check order status</a></p>
