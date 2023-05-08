<?php

// Hàm để tạo một chuỗi ngẫu nhiên
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if (isset($_POST['QRCode'])) {
    $totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0;
    $randomString = generateRandomString(6);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://bio.ziller.vn/api/qr/add",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 2,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer 3f3c3700b254731a849c8dd020eab3c6",
            "Content-Type: application/json",
        ),
        CURLOPT_POSTFIELDS => json_encode(array (
            'type' => 'text',
            'data' => '2|99|0384398634|LUONG VIET AN||0|0|'.$totalPrice.'|'.$randomString.'|transfer_myqr',
            'background' => 'rgb(255,255,255)',
            'foreground' => 'rgb(0,0,0)',
            'logo' => 'https://site.com/logo.png',
        )),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $huy = json_decode($response);
}
?>

<body>
  <form action="#" method="post">
    <input type="submit" name="QRCode" value="Tao QR">
  </form>
  <img src="<?= $huy->link; ?>" alt="">
</body>
</html>
