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

// Gửi yêu cầu thanh toán qua Momo API
// Cần cài đặt thư viện PHP cURL trước khi sử dụng
// Hướng dẫn cài đặt: https://curl.se/docs/install.html
$data = [
  'partnerCode' => 'MOMO',
  'accessKey' => 'ACCESS_KEY',
  'requestId' => uniqid('momo_'),
  'amount' => $order['quantity'] * $order['item_price'],
  'orderId' => $order_id,
  'orderInfo' => $order['item_name'] . ' - ' . $order['email'],
  'returnUrl' => 'https://example.com/payment_callback.php',
  'notifyUrl' => 'https://example.com/payment_callback.php',
  'extraData' => '',
];
ksort($data);
$signature = hash_hmac('sha256', http_build_query($data), 'SECRET_KEY');
$data['signature'] = $signature;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://test-payment.momo.vn/gw_payment/transactionProcessor');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$response = json_decode($result, true);

// Kiểm tra kết quả và chuyển hướng đến trang thanh toán của Momo
if ($response['errorCode'] == 0 && $response['payUrl']) {
  header('Location: ' . $response['payUrl']);
} else {
  $error = 'Payment pending. . .';
}

// Hiển thị thông báo lỗi nếu có
if (isset($error)) {
echo '<p>' . $error . '</p>';
}
?>
<p><a href="list_items.php">Back to item list</a></p>
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://bio.ziller.vn/api/qr/add",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 2,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer 3f3c3700b254731a849c8dd020eab3c6",
        "Content-Type: application/json",
    ),
    CURLOPT_POSTFIELDS => json_encode(array (
  'type' => 'link',
  'data' => 'https://google.com',
  'background' => 'rgb(255,255,255)',
  'foreground' => 'rgb(0,0,0)',
  'logo' => 'https://site.com/logo.png',
)),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;