<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link CSS file to HTML -->
    <link rel="stylesheet" href="style.css" />
</head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
</style>
<header>
        <!-- Import logo file  -->
        <img src="logo.png" alt="Logo">
        <!-- Title for the webpage -->
        <h1>Final Project</h1>
    </header>
    <!-- Navigation Menu  -->
    <nav>
        <!-- Navigation items -->
        <a href="#">Home</a>
        <a href="https://stdportal.tdtu.edu.vn/Home">About</a>
        <a href="https://www.facebook.com/l.v.a.2311/">Contact</a>
    </nav>
    <br>
</header>
<?php
 
    // Connect to database
    $con = mysqli_connect("localhost","admin","admin","form2");
     
    // mysqli_connect("servername","username","password","database_name")
  
    // Get all the categories from category table
    $sql = "SELECT * FROM `category`";
    
    $all_categories = mysqli_query($con,$sql);

    if(isset($_POST['submit']))
    {

        $id = mysqli_real_escape_string($con,$_POST['Category']);
        
        $conn = mysqli_connect("localhost", "admin", "admin", "form2");
        $sql="select category.Category_Name from category where Category_ID = $id";
        $result=mysqli_query($conn,$sql);
        $data=mysqli_fetch_assoc($result);
        foreach($data as $i){
            $name = $i;
        }

        $sql2="select category.Category_Description from category where Category_ID = $id";
        $result2=mysqli_query($conn,$sql2);
        $data2=mysqli_fetch_assoc($result2);
        foreach($data2 as $i){
            $des = $i;
        }

        $sql3="select category.Category_Price from category where Category_ID = $id";
        $result3=mysqli_query($conn,$sql3);
        $data3=mysqli_fetch_assoc($result3);
        
        // Store the Category ID in a "price" variable
        foreach($data3 as $o){
            $price = $o;
        }

        $sql4="select all_category.All_Category_Quantity from all_category where All_Category_ID = $id";
        $result4=mysqli_query($conn,$sql4);
        $data4=mysqli_fetch_assoc($result4);
        
        // Store the Category ID in a "price" variable
        foreach($data4 as $u){
            $allquan = $u;
        }

        // Store the Product name in a "quantity" variable
        $quantity = mysqli_real_escape_string($con,$_POST['Product_quantity']);

        //$name = count($id);

        // Creating an insert query using SQL syntax and
        // storing it in a variable.
        $sql_insert =
        "INSERT INTO `form`(`id`, `name`, `des`, `price`, `quantity`)
            VALUES ('$id', '$name', '$des', '$price','$quantity')";
          
          // The following code attempts to execute the SQL query
          // if the query executes with no errors
          // a javascript alert message is displayed
          // which says the data is inserted successfully
          if(mysqli_query($con,$sql_insert))
        {
            echo '<script>alert("Product added successfully")</script>';
        }

        // Update the All_Category_Quantity column with the sum of the All_Category_Quantity and Category_Quantity
        $update_quantity = "UPDATE `all_category`
                            SET `All_Category_Quantity` = (`All_Category_Quantity` + $quantity)
                            WHERE `All_Category_ID` = $id";
        if(mysqli_query($con,$update_quantity))
        {
            echo '<script>alert("Categories updated successfully")</script>';
        }
    }
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "form2";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM form";
    $result = $conn->query($sql);
    mysqli_close($con);
?>
<h4 style = "color: White">Đơn Hàng Hiện Tại : </h4>
<table style = "color: White" id="form-info">
        <thead style = "color: Red">
            <tr>
                <th> ID Hàng </th>
                <th> Tên Hàng </th>
                <th> Mô Tả Mặt Hàng  </th>
                <th> Giá Mặt Hàng (.000 VND) </th>
                <th> Số Lượng Mặt Hàng </th>
                <th> Tổng Giá (.000 VND) </th>
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

                // Kiểm tra nếu người dùng đã nhấp vào nút xóa
                if (isset($_GET['delete'])) {
                    $id = $_GET['delete'];

                    // Thực hiện truy vấn SQL để xóa hàng
                    $sql = "DELETE FROM form WHERE id=$id";
                    mysqli_query($conn, $sql);

                    // Chuyển hướng người dùng đến trang chính
                    header('location: test3.php');
                }

            ?>
            <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['des']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['total']; ?></td>
                    <td><button class="btn btn-danger px-5 mr-1"><a href="test3.php?delete=<?php echo $row['id']; ?>">Xóa</a></button></td>
                </tr>
            <?php endwhile; ?>     
        </tbody>
</table>
<br>
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

    // Kiểm tra nếu người dùng đã nhấp vào nút xóa tất cả thông tin
    if (isset($_GET['delete_all'])) {

        // Thực hiện truy vấn SQL để xóa tất cả thông tin trong bảng
        $sql = "TRUNCATE TABLE form";
        mysqli_query($conn, $sql);

        // Chuyển hướng người dùng đến trang chính
        header('location: test3.php');
    }

?>

<!-- HTML để tạo một nút xóa tất cả thông tin -->
<button class="btn btn-danger px-5 mr-1" ><a href="test3.php?delete_all=1">Xóa tất cả thông tin</a></button>
<button class="btn btn-success px-5 mr-1" onclick="window.location.href='export.php'">Xuất file PDF</button>
<button class="btn btn-success px-5 mr-1"><a href="show.php">Tình Trạng Kho</a></button>

<body>
    <br>
    <h6 style = "color: White">------------------------------------------------------------------------</h6>
    <h4 style = "color: White">Điền thông tin : </h4>
    <form method="POST" style = "color: White">
        <label>Select a Products : </label>
        <select name="Category">
                <?php
                    // use a while loop to fetch data
                    // from the $all_categories variable
                    // and individually display as an option
                    foreach($all_categories as $i){
                ?>
                    <option value="<?php echo $i["Category_ID"];
                        // The value we usually set is the primary key
                    ?>" >
                        <?php echo $i["Category_Name"];
                            // To show the category name to the user
                        ?>
                    </option>

                <?php
                    }
                    // While loop must be terminated
                ?>
        </select>
        <!-- <br>
        <label>Name of Product:</label>
        <input type="text" name="Product_name" required> -->
        <br>
        <label>Quantities :</label>
        <input type="text" name="Product_quantity" required>
        <br>
        <input type="submit" value="Submit" name="submit">
    </form>
    <br>
</body>
<footer>
        <!-- Script code to show the current date -->
        <p>
            <script> document.write(new Date().toDateString());</script>.
        </p>
        <!-- Copyright notice -->
        <p>Copyright &copy; Lương Viết An - 521H0434</p>
</footer>
</html>
