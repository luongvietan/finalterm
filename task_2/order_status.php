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

// Hiển thị thông tin đơn hàng và trạng thái thanh toán
?>

<h2>Order status</h2>

<p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
<p><strong>Name:</strong> <?php echo $order['agent_name']; ?></p>
<p><strong>Email:</strong> <?php echo $order['email']; ?></p>
<p><strong>Category:</strong> <?php echo $order['item_name']; ?></p>
<p><strong>Price:</strong> <?php echo number_format($order['item_price']); ?>.000 VND</p>
<p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
<p><strong>Total:</strong> <?php echo number_format($order['quantity'] * $order['item_price']); ?>.000 VND</p>
<p><strong>Status:</strong> <?php echo $order['order_status'] == 'paid' ? 'Paid' : 'Pending'; ?></p>

<p><a href="list_items.php">Back to item list</a></p>

