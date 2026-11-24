<?php
require_once '../config/db.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten_the_loai'];
    $mo_ta = $_POST['mo_ta'];
    mysqli_query($conn, "UPDATE the_loai SET ten_the_loai='$ten', mo_ta='$mo_ta' WHERE id=$id");
    header("Location: index.php");
    exit;
}
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM the_loai WHERE id=$id"));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Thể loại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Cập nhật Thể loại</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên thể loại</label>
                    <input type="text" name="ten_the_loai" class="form-control" value="<?= htmlspecialchars($row['ten_the_loai']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="mo_ta" class="form-control" rows="3"><?= htmlspecialchars($row['mo_ta'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-warning">Cập nhật</button>
                <a href="index.php" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>