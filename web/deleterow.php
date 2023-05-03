<?php
    // Truy vấn database để lấy danh sách
    // 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    // C:\xampp\htdocs\web02\
    $con = mysqli_connect("localhost","admin","admin","form2");

    // 2. Chuẩn bị QUERY
    // GET
    // http://localhost:1000/web02/vidu_delete_from_list.php?httt_ma=7
    $httt_id = $_GET['httt_id'];
    
    // HERE DOC
    $sql = <<<EOT DELETE FROM `form` WHERE httt_id=$httt_id EOT;

    // 3. Yêu cầu PHP thực thi QUERY
    mysqli_query($con, $sql);

    // Redirect (điều hướng) về trang bạn mong muốn
    header('location:test3.php');
?>