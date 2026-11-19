<?php 
$servername = "localhost"; 
$username   = "root"; 
$password   = ""; 
$dbname     = "thu_vien"; 
// Tạo kết nối 
$conn = new mysqli($servername, $username, $password, $dbname); 
// Kiểm tra lỗi kết nối 
if ($conn->connect_error) { 
die("Kết nối thất bại: " . $conn->connect_error); 
} 
echo "Kết nối CSDL thành công!"; 
?>