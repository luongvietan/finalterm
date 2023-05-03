<?php
// Kết nối đến database
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "form2";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error ) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>
<table id="form-info" border="1">
        <thead style = "color: Red">
            <tr>
                <th> ID Hàng </th>
                <th> Tên Hàng </th>
                <th> Mô Tả Mặt Hàng  </th>
                <th> Giá Mặt Hàng (.000 VND) </th>
                <th> Số Lượng Mặt Hàng </th>
            </tr>
        </thead>
        <tbody>
            <?php

                // Kết nối đến cơ sở dữ liệu
                $servername = "localhost";
                $username = "admin";
                $password = "admin";
                $dbname = "form2";

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Kiểm tra kết nối
                if (!$conn) {
                    die("Kết nối không thành công: " . mysqli_connect_error());
                }
                $sql = "SELECT * FROM All_category";
                $result = $conn->query($sql);
            ?>
            <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) : ?>
                <tr>
                    <td><?php echo $row['All_Category_ID']; ?></td>
                    <td><?php echo $row['All_Category_Name']; ?></td>
                    <td><?php echo $row['All_Category_Description']; ?></td>
                    <td><?php echo $row['All_Category_Price']; ?></td>
                    <td><?php echo $row['All_Category_Quantity']; ?></td>
                </tr>
            <?php endwhile; ?>     
        </tbody>
</table>
<p><a href="test3.php">Back to form</a></p>