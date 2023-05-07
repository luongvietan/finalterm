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

// Lấy order_id từ session
session_start();
$orderID = $_SESSION['order_id'];

// Truy vấn dữ liệu từ bảng "cart"
$sql = "SELECT item_id, item_name, price, quantity, total FROM cart WHERE order_id = '$orderID'";
$result = $conn->query($sql);

$totalPrice = 0; // Tổng giá trị phải thanh toán

if ($result->num_rows > 0) {
    echo "<h2>ID: " . $orderID . "</h2>";
    echo "<table border=1>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["item_id"] . "</td>";
        echo "<td>" . $row["item_name"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "</tr>";

        $totalPrice += $row["total"]; // Cập nhật tổng giá trị
    }
    echo "</table>";

    echo "<h3>Tổng giá trị phải thanh toán: " . $totalPrice . "</h3>";
} else {
    echo "No items found in the cart.";
}

$conn->close();
?>


<h2>Select Payment Method:</h2>
<button onclick="payByCash()">Tiền mặt</button>
<button onclick="payByBankTransfer()">Chuyển khoản</button>
<button onclick="payByMomo()">Momo</button>

<script>
    function payByCash() {
        window.location.href = "payment_cash.php";
    }

    function payByBankTransfer() {
        window.location.href = "payment_transfer.php";
    }

    function payByMomo() {
        // Lấy order_id từ session
        <?php $orderID = $_SESSION['order_id']; ?>

        // Gửi thông báo đến admin
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

// Lấy order_id từ session
session_start();
$orderID = $_SESSION['order_id'];

// Truy vấn dữ liệu từ bảng "cart"
$sql = "SELECT item_id, item_name, price, quantity, total FROM cart WHERE order_id = '$orderID'";
$result = $conn->query($sql);

$totalPrice = 0; // Tổng giá trị phải thanh toán

if ($result->num_rows > 0) {
    echo "<h2>Order Summary</h2>";
    echo "<table border=1>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["item_id"] . "</td>";
        echo "<td>" . $row["item_name"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "</tr>";

        $totalPrice += $row["total"]; // Cập nhật tổng giá trị
    }
    echo "</table>";

    echo "<h3>Tổng giá trị phải thanh toán: " . $totalPrice . ".000 VND " . "</h3>";
} else {
    echo "No items found in the cart.";
}

$conn->close();


// Cập nhật trạng thái đơn hàng thành "Pending"
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$updateQuery = "UPDATE orders SET status = 'Pending' WHERE order_id = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param("s", $orderID);
$updateStmt->execute();

$conn->close();
?>


<h2>Select Payment Method:</h2>
<button onclick="payByCash()">Tiền mặt</button>
<button onclick="payByBankTransfer()">Chuyển khoản</button>
<button onclick="payByMomo()">Momo</button>

<script>
    function payByCash() {
        window.location.href = "payment_cash.php";
    }

    function payByBankTransfer() {
        window.location.href = "payment_transfer.php";
    }

    function payByMomo() {
        // Lấy order_id từ session
        <?php $orderID = $_SESSION['order_id']; ?>

        // Chuyển hướng người dùng đến trang payment_momo.php
        window.location.href = "payment_momo.php";
    }
</script>
