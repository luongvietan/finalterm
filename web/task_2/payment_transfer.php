<?php
// Kết nối cơ sở dữ liệu
$db = new PDO('mysql:host=localhost;dbname=form2;charset=utf8', 'admin', 'admin');

// Lấy thông tin đơn hàng từ tham số URL
$order_id = $_GET['order_id'];
$order = $db->prepare('SELECT * FROM orders WHERE order_id = ?');
$order->execute([$order_id]);
$order = $order->fetch(PDO::FETCH_ASSOC);

// Nếu không tìm thấy đơn hàng, chuyển hướng về trang danh sách
if (!$order) {
    header('Location: list_items.php');
    exit();
    }
    
    // Hiển thị thông tin đơn hàng và hướng dẫn chuyển khoản
    ?>
    
    <h2>Payment instructions</h2>
    <p>Please transfer the total amount of <strong><?php echo $order['quantity'] * $order['item_price']; ?>.000 VND</strong> to the following bank account:</p>
    <ul>
      <li><strong>Bank:</strong> MBBank</li>
      <li><strong>Account number:</strong> 0384398634</li>
      <li><strong>Account name:</strong> Luong Viet An</li>
    </ul>
    <p>After transferring, please take a screenshot or photo of the transaction receipt and send it to us via email: <strong>finaltask@gmail.com</strong>.</p>
    <p>Once we have received your payment, we will update the status of your order.</p>
    <p><a href="order_status.php?order_id=<?php echo $order_id; ?>">Check order status</a></p>