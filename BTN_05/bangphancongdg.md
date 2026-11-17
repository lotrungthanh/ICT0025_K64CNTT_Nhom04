### Nhóm 4
- Các thành viên: 
+ Lò Trung Thành
+ Tòng Đức Hiệu
+ Thinnaly Bounchan
+ Tamon Viset

### Phân công nhiệm vụ:
- Lò Trung Thành: phụ trách file `db.php`, đảm nhiệm kết nối cơ sở dữ liệu MySQL và cấu hình PDO.
- Tòng Đức Hiệu: phụ trách xử lý logic lưu dữ liệu, gồm `PREPARE` và tham số cho `INSERT`; sau khi thêm, dùng `SELECT` lấy danh sách và `foreach` hiển thị; sử dụng `htmlspecialchars` khi in dữ liệu ra HTML.
- Thinnaly Bounchan: phụ trách xây dựng form thêm dữ liệu và hiển thị trang danh sách cho đối tượng đã chọn.
- Tamon Viseth: phụ trách file `style.css`, thiết kế giao diện form và danh sách sao cho đẹp, rõ ràng và dễ sử dụng.

### Ghi chú:
- Mỗi thành viên cùng tham gia kiểm tra lại dữ liệu đầu vào, xử lý lỗi và đảm bảo trang hoạt động ổn định.
- Nếu có thay đổi về chức năng hoặc giao diện, nhóm sẽ trao đổi và cập nhật cùng nhau.

### Kiểm thử 3 trường hợp

| STT | Đầu vào | Kết quả mong đợi | Kết quả thực tế |
|-----|---------|------------------|----------------|
| 1 | Tên sách: `Thiết kế Web`; Tác giả: `Nguyễn Văn A`; Năm xuất bản: `2024` | Dữ liệu được lưu vào database và hiển thị trong danh sách | Đã lưu thành công và xuất hiện trong danh sách |
| 2 | Tên sách: rỗng; Tác giả: `Nguyễn Văn A`; Năm xuất bản: `2024` | Hiển thị thông báo lỗi, không lưu dữ liệu | Không lưu dữ liệu khi thiếu thông tin bắt buộc |
| 3 | Tên sách: `Lập trình PHP`; Tác giả: `Nguyễn Văn A`; Năm xuất bản: `abc` | Hiển thị thông báo "Năm xuất bản phải là số", không lưu | Đã báo lỗi và không lưu dữ liệu |

### Ghi nhận:
- Mỗi người trong nhóm lần lượt chạy hoặc giải thích từng bước kiểm thử để đảm bảo hệ thống hoạt động đúng như yêu cầu.
- Nếu có lỗi xảy ra, nhóm sẽ cùng ghi nhận nguyên nhân và sửa lại ngay.