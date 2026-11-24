<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
$rows = [];
$error = '';
try {
    $rows = db()->query("SELECT p.ma_phieu_muon, p.ma_doc_gia, p.han_tra, c.ma_sach, c.ngay_tra, c.tien_phat, c.trang_thai
        FROM phieu_muon p JOIN chi_tiet_muon c ON c.ma_phieu_muon=p.ma_phieu_muon
        WHERE c.tien_phat > 0 OR (c.trang_thai='dang_muon' AND p.han_tra < CURDATE())
        ORDER BY p.han_tra")->fetchAll();
} catch (Throwable $e) { $error = $e->getMessage(); }
$pageTitle = 'Kiểm tra tiền phạt';
require __DIR__ . '/../includes/header.php';
?>
<section class="card">
<h2>Danh sách cần kiểm tra tiền phạt</h2>
<p class="muted">Hiển thị các sách đã có tiền phạt hoặc đang mượn quá hạn. Tiền phạt đã lưu trong bảng chi_tiet_muon.</p>
<?php if ($error): ?><div class="alert error"><?= h($error) ?></div><?php endif; ?>
<div class="table-wrap"><table><thead><tr><th>Phiếu</th><th>Độc giả</th><th>Sách</th><th>Hạn trả</th><th>Ngày trả</th><th>Tiền phạt</th><th>Trạng thái</th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr>
<td><?= h($r['ma_phieu_muon']) ?></td><td><?= h($r['ma_doc_gia']) ?></td><td><?= h($r['ma_sach']) ?></td><td><?= h($r['han_tra']) ?></td><td><?= h($r['ngay_tra'] ?? '-') ?></td><td><?= number_format((int)$r['tien_phat']) ?> VND</td><td><?= h($r['trang_thai']) ?></td>
</tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="7">Không có khoản phạt hoặc sách quá hạn.</td></tr><?php endif; ?>
</tbody></table></div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
