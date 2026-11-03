<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>van dung</title>
</head>
<body>
    <?php
    echo "<h3>Đơn hàng thứ 1</h3>";
$ten_hang = "sách";
echo " Tên hàng: " . $ten_hang . "<br>";
$so_luong = 3;
echo " Số lượng: " . $so_luong . "<br>";
$don_gia = 50000;
echo " Đơn giá: " . $don_gia . ". VNĐ<br>";
const TY_LE_PHI = 0.2;

$tien_hang = ($so_luong * $don_gia);
echo " Tiền hàng: " . $tien_hang . ". VNĐ<br>";
$tien_phi = ($tien_hang * TY_LE_PHI);
echo " Tiền phí: " . $tien_phi . " .VNĐ <br>";
$tong_tien = ($tien_hang + $tien_phi);

echo "Tổng tiền thanh toán cho đơn hàng " . $ten_hang . " là: " . $tong_tien . " VNĐ";


echo " <h3 >Đơn hàng thứ 2</h3>";

$ten_hang2 = "bút";

echo " Tên hàng: " . $ten_hang2 . "<br>";
$so_luong2 = 3;
echo " Số lượng: " . $so_luong2 . "<br>";
$don_gia2 = 25000;
echo " Đơn giá: " . $don_gia2 . ". VNĐ<br>";
const TY_LE_PHI2 = 0.05;

$tien_hang2 = ($so_luong2 * $don_gia2);
echo " Tiền hàng: " . $tien_hang2 . ". VNĐ<br>";
$tien_phi2 = ($tien_hang2 * TY_LE_PHI2);
echo " Tiền phí: " . $tien_phi2 . " .VNĐ <br>";
$tong_tien2 = ($tien_hang2 + $tien_phi2);

echo "Tổng tiền thanh toán cho đơn hàng " . $ten_hang2 . " là: " . $tong_tien2 . " VNĐ";
?>
</body>
</html>