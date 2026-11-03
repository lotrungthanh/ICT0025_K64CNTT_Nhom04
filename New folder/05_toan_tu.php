<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>05_toan_tu.php</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>05_toan_tu.php</title>
</head>
<body>
    <?php
    $a = 15;
    $b = 4;

    echo "<h3>1. Các phép tính số học cơ bản:</h3>";
    echo "$a Cộng $b = " . ($a + $b) . "<br>";
    echo "$a Trừ $b = " . ($a - $b) . "<br>";
    echo "$a Nhân $b = " . ($a * $b) . "<br>";
    echo "$a Chia $b = " . ($a / $b) . "<br>";
    echo "$a Chia lấy dư $b = " . ($a % $b) . "<br>";

    echo "<h3>2. Toán tử gán kết hợp (+=):</h3>";
    $x = 5;
    $x += 5; 
    echo "Sau khi x += 5, x = " . $x . "<br>";

    echo "<h3>3. So sánh 5 với 5:</h3>";
    echo "So sánh bằng  (5 == 5): ";
    var_dump(5 == 5); echo "<br>"; // true

    echo "So sánh bằng tuyệt đối (5 === 5): ";
    var_dump(5 === 5); echo "<br>"; // false

    echo "<h3>4. Biểu thức logic (&& và ||):</h3>";
    $ket_qua_logic = (5 == 5 && 10 > 5) || (3 < 1);
    echo "Kết quả biểu thức logic: ";
    var_dump($ket_qua_logic);
    ?>
</body>
</html>
</body>
</html>