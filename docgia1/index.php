<?php
require_once 'config.php';

// Xử lý tìm kiếm
$keyword = trim($_GET['keyword'] ?? '');
if ($keyword !== '') {
    $sql = "SELECT * FROM doc_gia 
            WHERE ma_the LIKE :kw OR ho_ten LIKE :kw OR so_dien_thoai LIKE :kw 
            ORDER BY ma_doc_gia DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['kw' => "%$keyword%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM doc_gia ORDER BY ma_doc_gia DESC");
}
$docGias = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Độc giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Danh sách Độc giả</h2>
        <a href="them.php" class="btn btn-primary">+ Thêm độc giả</a>
    </div>

    <!-- Thông báo trạng thái -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php
            $msgs = [
                'added' => 'Thêm độc giả thành công!',
                'updated' => 'Cập nhật thông tin thành công!',
                'deleted' => 'Đã xóa độc giả!'
            ];
            echo $msgs[$_GET['msg']] ?? 'Thao tác thành công!';
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['err']) && $_GET['err'] === 'fk_error'): ?>
        <div class="alert alert-danger">
            Không thể xóa độc giả này vì đã có lịch sử mượn sách trong hệ thống! Bạn có thể chuyển trạng thái sang <strong>Bị khóa</strong>.
        </div>
    <?php endif; ?>

    <!-- Form tìm kiếm -->
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-5">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo mã thẻ, họ tên hoặc SĐT..." value="<?= htmlspecialchars($keyword) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
            <?php if ($keyword !== ''): ?>
                <a href="index.php" class="btn btn-outline-secondary">Xóa lọc</a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Bảng dữ liệu -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mã thẻ</th>
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Ngày hết hạn</th>
                        <th>Trạng thái</th>
                        <th width="140">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($docGias) > 0): ?>
                        <?php foreach ($docGias as $dg): ?>
                            <tr>
                                <td><?= $dg['ma_doc_gia'] ?></td>
                                <td><strong><?= htmlspecialchars($dg['ma_the']) ?></strong></td>
                                <td><?= htmlspecialchars($dg['ho_ten']) ?></td>
                                <td><?= htmlspecialchars($dg['so_dien_thoai'] ?? '') ?></td>
                                <td><?= htmlspecialchars($dg['dia_chi'] ?? '') ?></td>
                                <td><?= date('d/m/Y', strtotime($dg['ngay_het_han'])) ?></td>
                                <td>
                                    <?php if ($dg['trang_thai'] === 'hoat_dong'): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Bị khóa</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="sua.php?id=<?= $dg['ma_doc_gia'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="xoa.php?id=<?= $dg['ma_doc_gia'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn có chắc muốn xóa độc giả <?= htmlspecialchars($dg['ho_ten']) ?>?');">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">Không tìm thấy độc giả nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>