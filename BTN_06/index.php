<?php
require_once __DIR__ . '/db.php';

$successMessage = '';
$errorMessage = '';
$postedData = $_POST ?? [];
$ten_sach_value = $postedData['ten_sach'] ?? '';
$tac_gia_value = $postedData['tac_gia'] ?? '';
$nam_xuat_ban_value = $postedData['nam_xuat_ban'] ?? '';
$editBook = null;
$books = [];

if (isset($_GET['success'])) {
    $successMessages = [
        '1' => 'Thêm sách thành công.',
        '2' => 'Cập nhật sách thành công.',
        '3' => 'Xóa sách thành công.',
    ];
    $successMessage = $successMessages[$_GET['success']] ?? '';
}

try {
    $pdo = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $postedData['action'] ?? 'save';

        if ($action === 'delete') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                $errorMessage = 'Không tìm thấy sách cần xóa.';
            } else {
                $stmt = $pdo->prepare('DELETE FROM sach WHERE ma_sach = :id');
                $stmt->execute(['id' => $id]);

                if ($stmt->rowCount() > 0) {
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?success=3');
                    exit;
                }

                $errorMessage = 'Không tìm thấy sách cần xóa.';
            }
        } else {
            $ten_sach = trim((string) ($postedData['ten_sach'] ?? ''));
            $tac_gia = trim((string) ($postedData['tac_gia'] ?? ''));
            $nam_xuat_ban = trim((string) ($postedData['nam_xuat_ban'] ?? ''));

            if ($ten_sach === '' || $tac_gia === '' || $nam_xuat_ban === '') {
                $errorMessage = 'Không lưu sách khi người dùng không nhập đủ thông tin.';
            } elseif (filter_var($nam_xuat_ban, FILTER_VALIDATE_INT) === false || (int) $nam_xuat_ban <= 0) {
                $errorMessage = 'Năm xuất bản phải là số nguyên dương hợp lệ.';
            } else {
                if ($action === 'update') {
                    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

                    if (!$id) {
                        $errorMessage = 'Không tìm thấy sách cần cập nhật.';
                    } else {
                        $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM sach WHERE ma_sach = :id');
                        $checkStmt->execute(['id' => $id]);

                        if ((int) $checkStmt->fetchColumn() === 0) {
                            $errorMessage = 'Không tìm thấy sách cần cập nhật.';
                        } else {
                            $stmt = $pdo->prepare('UPDATE sach SET ten_sach = :ten_sach, tac_gia = :tac_gia, nam_xuat_ban = :nam_xuat_ban WHERE ma_sach = :id');
                            $stmt->execute([
                                'ten_sach' => $ten_sach,
                                'tac_gia' => $tac_gia,
                                'nam_xuat_ban' => (int) $nam_xuat_ban,
                                'id' => $id,
                            ]);

                            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=2');
                            exit;
                        }
                    }
                } else {
                    $stmt = $pdo->prepare('INSERT INTO sach (ten_sach, tac_gia, nam_xuat_ban) VALUES (:ten_sach, :tac_gia, :nam_xuat_ban)');
                    $stmt->execute([
                        'ten_sach' => $ten_sach,
                        'tac_gia' => $tac_gia,
                        'nam_xuat_ban' => (int) $nam_xuat_ban,
                    ]);

                    header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1');
                    exit;
                }
            }
        }
    }

    $editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
    if (!$editId && $_SERVER['REQUEST_METHOD'] === 'POST' && ($postedData['action'] ?? '') === 'update') {
        $editId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    }

    if ($editId) {
        $editStatement = $pdo->prepare('SELECT ma_sach, ten_sach, tac_gia, nam_xuat_ban FROM sach WHERE ma_sach = :id');
        $editStatement->execute(['id' => $editId]);
        $editBook = $editStatement->fetch() ?: null;

        if ($editBook && empty($postedData)) {
            $ten_sach_value = (string) $editBook['ten_sach'];
            $tac_gia_value = (string) $editBook['tac_gia'];
            $nam_xuat_ban_value = (string) $editBook['nam_xuat_ban'];
        }

        if (!$editBook) {
            $errorMessage = 'Không tìm thấy sách cần cập nhật.';
        }
    }

    $booksStatement = $pdo->query('SELECT ma_sach, ten_sach, tac_gia, nam_xuat_ban FROM sach ORDER BY ma_sach DESC');
    $books = $booksStatement->fetchAll() ?: [];
} catch (PDOException $e) {
    $errorMessage = 'Không thể kết nối hoặc thao tác với database thu_vien.';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $editBook ? 'Cập nhật sách' : 'Thêm sách'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="simple-shell">
        <div class="simple-card">
            <h2><?php echo $editBook ? 'Cập nhật sách' : 'Thêm sách'; ?></h2>

            <?php if ($successMessage): ?>
                <div class="alert success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if ($errorMessage): ?>
                <div class="alert error"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="book-form">
                <input type="hidden" name="action" value="<?php echo $editBook ? 'update' : 'save'; ?>">
                <?php if ($editBook): ?>
                    <input type="hidden" name="id" value="<?php echo (int) $editBook['ma_sach']; ?>">
                <?php endif; ?>

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

                <div class="form-actions">
                    <button type="submit" class="submit-btn"><?php echo $editBook ? 'Cập nhật' : 'Lưu lại'; ?></button>
                    <?php if ($editBook): ?>
                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="cancel-btn">Hủy</a>
                    <?php endif; ?>
                </div>
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
                                    <th style="width: 150px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $index => $book): ?>
                                    <tr>
                                        <td><?php echo (int) $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars((string) ($book['ten_sach'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($book['tac_gia'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($book['nam_xuat_ban'] ?? '')); ?></td>
                                        <td class="action-cell">
                                            <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?edit=' . (int) $book['ma_sach']; ?>" class="edit-btn">Sửa</a>
                                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="inline-form">
                                                <input type="hidden" name="id" value="<?php echo (int) $book['ma_sach']; ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sách này không?');">Xóa</button>
                                            </form>
                                        </td>
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
