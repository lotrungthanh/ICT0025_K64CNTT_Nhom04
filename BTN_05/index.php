<?php
require_once __DIR__ . '/db.php';

$successMessage = '';
$errorMessage = '';
$postedData = $_POST ?? [];
$ten_sach_value = $postedData['ten_sach'] ?? '';
$tac_gia_value = $postedData['tac_gia'] ?? '';
$nam_xuat_ban_value = $postedData['nam_xuat_ban'] ?? '';
$books = [];

if (isset($_GET['success']) && $_GET['success'] === '1') {
    $successMessage = 'Thêm sách thành công.';
}

try {
    $pdo = getDatabaseConnection();
    $booksStatement = $pdo->query('SELECT ma_sach, ten_sach, tac_gia, nam_xuat_ban FROM sach ORDER BY ma_sach DESC');
    $books = $booksStatement->fetchAll() ?: [];
} catch (PDOException $e) {
    $errorMessage = 'Không thể kết nối database thu_vien.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errorMessage)) {
    $ten_sach = trim((string) ($postedData['ten_sach'] ?? ''));
    $tac_gia = trim((string) ($postedData['tac_gia'] ?? ''));
    $nam_xuat_ban = trim((string) ($postedData['nam_xuat_ban'] ?? ''));

    if ($ten_sach === '' || $tac_gia === '' || $nam_xuat_ban === '') {
        $errorMessage = 'Không lưu sách khi người dùng không nhập đủ thông tin.';
    } elseif (!is_numeric($nam_xuat_ban)) {
        $errorMessage = 'Năm xuất bản phải là số.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO sach (ten_sach, tac_gia, nam_xuat_ban) VALUES (:ten_sach, :tac_gia, :nam_xuat_ban)');
            $stmt->execute([
                'ten_sach' => $ten_sach,
                'tac_gia' => $tac_gia,
                'nam_xuat_ban' => (int) $nam_xuat_ban,
            ]);

            $booksStatement = $pdo->query('SELECT ma_sach, ten_sach, tac_gia, nam_xuat_ban FROM sach ORDER BY ma_sach DESC');
            $books = $booksStatement->fetchAll() ?: [];

            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1');
            exit;
        } catch (PDOException $e) {
            $errorMessage = 'Không thể lưu dữ liệu vào database.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="simple-shell">
        <div class="simple-card">
            <h2>Thêm sách</h2>

            <?php if ($successMessage): ?>
                <div class="alert success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if ($errorMessage): ?>
                <div class="alert error"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="ten_sach">Tên sách</label>
                    <input id="ten_sach" name="ten_sach" type="text" value="<?php echo htmlspecialchars($ten_sach_value); ?>">
                </div>

                <div class="form-group">
                    <label for="tac_gia">Tác giả</label>
                    <input id="tac_gia" name="tac_gia" type="text" value="<?php echo htmlspecialchars($tac_gia_value); ?>">
                </div>

                <div class="form-group">
                    <label for="nam_xuat_ban">Năm xuất bản</label>
                    <input id="nam_xuat_ban" name="nam_xuat_ban" type="text" value="<?php echo htmlspecialchars($nam_xuat_ban_value); ?>">
                </div>

                <button type="submit" class="submit-btn">Lưu lại</button>
            </form>

            <div class="book-list">
                <div class="list-header">
                    <h3>Danh sách sách</h3>
                    <span class="item-count"><?php echo count($books); ?> sách</span>
                </div>

                <?php if ($books): ?>
                    <div class="table-wrap">
                        <table class="book-table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">#</th>
                                    <th>Tên sách</th>
                                    <th>Tác giả</th>
                                    <th style="width: 140px;">Năm xuất bản</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $index => $book): ?>
                                    <tr>
                                        <td><?php echo (int) $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars((string) ($book['ten_sach'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($book['tac_gia'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($book['nam_xuat_ban'] ?? '')); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="empty-state">Chưa có sách nào trong cơ sở dữ liệu.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
