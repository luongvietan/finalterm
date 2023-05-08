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

// Khởi động session
session_start();

// Lấy danh sách các order_id được chọn
if (isset($_POST['order_ids'])) {
    $orderIDs = $_POST['order_ids'];

    // Tạo giá trị item_des duy nhất nếu chưa tồn tại
    if (!isset($_SESSION['item_des'])) {
        $_SESSION['item_des'] = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
    }

    // Lấy giá trị item_des từ session
    $itemDes = $_SESSION['item_des'];

    // Chuyển trạng thái từ "pending" thành "approved" và cập nhật item_des
    $updateQuery = "UPDATE orders SET order_status = 'approved', item_des = '$itemDes' WHERE order_id IN ('" . implode("','", $orderIDs) . "')";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Cập nhật trạng thái thành công";
    } else {
        echo "Cập nhật trạng thái thất bại: " . $conn->error;
    }
} else {
    echo "Không có đơn hàng được chọn";
}
// Sau khi cập nhật trạng thái thành công, hiển thị button về trang admin.php
echo '<br><a href="admin.php"><button>Quay lại trang admin</button></a>';

$conn->close();
?>
