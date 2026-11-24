<?php
require_once '../config/db.php';
$keyword = $_GET['keyword'] ?? '';
$sql = "SELECT sach.*, the_loai.ten_the_loai 
        FROM sach 
        LEFT JOIN the_loai ON sach.the_loai_id = the_loai.id 
        WHERE sach.ten_sach LIKE '%$keyword%' OR sach.tac_gia LIKE '%$keyword%'
        ORDER BY sach.id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Quản lý Sách</title></head>
<body>
    <h2>Danh sách Sách</h2>
    <a href="them.php">+ Thêm sách mới</a> | <a href="../the_loai/index.php">Sang trang Quản lý Thể loại</a>
    <br><br>
    <form method="GET">
        <input type="text" name="keyword" placeholder="Tìm tên sách, tác giả..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Tìm kiếm</button>
    </form>
    <br>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Tên sách</th>
            <th>Thể loại</th>
            <th>Tác giả</th>
            <th>NXB</th>
            <th>Năm XB</th>
            <th>Số lượng</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['ten_sach']) ?></td>
            <td><?= htmlspecialchars($row['ten_the_loai'] ?? 'Chưa phân loại') ?></td>
            <td><?= htmlspecialchars($row['tac_gia']) ?></td>
            <td><?= htmlspecialchars($row['nha_xuat_ban']) ?></td>
            <td><?= $row['nam_xb'] ?></td>
            <td><?= $row['so_luong'] ?></td>
            <td>
                <a href="sua.php?id=<?= $row['id'] ?>">Sửa</a> | 
                <a href="xoa.php?id=<?= $row['id'] ?>" onclick="return confirm('Xóa sách này?')">Xóa</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>