<?php
$host = 'localhost';
$dbname = 'thuvien1';
$username = 'root'; // Thay đổi nếu cấu hình máy bạn khác
$password = '';     // Thay đổi nếu có mật khẩu

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Bật chế độ báo lỗi ngoại lệ
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Trả về dữ liệu dạng mảng kết hợp
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}
?>