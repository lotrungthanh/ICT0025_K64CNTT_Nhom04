Họ tên : Lò Trung Thành 
Mã Sinh Viên : 2023A0920
Nhóm 4
Tài khoản GitHub:@lotrungthanh
Trạng thái GitHub Desktop: Đã cài đặt và kết nối thành công tài khoản GitHub.
2. HƯỚNG DẪN CÁCH CHẠY BÀI THỰC HÀNH
Mở trình duyệt web và gõ đường dẫn:
http://localhost/thanh/01_cu_phap.php
http://localhost/thanh/02_bien.php
http://localhost/thanh/03_hang.php
http://localhost/thanh/04_kieu_du_lieu.php
http://localhost/thanh/05_toan_tu.php
http://localhost/thanh/06_van_dung.php
A2
   1.01_cu_phap.php
   -PHP thực thi ở .... trình duyệt nhận được...
   2.02_bien.php
   -Quy tắc ký hiệu $: Tất cả các biến trong PHP đều phải bắt đầu bằng ký tự `$`.
   -tên biến hợp lệ : "$ten_san_pham" , tên biến không hợp lệ :$1ten-san-phẩm 
   -Giống: Phân biệt chữ hoa/chữ thường
   -khác: PHP không cần khai báo kiểu dữ liệu khi tạo biến như "int x = 5;" trong C++/Java
   3.03_hang.php
    -  Biến ("$var"):  Có thể thay đổi giá trị trong quá trình chạy chương trình.
    -  Hằng ("const" / "define"):  Giá trị được giữ cố định sau khi định nghĩa, không thể gán lại hoặc hủy định nghĩa trong suốt vòng đời của script.
   4.04_kieu_du_lieu.php
   - `42` -> `int(42)`
  - `3.1415` -> `float(3.1415)`
  - `true` -> `bool(true)`
  - `null` -> `NULL`
  - Chuỗi `"12"` trước khi ép kiểu -> `string(2) "12"`
  - Giá trị sau khi ép kiểu `(int)` -> `int(12)`
  - PHP là ngôn ngữ tự động chuyển đổi kiểu dữ liệu linh hoạt tuy nhiên ta có thể chủ động ép kiểu bằng cú pháp `(int)`, `(string)` khi cần tính toán chính xác.
   5.05_toan_tu.php
   -  `15 + 4 = 19 , 15 - 4 = 11, 15 * 4 = 60, 15 / 4 = 3.75 , 15 % 4 = 3
  - $x += 5->$x = 10
  - 5 == "5" -> bool(true)
  - 5 === "5" ->bool(false)
  - Biểu thức logic (5 == "5" && 10 > 5) || (3 < 1) ->bool(true)
    -(So sánh bằng  == ): Chỉ so sánh  giá trị  sau khi tự động chuyển kiểu (VD: 5 == "5" trả về `true`).
    -  (So sánh bằng tuyệt đối === ): So sánh cả  giá trị  VÀ  kiểu dữ liệu  (VD: 5 === "5" trả về `false` vì một bên là int, một bên là `string`).
   6.van_dung.php
   Đơn hàng 1 (Mặt hàng Sách)
    - Đầu vào: Tên hàng = "Sách", Số lượng = 3, Đơn giá = 50.000 VNĐ, Tỷ lệ phí = 20% (0.2).
    - Tiền hàng: 3 * 50.000 = 150.000 VNĐ.
    - Tiền phí: 150.000 * 0.2 = 30.000 VNĐ.
    - Tổng tiền thanh toán: 150.000 + 30.000 = 180.000 VNĐ.

   - Đơn hàng 2 (Mặt hàng Bút - Bộ dữ liệu đối chiếu tự động)
    - Đầu vào: Tên hàng = "bút", Số lượng = 3, Đơn giá = 25.000 VNĐ, Tỷ lệ phí = 5% (0.05).
    - Tiền hàng: (3 * 25.000)= 75.000 VNĐ.
    - Tiền phí: (75.000 * 0.05) = 3.750 VNĐ.
    - Tổng tiền thanh toán: 75.000 + 3.750 = 78.750 VNĐ 