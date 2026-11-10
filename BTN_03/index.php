<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-shell">
        <div class="card home-card">
            <p class="home-badge">Trang chủ</p>
            <h1>Chào mừng bạn</h1>
            <p class="home-date">Hôm nay là ngày <?php echo date("d/m/Y"); ?></p>
            <p class="home-desc">
                Khám phá trải nghiệm đăng nhập và đăng ký nhanh chóng, hiện đại và dễ sử dụng.
            </p>

            <div class="home-actions">
                <a class="btn" href="dang_nhap.php">Đăng nhập</a>
                <a class="btn btn-secondary" href="dang_ky.php">Đăng ký</a>
            </div>
        </div>
    </div>
</body>
</html>
