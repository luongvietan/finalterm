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

session_start();

// Kiểm tra nếu giỏ hàng đã được thanh toán
if (isset($_SESSION['order_id']) && isset($_SESSION['is_paid']) && $_SESSION['is_paid']) {
    // Tạo order_id mới
    $orderID = "Order" . rand(100, 999);
    
    // Cập nhật session với order_id mới
    $_SESSION['order_id'] = $orderID;
    $_SESSION['is_paid'] = false;
} elseif (!isset($_SESSION['order_id'])) {
    // Tạo order_id mới khi session chưa tồn tại
    $orderID = "Order" . rand(100, 999);
    
    // Lưu order_id vào session
    $_SESSION['order_id'] = $orderID;
    $_SESSION['is_paid'] = false;
} else {
    // Lấy order_id từ session
    $orderID = $_SESSION['order_id'];
}

// Truy vấn dữ liệu từ bảng "All_Category"
$sql = "SELECT * FROM All_Category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Items List</h2>";
    echo "<form action='add_to_cart.php' method='POST'>";
    echo "<input type='hidden' name='order_id' value='" . $orderID . "'>"; // Add this line to include the order_id
    echo "<table>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Quantity to Buy</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["All_Category_ID"] . "</td>";
        echo "<td>" . $row["All_Category_Name"] . "</td>";
        echo "<td>" . $row["All_Category_Description"] . "</td>";
        echo "<td>" . $row["All_Category_Price"] . "</td>";
        echo "<td>" . $row["All_Category_Quantity"] . "</td>";
        echo "<td><input type='number' name='quantity[" . $row["All_Category_ID"] . "]' min='0'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='submit' value='Add to Cart'>";
    echo "</form>";

    // Hiển thị tài khoản người dùng và nút đăng xuất
    echo "<div style='position: absolute; top: 10px; right: 10px;'>";
    echo "Tài khoản : " . $_SESSION['username'] . " ";
    echo "<br><a href='logout.php'>Đăng xuất</a>";
    echo "</div>";
}