<?php
session_start();

// Hàm để tạo một chuỗi ngẫu nhiên
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "form2";

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hàm sinh order_id
function generateOrderID()
{
    $randomNumber = mt_rand(100, 999); // Sinh số ngẫu nhiên từ 100 đến 999
    return "Order" . $randomNumber;
}

// Truy vấn dữ liệu từ bảng "cart"
$sql = "SELECT item_id, item_name, price, quantity, order_id, total FROM cart";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mảng để lưu trữ thông tin các hàng
    $orderItems = array();
    // Khởi tạo biến $totalPrice
    $totalPrice = 0;

    while ($row = $result->fetch_assoc()) {
        $itemID = $row["item_id"];
        $itemName = $row["item_name"];
        $itemPrice = $row["price"];
        $quantity = $row["quantity"];
        $orderID = $row["order_id"];
        $totalPrice += $row["total"]; // Cập nhật tổng giá trị

        // Kiểm tra xem item_id đã tồn tại trong mảng chưa
        if (array_key_exists($itemID, $orderItems)) {
            // Kiểm tra trạng thái của hàng đã tồn tại
            $existingStatus = $orderItems[$itemID]["order_status"];

            // Nếu trạng thái là "pending", cập nhật giá trị quantity
            if ($existingStatus == "pending") {
                $orderItems[$itemID]["quantity"] += $quantity;
            }
        } else {
            // Nếu item_id chưa tồn tại, thêm mới vào mảng
            $orderItems[$itemID] = array(
                "item_name" => $itemName,
                "item_price" => $itemPrice,
                "quantity" => $quantity,
                "order_status" => "pending"
            );
        }
    }

    // Thực hiện các thao tác cập nhật và thêm mới vào bảng "orders" dựa trên mảng
    foreach ($orderItems as $itemID => $itemData) {
        $itemName = $itemData["item_name"];
        $itemPrice = $itemData["item_price"];
        $quantity = $itemData["quantity"];
        $orderStatus = $itemData["order_status"];

        if ($orderStatus == "pending") {
            // Nếu trạng thái là "pending", tạo order_id mới và thêm mới vào bảng "orders"
            $newOrderID = generateOrderID();
            $paymentMethod = "momopay";
            $insertQuery = "INSERT INTO orders (order_id, item_id, item_name, item_price, payment_method, order_status, quantity)
            VALUES ('$newOrderID', '$itemID', '$itemName', '$itemPrice', '$paymentMethod', '$orderStatus', $quantity)";
            $conn->query($insertQuery);

            // Đánh dấu rằng dữ liệu đã được thêm vào cơ sở dữ liệu
            $_SESSION['data_added'] = true;

           

            // Gửi yêu cầu tạo QR Code
            $curl = curl_init();
            $t = 1000;
            $randomString = generateRandomString(6);

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
            CURLOPT_POSTFIELDS => json_encode(array(
                'type' => 'text',
                'data' => '2|99|0384398634|LUONG VIET AN||0|0|'.$totalPrice * $t.'|'.$randomString.'|transfer_myqr',
                'background' => 'rgb(255,255,255)',
                'foreground' => 'rgb(0,0,0)',
                'logo' => 'https://site.com/logo.png',
            )),
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                echo "Error 2: " . curl_error($curl);
            } else {
                $huy = json_decode($response);
            }
            
            curl_close($curl);
        }
        
    }
    echo "<h3>Tong Gia Tri Don Hang : ".$totalPrice * $t;
}

?>

<body>
<form action="#" method="post">
    <input type="submit" name="QRCode" value="Recreate QR Code">
</form>
<img src="<?= $huy->link; ?>" alt="">
<br>
<br><button onclick="redirectToOrdersPending()">Xem Tình Trạng Đơn Hàng</button>

<script>
    function redirectToOrdersPending() {
        window.location.href = "orders_pending.php";
    }
</script>
</body>
</html>

