<?php
session_start();

// Kiểm tra xem đã đăng nhập chưa
if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
    // Đã đăng nhập thành công
    echo "<h2>Nhập kho</h2>";
    echo '<button onclick="createReceipt()">Tạo Phiếu nhập kho</button><br><br>';
    echo "<h2>Phê duyệt Đơn hàng</h2>";
    echo '<button onclick="approveOrders()">Phê duyệt Đơn hàng</button>';
    echo "<h2>Xuất kho</h2>";
    echo '<button onclick="exOrders()">Phê duyệt Đơn hàng</button>';
    // Hiển thị tài khoản người dùng và nút đăng xuất
    echo "<div style='position: absolute; top: 10px; right: 10px;'>";
    echo "Tài khoản : " . $_SESSION['username'] . " ";
    echo "<br><a href='logout.php'>Đăng xuất</a>";
    echo "</div>";
} else {
    // Chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header('Location: login.php');
    exit();
}
?>

<script>
    function createReceipt() {
        window.location.href = "test3.php";
    }

    function approveOrders() {
        window.location.href = "approve_orders.php";
    }

    function exOrders() {
        window.location.href = "/task_3/main3.php";
    }
</script>

