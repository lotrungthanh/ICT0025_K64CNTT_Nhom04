<?php
$pageTitle = 'Trang chủ';
require __DIR__ . '/includes/header.php';
?>
<section class="card">
<h2>Phân hệ của Nhóm 4</h2>
<p>Phân hệ này phụ trách: mượn sách, trả sách, tiền phạt và báo cáo.</p>
<div class="grid">
  <a class="btn" href="muon_tra/muon_sach.php">Tạo phiếu mượn</a>
  <a class="btn" href="muon_tra/danh_sach_muon.php">Xem danh sách mượn</a>
  <a class="btn" href="muon_tra/tra_sach.php">Trả sách</a>
  <a class="btn" href="bao_cao/bao_cao_muon.php">Xem báo cáo</a>
</div>
</section>
<section class="card">
<h3>Lưu ý</h3>
<p class="muted">Nhập đúng mã độc giả, mã người dùng và mã sách đã có trong cơ sở dữ liệu thu_vien1. Phân hệ không tự tạo tài khoản hay dữ liệu sách.</p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
