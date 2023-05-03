<?php
// Kết nối cơ sở dữ liệu
$db = new PDO('mysql:host=localhost;dbname=form2;charset=utf8', 'admin', 'admin');

// Lấy thông tin mặt hàng được chọn từ tham số URL
$item_id = $_GET['item_id'];
$item = $db->prepare('SELECT * FROM category WHERE Category_ID = ?');
$item->execute([$item_id]);
$item = $item->fetch(PDO::FETCH_ASSOC);

// Nếu không tìm thấy mặt hàng, chuyển hướng về trang danh sách mặt hàng
if (!$item) {
  header('Location: list_items.php');
  exit();
}

// Xử lý biểu mẫu đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $order_id = $item['item_id'];
  $agent_name = $_POST['name'];
  $item_id = $item['Category_ID'];
  $item_des = $item['Category_Description'];
  $name = $_POST['name'];
  $item_name = $item['Category_Name'];
  $item_price = $item['Category_Price'];
  $email = $_POST['email'];
  $quantity = $_POST['quantity'];
  $payment_method = $_POST['payment_method'];

  // Kiểm tra số lượng đặt hàng có hợp lệ không
  if (!is_numeric($quantity) || $quantity < 1 || $quantity > $item['Category_Quantity']) {
    $error = 'Invalid quantity';
  } else {
    // Thêm đơn hàng mới vào cơ sở dữ liệu
    $order = $db->prepare('INSERT INTO orders (order_id, agent_name, item_id, item_name, item_des, item_price, payment_method, order_status, quantity, email) VALUES (?, ?, ?, ?, ?, ?, ?, "pending", ?, ?)');
    $order->execute([$order_id, $agent_name, $item_id, $item_name, $item_des, $item_price, $payment_method, $quantity, $email]);

    // Chuyển hướng đến trang thanh toán
    switch ($payment_method) {
        case 'cash':
            header('Location: payment_cash.php?order_id=' . $db->lastInsertId());
            break;
        case 'transfer':
            header('Location: payment_transfer.php?order_id=' . $db->lastInsertId());
            break;
        case 'momo':
            header('Location: payment_momo.php?order_id=' . $db->lastInsertId());
        break;
    default:
        $error = 'Invalid payment method';
        }
    }
}
?>

<h2>Order <?php echo $item['Category_Name']; ?></h2>
<?php if (isset($error)): ?>
  <p style="color: red"><?php echo $error; ?></p>
<?php endif; ?>
<form method="post">
  <div>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
  </div>
  <div>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
  </div>
  <div>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $item['Category_Quantity']; ?>" required>
  </div>
  <div>
    <label for="payment_method">Payment method:</label>
    <select id="payment_method" name="payment_method" required>
      <option value="cash">Cash</option>
      <option value="transfer">Transfer</option>
      <option value="momo">Momo</option>
    </select>
  </div>
  <button type="submit">Order</button>
</form>
