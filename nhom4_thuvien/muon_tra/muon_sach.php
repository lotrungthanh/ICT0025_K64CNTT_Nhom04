<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reader = filter_input(INPUT_POST, 'ma_doc_gia', FILTER_VALIDATE_INT);
    $user = filter_input(INPUT_POST, 'ma_nguoi_dung', FILTER_VALIDATE_INT);
    $book = filter_input(INPUT_POST, 'ma_sach', FILTER_VALIDATE_INT);
    $borrowDate = $_POST['ngay_muon'] ?? date('Y-m-d');
    $dueDate = $_POST['han_tra'] ?? '';
    if (!$reader || !$user || !$book || !$dueDate || $dueDate < $borrowDate) {
        $error = 'Vui lòng nhập đủ mã hợp lệ và ngày hẹn trả không sớm hơn ngày mượn.';
    } else {
        try {
            $pdo = db();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO phieu_muon (ma_doc_gia, ma_nguoi_dung, ngay_muon, han_tra) VALUES (?, ?, ?, ?)');
            $stmt->execute([$reader, $user, $borrowDate, $dueDate]);
            $loanId = (int)$pdo->lastInsertId();
            $detail = $pdo->prepare("INSERT INTO chi_tiet_muon (ma_phieu_muon, ma_sach, ngay_tra, tien_phat, trang_thai) VALUES (?, ?, NULL, 0, 'dang_muon')");
            $detail->execute([$loanId, $book]);
            $pdo->commit();
            flash("Đã tạo phiếu mượn số #{$loanId}.");
            redirect('danh_sach_muon.php');
        } catch (Throwable $e) {
            if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
            $error = 'Không lưu được. Hãy kiểm tra mã độc giả, mã người dùng, mã sách có tồn tại và quan hệ khóa ngoại. Chi tiết: ' . $e->getMessage();
        }
    }
}
$pageTitle = 'Mượn sách';
require __DIR__ . '/../includes/header.php';
?>
<section class="card">
<h2>Tạo phiếu mượn sách</h2>
<p class="muted">Nhập mã theo dữ liệu có sẵn trong các bảng doc_gia, nguoi_dung và sach.</p>
<?php if ($error): ?><div class="alert error"><?= h($error) ?></div><?php endif; ?>
<form method="post">
<div class="grid">
<div class="field"><label>Mã độc giả</label><input type="number" name="ma_doc_gia" min="1" required></div>
<div class="field"><label>Mã người dùng (người lập phiếu)</label><input type="number" name="ma_nguoi_dung" min="1" required></div>
<div class="field"><label>Mã sách</label><input type="number" name="ma_sach" min="1" required></div>
<div class="field"><label>Ngày mượn</label><input type="date" name="ngay_muon" value="<?= h(date('Y-m-d')) ?>" required></div>
<div class="field"><label>Hạn trả</label><input type="date" name="han_tra" value="<?= h(date('Y-m-d', strtotime('+14 days'))) ?>" required></div>
</div>
<button type="submit">Lưu phiếu mượn</button>
</form>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
