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

if (isset($_POST['QRCode'])) {
    $totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0;
    $randomString = generateRandomString(6);

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
        CURLOPT_POSTFIELDS => json_encode(array(
            'type' => 'text',
            'data' => '2|99|0384398634|LUONG VIET AN||0|0|' . $totalPrice . '|' . $randomString . '|transfer_myqr',
            'background' => 'rgb(255,255,255)',
            'foreground' => 'rgb(0,0,0)',
            'logo' => 'https://site.com/logo.png',
        )),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $huy = json_decode($response);

    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "admin", "admin", "form2");


    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }


    // Lấy dữ liệu từ bảng cart
    $sql = "SELECT order_id, item_id, item_name, price, quantity FROM cart";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn SQL: " . mysqli_error($conn));
    }

    // Tạo một mảng để lưu trữ dữ liệu gộp lại
    $mergedData = array();

    // Lặp qua các hàng trong kết quả truy vấn
    while ($row = mysqli_fetch_assoc($result)) {
        $order_id = $row['order_id'];
        $item_id = $row['item_id'];
        $item_name = $row['item_name'];
        $item_price = $row['price'];
        $quantity = $row['quantity'];

        // Kiểm tra xem order_id đã tồn tại trong mảng mergedData chưa
        if (array_key_exists($order_id, $mergedData)) {
            // Nếu đã tồn tại, tăng giá trị quantity lên
            $mergedData[$order_id]['quantity'] += $quantity;
        } else {
                        // Nếu chưa tồn tại, thêm mới vào mảng mergedData
                        $mergedData[$order_id] = array(
                            'item_id' => $item_id,
                            'item_name' => $item_name,
                            'item_price' => $item_price,
                            'quantity' => $quantity
                        );
                    }
                }
            
                // Thêm dữ liệu vào bảng orders
                foreach ($mergedData as $order_id => $data) {
                    $item_id = $data['item_id'];
                    $item_name = $data['item_name'];
                    $item_des = generateRandomString(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
                    $item_price = $data['item_price'];
                    $payment_method = 'momopay';
                    $order_status = 'pending';
                    $quantity = $data['quantity'];
            
                    $sql = "INSERT INTO orders (order_id, item_id, item_name, item_des, item_price, payment_method, order_status, quantity)
                            VALUES ('$order_id', '$item_id', '$item_name', '$item_des', '$item_price', '$payment_method', '$order_status', '$quantity')
                            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
            
                    if (mysqli_query($conn, $sql)) {
                        echo "<h1>Momo Payment</h1>";
                    } else {
                        echo "Lỗi: " . mysqli_error($conn);
                    }
                }
            
                // Đóng kết nối với cơ sở dữ liệu
                mysqli_close($conn);
            }
            ?>
            
            <body>
              <form action="#" method="post">
                <input type="submit" name="QRCode" value="Recreate QR Code">
              </form>
              <br>
              <img src="<?= $huy->link; ?>" alt="">
              <br>
              <br><a href="orders_pending.php">Xem tình trạng đơn hàng</a>
              
            </body>
            </html>
            
           
