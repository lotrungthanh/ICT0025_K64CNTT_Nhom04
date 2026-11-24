<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'Quản lý mượn trả';
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($pageTitle) ?> - Nhóm 4</title>
<link rel="stylesheet" href="/nhom4_thuvien/assets/style.css">
</head>
<body>
<header class="top">
  <div class="wrap">
    <h1>Phân hệ mượn - trả thư viện</h1>
    <nav>
      <a href="/nhom4_thuvien/index.php">Trang chủ</a>
      <a href="/nhom4_thuvien/muon_tra/muon_sach.php">Mượn sách</a>
      <a href="/nhom4_thuvien/muon_tra/danh_sach_muon.php">Danh sách mượn</a>
      <a href="/nhom4_thuvien/muon_tra/tra_sach.php">Trả sách</a>
      <a href="/nhom4_thuvien/bao_cao/bao_cao_muon.php">Báo cáo</a>
    </nav>
  </div>
</header>
<main class="wrap">
<?php show_flash(); ?>
