<?php
// Kết nối cơ sở dữ liệu
$db = new PDO('mysql:host=localhost;dbname=form2;charset=utf8', 'admin', 'admin');

// Lấy danh sách các mặt hàng từ bảng "items"
$items = $db->query('SELECT * FROM category')->fetchAll(PDO::FETCH_ASSOC);

// Hiển thị các mặt hàng
?>
<table id="form-info" border="1">
        
        <thead style = "color: Red">
            <tr>
                <th colspan="6">THÔNG TIN MẶT HÀNG</th>
            </tr>
            <tr>
                <th> ID Hàng </th>
                <th> Tên Hàng </th>
                <th> Mô Tả Mặt Hàng  </th>
                <th> Giá Mặt Hàng </th>
                <th> Số Lượng Còn Lại </th>
                <th>  </th>
            </tr>
        </thead>
        <tbody>
        <?php
                foreach ($items as $item) {
                  echo '<tr>';
                  echo '<th>' . $item['Category_ID'] . '</th>';
                  echo '<th>' . $item['Category_Name'] . '</th>';
                  echo '<th>' . $item['Category_Description'] . '</th>';
                  echo '<th>' . $item['Category_Price'] . '.000 VND</th>';
                  echo '<th>' . $item['Category_Quantity'] . '</th>';
                  echo '<th><button><a href="order.php?item_id=' . $item['Category_ID'] . '">Order</a></button></th>';
                  echo '</div>';
                }
        ?>
