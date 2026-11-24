<?php
$conn = mysqli_connect("localhost", "root", "", "quan_ly_thu_vien");
if (!$conn) {
    die("Lỗi kết nối: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>