<?php
$ten_dang_nhap = "";
$mat_khau = "";
$loi = [];
$thanh_cong = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_dang_nhap = trim($_POST["ten_dang_nhap"] ?? "");
    $mat_khau = $_POST["mat_khau"] ?? "";

    if ($ten_dang_nhap == "") {
        $loi["ten_dang_nhap"] = "Vui lòng nhập tên đăng nhập, số điện thoại hoặc mã sinh viên.";
    }

    if ($mat_khau == "") {
        $loi["mat_khau"] = "Vui lòng nhập mật khẩu.";
    }

    if (count($loi) == 0) {
        $thanh_cong = true;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-shell">
        <div class="card auth-card">
            <?php if ($thanh_cong) { ?>
                <h1>Đăng nhập thành công</h1>
                <p class="info-text">Bạn đã nhập các thông tin sau:</p>
                <table class="result-table">
                    <tr><th>Tên đăng nhập</th><td><?php echo htmlspecialchars($ten_dang_nhap); ?></td></tr>
                    <tr><th>Mật khẩu</th><td><?php echo strlen($mat_khau); ?> ký tự</td></tr>
                </table>
                <a class="btn" href="dang_nhap.php">Quay lại</a>

            <?php } else { ?>
                <h1>Đăng nhập</h1>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="ten_dang_nhap">Tên đăng nhập</label>
                        <input type="text" id="ten_dang_nhap" name="ten_dang_nhap" value="<?php echo htmlspecialchars($ten_dang_nhap); ?>" placeholder="Nhập tên đăng nhập, số điện thoại hoặc mã sinh viên">
                        <?php if (isset($loi["ten_dang_nhap"])) { ?>
                            <p class="error-text"><?php echo $loi["ten_dang_nhap"]; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="mat_khau">Mật khẩu</label>
                        <input type="password" id="mat_khau" name="mat_khau">
                        <?php if (isset($loi["mat_khau"])) { ?>
                            <p class="error-text"><?php echo $loi["mat_khau"]; ?></p>
                        <?php } ?>
                    </div>

                    <button type="submit" class="btn">Đăng nhập</button>
                </form>

                <p class="link-row">Chưa có tài khoản? <a href="dang_ky.php">Đăng ký</a></p>
            <?php } ?>

            <p class="link-row"><a href="index.php">← Trang chủ</a></p>
        </div>
    </div>
</body>
</html>
