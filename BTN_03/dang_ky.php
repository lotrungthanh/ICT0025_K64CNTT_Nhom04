<?php
$ho_ten = "";
$email = "";
$gioi_tinh = "Nam";
$mat_khau = "";
$so_dien_thoai = "";
$ma_sinh_vien = "";
$loi = [];
$thanh_cong = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ho_ten = trim($_POST["ho_ten"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $gioi_tinh = $_POST["gioi_tinh"] ?? "Nam";
    $mat_khau = $_POST["mat_khau"] ?? "";
    $so_dien_thoai = trim($_POST["so_dien_thoai"] ?? "");
    $ma_sinh_vien = trim($_POST["ma_sinh_vien"] ?? "");
    $nhap_lai = $_POST["nhap_lai"] ?? "";

    if ($ho_ten == "") {
        $loi["ho_ten"] = "Vui lòng nhập họ tên.";
    }

    if ($email == "") {
        $loi["email"] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $loi["email"] = "Email không đúng định dạng.";
    }

    if ($so_dien_thoai == "") {
        $loi["so_dien_thoai"] = "Vui lòng nhập số điện thoại.";
    }

    if ($ma_sinh_vien == "") {
        $loi["ma_sinh_vien"] = "Vui lòng nhập mã sinh viên.";
    }

    if (strlen($mat_khau) < 6) {
        $loi["mat_khau"] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    if ($nhap_lai != $mat_khau) {
        $loi["nhap_lai"] = "Mật khẩu nhập lại không khớp.";
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
    <title>Đăng ký</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-shell">
        <div class="card auth-card">
            <?php if ($thanh_cong) { ?>
                <h1>Đăng ký thành công</h1>
                <p class="info-text">
                    Xin chào <b><?php echo htmlspecialchars($ho_ten); ?></b>, bạn đã nhập các thông tin sau:
                </p>
                <table class="result-table">
                    <tr><th>Họ tên</th><td><?php echo htmlspecialchars($ho_ten); ?></td></tr>
                    <tr><th>Email</th><td><?php echo htmlspecialchars($email); ?></td></tr>
                    <tr><th>Số điện thoại</th><td><?php echo htmlspecialchars($so_dien_thoai); ?></td></tr>
                    <tr><th>Mã sinh viên</th><td><?php echo htmlspecialchars($ma_sinh_vien); ?></td></tr>
                    <tr><th>Mật khẩu</th><td><?php echo strlen($mat_khau); ?> ký tự</td></tr>
                </table>
                <a class="btn" href="dang_nhap.php">Đến trang đăng nhập</a>

            <?php } else { ?>
                <h1>Đăng ký</h1>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="ho_ten">Họ tên</label>
                        <input type="text" id="ho_ten" name="ho_ten" value="<?php echo htmlspecialchars($ho_ten); ?>">
                        <?php if (isset($loi["ho_ten"])) { ?>
                            <p class="error-text"><?php echo $loi["ho_ten"]; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <?php if (isset($loi["email"])) { ?>
                            <p class="error-text"><?php echo $loi["email"]; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="so_dien_thoai">Số điện thoại</label>
                        <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="<?php echo htmlspecialchars($so_dien_thoai); ?>">
                        <?php if (isset($loi["so_dien_thoai"])) { ?>
                            <p class="error-text"><?php echo $loi["so_dien_thoai"]; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="ma_sinh_vien">Mã sinh viên</label>
                        <input type="text" id="ma_sinh_vien" placeholder="2023A0920" name="ma_sinh_vien" value="<?php echo htmlspecialchars($ma_sinh_vien); ?>">
                        <?php if (isset($loi["ma_sinh_vien"])) { ?>
                            <p class="error-text"><?php echo $loi["ma_sinh_vien"]; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="radio-row">
                            <label class="radio-option">
                                <input type="radio" name="gioi_tinh" value="Nam" <?php if ($gioi_tinh == "Nam") echo "checked"; ?>>
                                Nam
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="gioi_tinh" value="Nữ" <?php if ($gioi_tinh == "Nữ") echo "checked"; ?>>
                                Nữ
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mat_khau">Mật khẩu</label>
                        <input type="password" id="mat_khau" name="mat_khau">
                        <?php if (isset($loi["mat_khau"])) { ?>
                            <p class="error-text"><?php echo $loi["mat_khau"]; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="nhap_lai">Nhập lại mật khẩu</label>
                        <input type="password" id="nhap_lai" name="nhap_lai">
                        <?php if (isset($loi["nhap_lai"])) { ?>
                            <p class="error-text"><?php echo $loi["nhap_lai"]; ?></p>
                        <?php } ?>
                    </div>

                    <button type="submit" class="btn">Đăng ký</button>
                </form>

                <p class="link-row">Đã có tài khoản? <a href="dang_nhap.php">Đăng nhập</a></p>
            <?php } ?>

            <p class="link-row"><a href="index.php">← Trang chủ</a></p>
        </div>
    </div>
</body>
</html>
