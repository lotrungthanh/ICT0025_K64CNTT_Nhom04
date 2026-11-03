<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>04_kieu_du_lieu.php</title>
</head>
<body>
    <?php

    $so_nguyen = 42;        // int
    $so_thuc = 3.1415;      // float
     $rong = null;  
    $dung_sai = true; 
    echo "<h3>1. Kiểm tra 5 kiểu dữ liệu cơ bản:</h3>";
    echo "Số nguyên: "; var_dump($so_nguyen); echo "<br>";
    echo "Số thực: "; var_dump($so_thuc); echo "<br>";
    echo "Boolean: "; var_dump($dung_sai); echo "<br>";
    echo "Null: "; var_dump($rong); echo "<br>";
     // ép 12 Ép kiểu chuỗi số "12" sang số nguyên
    $str = "12";
    $int = (int)$str;
    echo "<h3>2. Ép kiểu chuỗi số sang số nguyên:</h3>";
    echo "Chuỗi số: "; var_dump($str); echo "<br>";
    echo "Số nguyên: "; var_dump($int); echo "<br>";
    ?>
</body>
</html>