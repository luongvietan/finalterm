<!DOCTYPE html>
<html>
<head>
    <title>Approve Orders</title>
    <script>
        function selectAll() {
            var checkboxes = document.getElementsByName('order_ids[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        }
    </script>
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

// Truy vấn dữ liệu từ bảng "orders" chỉ lấy các hàng có order_status là "pending"
$sql = "SELECT * FROM orders WHERE order_status = 'approved'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Danh sách các đơn hàng đã xuất kho</h2>";
    echo "<form action='update_order_status.php' method='POST'>";
    echo "<table border=1>
            <tr>
                <th>Order ID</th>
                <th>Item ID</th>
                <th>Tên Item</th>
                <th>Giá</th>
                <th>Phương Thức Thanh Toán</th>
                <th>Tình Trạng Đơn Hàng</th>
                <th>Số Lượng</th>
                <th>Mã Đơn Hàng</th>
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
        echo "<td>" . $row["code"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No orders found.";
}

$conn->close();
?>
</body>
</html>
