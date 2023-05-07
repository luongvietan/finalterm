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

// Truy vấn dữ liệu từ bảng "All_Category"
$sql = "SELECT * FROM All_Category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Items List</h2>";
    echo "<form action='add_to_cart.php' method='POST'>";
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
} else {
    echo "No items found.";
}
$conn->close();
?>
