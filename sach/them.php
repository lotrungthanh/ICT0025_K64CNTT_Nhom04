<?php
require_once '../config/db.php';
$the_loai_list = mysqli_query($conn, "SELECT * FROM the_loai");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten_sach'];
    $tac_gia = $_POST['tac_gia'];
    $nxb = $_POST['nha_xuat_ban'];
    $nam_xb = $_POST['nam_xb'];
    $so_luong = $_POST['so_luong'];
    $the_loai_id = $_POST['the_loai_id'] ?: "NULL";

    $sql = "INSERT INTO sach (ten_sach, tac_gia, nha_xuat_ban, nam_xb, so_luong, the_loai_id) 
            VALUES ('$ten', '$tac_gia', '$nxb', '$nam_xb', '$so_luong', $the_loai_id)";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Thêm Sách</title></head>
<body>
    <h2>Thêm Sách mới</h2>
    <form method="POST">
        Tên sách: <br><input type="text" name="ten_sach" required><br><br>
        Thể loại: <br>
        <select name="the_loai_id">
            <option value="">-- Chọn thể loại --</option>
            <?php while ($tl = mysqli_fetch_assoc($the_loai_list)): ?>
                <option value="<?= $tl['id'] ?>"><?= htmlspecialchars($tl['ten_the_loai']) ?></option>
            <?php endwhile; ?>
        </select><br><br>
        Tác giả: <br><input type="text" name="tac_gia" required><br><br>
        Nhà xuất bản: <br><input type="text" name="nha_xuat_ban"><br><br>
        Năm xuất bản: <br><input type="number" name="nam_xb"><br><br>
        Số lượng: <br><input type="number" name="so_luong" value="1"><br><br>
        <button type="submit">Lưu sách</button>
        <a href="index.php">Quay lại</a>
    </form>
</body>
</html>