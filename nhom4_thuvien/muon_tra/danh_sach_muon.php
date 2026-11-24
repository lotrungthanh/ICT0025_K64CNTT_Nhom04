<?php
// Danh sách phiếu mượn - Nhóm 4
// CSDL: thuvien1 | Bảng: phieu_muon

$host = '127.0.0.1';
$dbname = 'thuvien1';
$username = 'root';
$password = ''; // XAMPP mặc định thường để trống

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $keyword = trim($_GET['q'] ?? '');

    if ($keyword !== '') {
        $sql = "SELECT ma_phieu_muon, ma_doc_gia, ma_nguoi_dung, ngay_muon, han_tra
                FROM phieu_muon
                WHERE CAST(ma_phieu_muon AS CHAR) LIKE :kw
                   OR CAST(ma_doc_gia AS CHAR) LIKE :kw
                   OR CAST(ma_nguoi_dung AS CHAR) LIKE :kw
                   OR ngay_muon LIKE :kw
                   OR han_tra LIKE :kw
                ORDER BY ma_phieu_muon DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['kw' => '%' . $keyword . '%']);
    } else {
        $sql = "SELECT ma_phieu_muon, ma_doc_gia, ma_nguoi_dung, ngay_muon, han_tra
                FROM phieu_muon
                ORDER BY ma_phieu_muon DESC";
        $stmt = $pdo->query($sql);
    }

    $phieuMuon = $stmt->fetchAll();
} catch (PDOException $e) {
    http_response_code(500);
    $error = "Không thể kết nối hoặc đọc dữ liệu CSDL. Kiểm tra XAMPP, tên CSDL và tài khoản MySQL.";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phiếu mượn - Nhóm 4</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 28px 18px;
            background: #f3f6fb;
            color: #243247;
            font-family: Arial, Helvetica, sans-serif;
        }
        .container {
            max-width: 1120px;
            margin: 0 auto;
            background: #fff;
            padding: 26px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(30, 50, 80, .08);
        }
        h1 { margin: 0 0 8px; color: #173b67; font-size: 27px; }
        .sub { margin: 0 0 20px; color: #66758a; }
        nav { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 24px; }
        nav a, .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 7px;
            background: #e8eff8;
            color: #174675;
            text-decoration: none;
            font-size: 14px;
        }
        nav a.active, .btn.primary { background: #1f5f9f; color: #fff; }
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 14px;
        }
        .toolbar h2 { margin: 0; font-size: 19px; }
        form { display: flex; gap: 8px; flex-wrap: wrap; }
        input {
            min-width: 230px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
        }
        button {
            border: 0;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 7px;
            background: #1f5f9f;
            color: white;
            font-size: 14px;
        }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 720px; }
        th, td {
            border: 1px solid #dce3ec;
            padding: 12px 13px;
            text-align: center;
            font-size: 14px;
        }
        th { background: #eaf1f8; color: #173b67; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:hover { background: #eef6ff; }
        .count { margin: 14px 0 0; color: #66758a; font-size: 14px; }
        .error {
            padding: 13px 15px;
            border-radius: 8px;
            color: #9b1c1c;
            background: #fff0f0;
        }
        .empty { padding: 22px; color: #66758a; text-align: center; }
        @media (max-width: 600px) {
            .container { padding: 18px 13px; }
            h1 { font-size: 22px; }
            input { min-width: 100%; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Phân hệ mượn - trả thư viện</h1>
    <p class="sub">Nhóm 4 — Quản lý danh sách phiếu mượn sách</p>

    <nav>
        <a href="../index.php">Trang chủ</a>
        <a href="muon_sach.php">Mượn sách</a>
        <a class="active" href="danh_sach_muon.php">Danh sách mượn</a>
        <a href="tra_sach.php">Trả sách</a>
        <a href="../bao_cao/bao_cao_muon.php">Báo cáo</a>
    </nav>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php else: ?>
        <div class="toolbar">
            <h2>Danh sách phiếu mượn</h2>
            <form method="get" action="">
                <input
                    type="text"
                    name="q"
                    placeholder="Tìm theo mã phiếu, độc giả, người dùng..."
                    value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
                >
                <button type="submit">Tìm kiếm</button>
                <a class="btn" href="danh_sach_muon.php">Làm mới</a>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>ma_phieu_muon</th>
                    <th>ma_doc_gia</th>
                    <th>ma_nguoi_dung</th>
                    <th>ngay_muon</th>
                    <th>han_tra</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($phieuMuon) > 0): ?>
                    <?php foreach ($phieuMuon as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars((string)$row['ma_phieu_muon'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)$row['ma_doc_gia'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)$row['ma_nguoi_dung'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)$row['ngay_muon'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)$row['han_tra'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td class="empty" colspan="5">Không tìm thấy phiếu mượn nào.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <p class="count">Tổng số phiếu mượn hiển thị: <strong><?= count($phieuMuon) ?></strong></p>
    <?php endif; ?>
</div>
</body>
</html>
