<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$error = '';
// Mức phạt mặc định minh họa: cần hỏi nhóm/giáo viên để xác nhận trước khi dùng chính thức.
$finePerDay = 1000;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loanId = filter_input(INPUT_POST, 'ma_phieu_muon', FILTER_VALIDATE_INT);
    $bookId = filter_input(INPUT_POST, 'ma_sach', FILTER_VALIDATE_INT);
    $returnDate = $_POST['ngay_tra'] ?? date('Y-m-d');
    if (!$loanId || !$bookId) {
        $error = 'Vui lòng nhập mã phiếu mượn và mã sách.';
    } else {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT p.han_tra, c.trang_thai FROM phieu_muon p JOIN chi_tiet_muon c ON c.ma_phieu_muon=p.ma_phieu_muon WHERE p.ma_phieu_muon=? AND c.ma_sach=?");
            $stmt->execute([$loanId, $bookId]);
            $item = $stmt->fetch();
            if (!$item) {
                $error = 'Không tìm thấy sách trong phiếu mượn này.';
            } elseif ($item['trang_thai'] === 'da_tra') {
                $error = 'Sách này đã được trả trước đó.';
            } else {
                $lateDays = max(0, (int)floor((strtotime($returnDate) - strtotime($item['han_tra'])) / 86400));
                $fine = $lateDays * $finePerDay;
                $update = $pdo->prepare("UPDATE chi_tiet_muon SET ngay_tra=?, tien_phat=?, trang_thai='da_tra' WHERE ma_phieu_muon=? AND ma_sach=? AND trang_thai='dang_muon'");
                $update->execute([$returnDate, $fine, $loanId, $bookId]);
                flash("Đã ghi nhận trả sách. Số ngày trễ: {$lateDays}; tiền phạt: " . number_format($fine) . ' VND.');
                redirect('danh_sach_muon.php');
            }
        } catch (Throwable $e) { $error = 'Có lỗi khi cập nhật: ' . $e->getMessage(); }
    }
}
$pageTitle = 'Trả sách';
require __DIR__ . '/../includes/header.php';
?>
<section class="card">
<h2>Ghi nhận trả sách</h2>
<div class="alert error">Lưu ý: mức 1.000 VND/ngày chỉ là giá trị minh họa trong bản mẫu. Hãy xác nhận mức phạt với nhóm trước khi sử dụng chính thức.</div>
<?php if ($error): ?><div class="alert error"><?= h($error) ?></div><?php endif; ?>
<form method="post">
<div class="grid">
<div class="field"><label>Mã phiếu mượn</label><input type="number" name="ma_phieu_muon" min="1" required></div>
<div class="field"><label>Mã sách</label><input type="number" name="ma_sach" min="1" required></div>
<div class="field"><label>Ngày trả</label><input type="date" name="ngay_tra" value="<?= h(date('Y-m-d')) ?>" required></div>
</div>
<button type="submit">Xác nhận trả sách</button>
</form>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
