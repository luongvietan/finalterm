<!DOCTYPE html>
<html>
<head>
    <title>Order Page</title>
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

    // Truy vấn dữ liệu từ bảng "cart"
    $sql = "SELECT item_id, item_name, price, quantity FROM cart";
    $result = $conn->query($sql);

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
        }
        echo "</table>";
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
            window.location.href = "payment_momo.php";
        }
    </script>
</body>
</html>
