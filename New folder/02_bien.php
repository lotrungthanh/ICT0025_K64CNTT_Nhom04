<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bien</title>
</head>
<body>
    
  <?php
// Khai báo biến
$ten_san_pham = "mytom";
$so_luong = 2;
$don_gia = 5000;

// In giá trị ban đầu
echo "Tên sản phẩm: " . $ten_san_pham . "<br>";
echo "Số lượng: " . $so_luong . "<br>";
echo "Đơn giá: " . $don_gia . " VNĐ<br>";
echo "<hr>";

// Đổi số lượng và in lại
$so_luong = 5;
echo "Số lượng sau khi cập nhật: " . $so_luong . "<br>";
echo "Tổng tiền tạm tính: " . ($so_luong * $don_gia) . " VNĐ";
?>;
    </body>
</html>
