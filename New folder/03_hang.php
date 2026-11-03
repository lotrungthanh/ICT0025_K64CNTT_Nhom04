<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 03: Hằng số trong PHP</title>
</head>
<body>
    <?php
    define("DVT", "VNĐ");
    const Tinhphi = 0.05; 

    $ten_dich_vu = "Gói đăng ký thành viên";
    $gia_dich_vu = 50000;

    
    $tien_phi = $gia_dich_vu * Tinhphi;
    $tong_thanh_toan = $gia_dich_vu + $tien_phi;

    echo "THÔNG TIN HÓA ĐƠN DỊCH VỤ<br>";
    echo "Tên dịch vụ: " . $ten_dich_vu . "<br>";
    echo "Giá dịch vụ: " . $gia_dich_vu . " " . DVT . "<br>";
    echo "Phí dịch vụ: " . $tien_phi . " " . DVT . "<br>";
    echo "Tổng thanh toán: " . $tong_thanh_toan . " " . DVT . "<br>";
    ?>
</body>
</html>