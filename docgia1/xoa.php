<?php
require_once 'config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: index.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM doc_gia WHERE ma_doc_gia = :id");
    $stmt->execute(['id' => $id]);
    header("Location: index.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    // Mã lỗi 23000: Vi phạm ràng buộc khóa ngoại (độc giả đã có phiếu mượn)
    if ($e->getCode() == 23000) {
        header("Location: index.php?err=fk_error");
        exit;
    }
    die("Lỗi khi xóa dữ liệu: " . $e->getMessage());
}
?>