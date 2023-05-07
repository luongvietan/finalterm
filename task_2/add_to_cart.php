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

// Xử lý thêm mặt hàng vào giỏ hàng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $itemID => $quantity) {
            // Lấy thông tin mặt hàng từ bảng "All_Category"
            $query = "SELECT * FROM All_Category WHERE All_Category_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $itemID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $itemName = $row['All_Category_Name'];
                $itemPrice = intval($row['All_Category_Price']); // Chuyển đổi sang số nguyên
                $quantity = intval($_POST['quantity'][$itemID]); // Chuyển đổi số lượng thành số nguyên
                $totalPrice = $itemPrice * $quantity;

                // Thêm mặt hàng vào bảng "cart"
                if ($quantity > 0) {
                    $insertQuery = "INSERT INTO cart (item_id, item_name, price, quantity, total) VALUES (?, ?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param("issid", $itemID, $itemName, $itemPrice, $quantity, $totalPrice);
                    $insertStmt->execute();
                } 
            }
        }
    }
}

// Xử lý yêu cầu xóa giỏ hàng và database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_cart'])) {
    // Xóa toàn bộ dữ liệu trong bảng "cart"
    $deleteQuery = "DELETE FROM cart";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->execute();
}

$conn->close();
?>
<br>
<a href="list_items.php"><button>Choose Other Items</button></a>
<br><br>
<a href="order.php"><button>Proceed to Checkout</button></a>
<form method="post" action="">
    <br>
    <input type="submit" name="reset_cart" value="Empty Cart">
</form>
