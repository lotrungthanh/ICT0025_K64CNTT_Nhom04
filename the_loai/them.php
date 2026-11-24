<?php
require_once '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten_the_loai'];
    $mo_ta = $_POST['mo_ta'];
    mysqli_query($conn, "INSERT INTO the_loai (ten_the_loai, mo_ta) VALUES ('$ten', '$mo_ta')");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Thể loại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Thêm Thể loại mới</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên thể loại</label>
                    <input type="text" name="ten_the_loai" class="form-control" placeholder="Ví dụ: Công nghệ thông tin" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="mo_ta" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Lưu thể loại</button>
                <a href="index.php" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>