<!DOCTYPE html>
<html>
<head>
    <title>Approve Orders</title>
</head>
<body>
<?php
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

// Truy vấn dữ liệu từ bảng "orders"
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Danh sách các đơn hàng</h2>";
    echo "<form action='update_order_status.php' method='POST'>";
    echo "<table border=1>
            <tr>
                <th>Order ID</th>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Payment Method</th>
                <th>Order Status</th>
                <th>Quantity</th>
                <th>Approve</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["order_id"] . "</td>";
        echo "<td>" . $row["item_id"] . "</td>";
        echo "<td>" . $row["item_name"] . "</td>";
        echo "<td>" . $row["item_price"] . "</td>";
        echo "<td>" . $row["payment_method"] . "</td>";
        echo "<td>" . $row["order_status"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td><input type='checkbox' name='order_ids[]' value='" . $row["order_id"] . "'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<button type='submit'>Phê duyệt</button>";
    echo "</form>";
} else {
    echo "No orders found.";
}

$conn->close();
?>
</body>
</html>
