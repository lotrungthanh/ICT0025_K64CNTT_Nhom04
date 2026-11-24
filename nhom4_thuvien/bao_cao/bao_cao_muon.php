<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
$error = '';
$summary = ['total'=>0, 'borrowing'=>0, 'returned'=>0, 'fine'=>0, 'overdue'=>0];
$rows = [];
try {
    $pdo = db();
    $summary['total'] = (int)$pdo->query("SELECT COUNT(*) FROM chi_tiet_muon")->fetchColumn();
    $summary['borrowing'] = (int)$pdo->query("SELECT COUNT(*) FROM chi_tiet_muon WHERE trang_thai='dang_muon'")->fetchColumn();
    $summary['returned'] = (int)$pdo->query("SELECT COUNT(*) FROM chi_tiet_muon WHERE trang_thai='da_tra'")->fetchColumn();
    $summary['fine'] = (int)$pdo->query("SELECT COALESCE(SUM(tien_phat),0) FROM chi_tiet_muon")->fetchColumn();
    $summary['overdue'] = (int)$pdo->query("SELECT COUNT(*) FROM phieu_muon p JOIN chi_tiet_muon c ON c.ma_phieu_muon=p.ma_phieu_muon WHERE c.trang_thai='dang_muon' AND p.han_tra<CURDATE()")->fetchColumn();
    $rows = $pdo->query("SELECT p.ma_phieu_muon,p.ma_doc_gia,p.ngay_muon,p.han_tra,c.ma_sach,c.ngay_tra,c.tien_phat,c.trang_thai
        FROM phieu_muon p JOIN chi_tiet_muon c ON c.ma_phieu_muon=p.ma_phieu_muon
        ORDER BY p.ngay_muon DESC,p.ma_phieu_muon DESC")->fetchAll();
} catch (Throwable $e) { $error = $e->getMessage(); }
$pageTitle = 'Báo cáo mượn trả';
require __DIR__ . '/../includes/header.php';
?>
<section class="card">
<h2>Báo cáo mượn - trả sách</h2>
<?php if ($error): ?><div class="alert error"><?= h($error) ?></div><?php endif; ?>
<div class="grid">
<div class="card"><strong>Tổng lượt sách</strong><h2><?= $summary['total'] ?></h2></div>
<div class="card"><strong>Đang mượn</strong><h2><?= $summary['borrowing'] ?></h2></div>
<div class="card"><strong>Đã trả</strong><h2><?= $summary['returned'] ?></h2></div>
<div class="card"><strong>Đang quá hạn</strong><h2><?= $summary['overdue'] ?></h2></div>
<div class="card"><strong>Tổng tiền phạt</strong><h2><?= number_format($summary['fine']) ?> VND</h2></div>
</div>
</section>
<section class="card">
<h3>Chi tiết báo cáo</h3>
<div class="table-wrap"><table><thead><tr><th>Phiếu</th><th>Độc giả</th><th>Sách</th><th>Ngày mượn</th><th>Hạn trả</th><th>Ngày trả</th><th>Phạt</th><th>Trạng thái</th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr>
<td><?= h($r['ma_phieu_muon']) ?></td><td><?= h($r['ma_doc_gia']) ?></td><td><?= h($r['ma_sach']) ?></td><td><?= h($r['ngay_muon']) ?></td><td><?= h($r['han_tra']) ?></td><td><?= h($r['ngay_tra'] ?? '-') ?></td><td><?= number_format((int)$r['tien_phat']) ?></td><td><?= h($r['trang_thai']) ?></td>
</tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="8">Chưa có dữ liệu.</td></tr><?php endif; ?>
</tbody></table></div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
