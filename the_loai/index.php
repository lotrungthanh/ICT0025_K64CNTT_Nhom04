<?php
require_once '../config/db.php';
$result = mysqli_query($conn, "SELECT * FROM the_loai ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Thể loại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Quản lý Thể loại Sách</h4>
            <div>
                <a href="them.php" class="btn btn-light btn-sm fw-bold">+ Thêm thể loại</a>
                <a href="../sach/index.php" class="btn btn-outline-light btn-sm ms-2">Quản lý Sách →</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Tên thể loại</th>
                        <th>Mô tả</th>
                        <th width="160" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><span class="badge bg-secondary">#<?= $row['id'] ?></span></td>
                        <td class="fw-bold text-primary"><?= htmlspecialchars($row['ten_the_loai']) ?></td>
                        <td><?= htmlspecialchars($row['mo_ta'] ?? '') ?></td>
                        <td class="text-center">
                            <a href="sua.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="xoa.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa thể loại này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>