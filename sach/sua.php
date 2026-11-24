<?php
require_once '../config/db.php';
$id = $_GET['id'];
$the_loai_list = mysqli_query($conn, "SELECT * FROM the_loai");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten_sach'];
    $tac_gia = $_POST['tac_gia'];
    $nxb = $_POST['nha_xuat_ban'];
    $nam_xb = $_POST['nam_xb'];
    $so_luong = $_POST['so_luong'];
    $the_loai_id = $_POST['the_loai_id'] ?: "NULL";

    $sql = "UPDATE sach SET ten_sach='$ten', tac_gia='$tac_gia', nha_xuat_ban='$nxb', 
            nam_xb='$nam_xb', so_luong='$so_luong', the_loai_id=$the_loai_id WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}
$sach = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sach WHERE id=$id"));
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Sửa Sách</title></head>
<body>
    <h2>Sửa thông tin Sách</h2>
    <form method="POST">
        Tên sách: <br><input type="text" name="ten_sach" value="<?= htmlspecialchars($sach['ten_sach']) ?>" required><br><br>
        Thể loại: <br>
        <select name="the_loai_id">
            <option value="">-- Chọn thể loại --</option>
            <?php while ($tl = mysqli_fetch_assoc($the_loai_list)): ?>
                <option value="<?= $tl['id'] ?>" <?= ($tl['id'] == $sach['the_loai_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tl['ten_the_loai']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>
        Tác giả: <br><input type="text" name="tac_gia" value="<?= htmlspecialchars($sach['tac_gia']) ?>" required><br><br>
        Nhà xuất bản: <br><input type="text" name="nha_xuat_ban" value="<?= htmlspecialchars($sach['nha_xuat_ban']) ?>"><br><br>
        Năm xuất bản: <br><input type="number" name="nam_xb" value="<?= $sach['nam_xb'] ?>"><br><br>
        Số lượng: <br><input type="number" name="so_luong" value="<?= $sach['so_luong'] ?>"><br><br>
        <button type="submit">Cập nhật</button>
        <a href="index.php">Quay lại</a>
    </form>
</body>
</html>