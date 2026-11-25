<?php
require_once 'config.php';

$error = '';
// Gợi ý mã thẻ tự động tiếp theo (VD: TV2026031)
$stmtMax = $pdo->query("SELECT MAX(ma_doc_gia) AS max_id FROM doc_gia");
$nextId = ($stmtMax->fetch()['max_id'] ?? 0) + 1;
$suggestedCode = 'TV2026' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ma_the = trim($_POST['ma_the'] ?? '');
    $ho_ten = trim($_POST['ho_ten'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $dia_chi = trim($_POST['dia_chi'] ?? '');
    $ngay_het_han = $_POST['ngay_het_han'] ?? '';
    $trang_thai = $_POST['trang_thai'] ?? 'hoat_dong';

    if (empty($ma_the) || empty($ho_ten) || empty($ngay_het_han)) {
        $error = 'Vui lòng nhập đầy đủ Mã thẻ, Họ tên và Ngày hết hạn.';
    } else {
        try {
            $sql = "INSERT INTO doc_gia (ma_the, ho_ten, so_dien_thoai, dia_chi, ngay_het_han, trang_thai) 
                    VALUES (:ma_the, :ho_ten, :sdt, :dia_chi, :ngay_het_han, :trang_thai)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'ma_the' => $ma_the,
                'ho_ten' => $ho_ten,
                'sdt' => $so_dien_thoai !== '' ? $so_dien_thoai : null,
                'dia_chi' => $dia_chi !== '' ? $dia_chi : null,
                'ngay_het_han' => $ngay_het_han,
                'trang_thai' => $trang_thai
            ]);
            header("Location: index.php?msg=added");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Mã thẻ '$ma_the' đã tồn tại trong hệ thống!";
            } else {
                $error = "Lỗi hệ thống: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Độc giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Thêm Độc giả mới</h4>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Mã thẻ <span class="text-danger">*</span></label>
                    <input type="text" name="ma_the" class="form-control" required maxlength="20"
                           value="<?= htmlspecialchars($_POST['ma_the'] ?? $suggestedCode) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                    <input type="text" name="ho_ten" class="form-control" required maxlength="100"
                           value="<?= htmlspecialchars($_POST['ho_ten'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control" maxlength="15"
                           value="<?= htmlspecialchars($_POST['so_dien_thoai'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="dia_chi" class="form-control" maxlength="255"
                           value="<?= htmlspecialchars($_POST['dia_chi'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày hết hạn thẻ <span class="text-danger">*</span></label>
                    <input type="date" name="ngay_het_han" class="form-control" required
                           value="<?= htmlspecialchars($_POST['ngay_het_han'] ?? date('Y-m-d', strtotime('+1 year'))) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="trang_thai" class="form-select">
                        <option value="hoat_dong" selected>Hoạt động</option>
                        <option value="bi_khoa">Bị khóa</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu độc giả</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>