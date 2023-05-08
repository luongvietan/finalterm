<?php
session_start();
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "form2";

$conn = new mysqli($servername, $username, $password, $database);
// Kiểm tra trạng thái của tất cả các đơn hàng
$orderStatusQuery = "SELECT order_status FROM orders";
$orderStatusResult = $conn->query($orderStatusQuery);

$allApproved = true;

if ($orderStatusResult->num_rows > 0) {
    while ($orderStatusRow = $orderStatusResult->fetch_assoc()) {
        if ($orderStatusRow["order_status"] !== "approved") {
            $allApproved = false;
            break;
        }
    }
}

if (!$allApproved) {
    echo "Đang chờ phê duyệt";
    
} else {
    // Chuyển hướng đến trang order_success.php nếu tất cả các hàng đã được phê duyệt
    header("Location: order_success.php");
    exit();
}
// Kiểm tra xem dữ liệu đã được thêm vào hay chưa
if (!isset($_SESSION['data_added'])) {
    // Kết nối tới cơ sở dữ liệu
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
    $sql = "SELECT item_id, item_name, price, quantity, order_id FROM cart";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mảng để lưu trữ thông tin các hàng
        $orderItems = array();
        
        while ($row = $result->fetch_assoc()) {
            $itemID = $row["item_id"];
            $itemName = $row["item_name"];
            $itemPrice = $row["price"];
            $quantity = $row["quantity"];
            $orderID = $row["order_id"];

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
                // Nếu trạng thái là "pending", tạo order_id mới và thêm mới vào b
                $newOrderID = generateOrderID();
                $paymentMethod = "cash";

                $insertQuery = "INSERT INTO orders (order_id, item_id, item_name, item_price, payment_method, order_status, quantity)
                                VALUES ('$newOrderID', '$itemID', '$itemName', '$itemPrice', '$paymentMethod', '$orderStatus', $quantity)";
                $conn->query($insertQuery);

                // Đánh dấu rằng dữ liệu đã được thêm vào cơ sở dữ liệu
                $_SESSION['data_added'] = true;
            }
        }

       
    }
}
?>