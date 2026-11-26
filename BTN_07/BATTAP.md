# KẾT QUẢ THẢO LUẬN: CRUD, API VÀ MVC

> Tài liệu này tổng hợp hướng áp dụng cho đề tài **Quản lý thư viện**. Nhóm cần rà soát và chỉnh lại nếu biên bản thảo luận thực tế có quyết định khác.

## 1. Mục tiêu

Thống nhất cách tổ chức các thao tác dữ liệu, cách các phần của ứng dụng trao đổi dữ liệu và cách chia mã nguồn để dễ phát triển, kiểm tra, bảo trì.

## 2. CRUD

CRUD là bốn thao tác cơ bản trên dữ liệu:

- **Create** — tạo mới bản ghi.
- **Read** — xem hoặc tìm kiếm bản ghi.
- **Update** — chỉnh sửa bản ghi.
- **Delete** — xóa bản ghi.

### Áp dụng trong ứng dụng thư viện

| Đối tượng | Create | Read | Update | Delete |
|---|---|---|---|---|
| Sách | Thêm sách | Xem danh sách, tìm theo tên/tác giả | Sửa thông tin, số lượng, vị trí kệ | Xóa khi không còn dữ liệu mượn liên quan |
| Thể loại | Thêm thể loại | Xem danh sách | Đổi tên | Chỉ xóa khi không còn sách thuộc thể loại |
| Độc giả | Đăng ký/tạo hồ sơ | Xem và tra cứu hồ sơ | Sửa thông tin, trạng thái | Hạn chế xóa nếu có lịch sử mượn; ưu tiên khóa tài khoản |
| Phiếu mượn | Lập phiếu mượn | Xem phiếu và chi tiết | Cập nhật hạn trả, trạng thái trả | Không xóa lịch sử giao dịch tùy tiện |
| Tài khoản | Đăng ký độc giả hoặc admin tạo tài khoản nhân viên | Xem danh sách tài khoản theo quyền | Đổi thông tin, vai trò, trạng thái | Ưu tiên khóa thay vì xóa để giữ dấu vết |

### Kết quả thống nhất

- Các thao tác ghi dữ liệu phải kiểm tra dữ liệu đầu vào ở máy chủ.
- Dùng prepared statements khi truy vấn MySQL.
- Tôn trọng khóa ngoại và ràng buộc; không xóa bản ghi đang được phiếu mượn tham chiếu.
- Chỉ tài khoản có quyền phù hợp mới được tạo, sửa hoặc xóa dữ liệu quản trị.
- Các thay đổi trạng thái mượn/trả cần được thực hiện cùng cập nhật số bản còn trong một transaction để dữ liệu không lệch nhau.

## 3. API

API là giao diện để một phần mềm gửi yêu cầu và nhận dữ liệu từ phần mềm khác hoặc từ giao diện ứng dụng. Trong phiên bản PHP/MySQL hiện tại, có thể dùng PHP xử lý request và trả về JSON khi cần tích hợp AJAX hoặc ứng dụng khác.

### Endpoint đề xuất

| Phương thức | Đường dẫn | Chức năng | Quyền dự kiến |
|---|---|---|---|
| `GET` | `/api/sach.php` | Liệt kê/tìm kiếm sách | Công khai hoặc người dùng đã đăng nhập, theo chính sách nhóm |
| `POST` | `/api/sach.php` | Thêm sách | Thủ thư, admin |
| `GET` | `/api/sach.php?id={id}` | Xem chi tiết sách | Người dùng đã đăng nhập |
| `PUT` hoặc `POST` | `/api/sach.php?id={id}` | Cập nhật sách | Thủ thư, admin |
| `DELETE` | `/api/sach.php?id={id}` | Xóa sách khi không vướng dữ liệu liên quan | Admin hoặc thủ thư được phân quyền |
| `GET` | `/api/doc-gia.php` | Tra cứu độc giả | Thủ thư, admin |
| `POST` | `/api/phieu-muon.php` | Tạo phiếu mượn | Thủ thư, admin |
| `PATCH` hoặc `POST` | `/api/phieu-muon.php?id={id}` | Cập nhật trả sách/trạng thái | Thủ thư, admin |

### Quy ước API

- Request/response JSON dùng UTF-8; response có `Content-Type: application/json`.
- Dùng mã HTTP phù hợp: `200` thành công, `201` tạo mới, `400` dữ liệu sai, `401` chưa đăng nhập, `403` không đủ quyền, `404` không tìm thấy, `500` lỗi máy chủ.
- Không trả mật khẩu hoặc chuỗi băm mật khẩu trong response.
- Kiểm tra xác thực và quyền ở máy chủ cho từng endpoint; không dựa vào việc ẩn nút trên giao diện.
- Giới hạn dữ liệu trả về và hỗ trợ phân trang cho danh sách lớn.

> Các endpoint trên là thiết kế đề xuất; không khẳng định chúng đã được triển khai trong mã nguồn hiện tại.

## 4. MVC

MVC chia ứng dụng thành ba phần:

- **Model:** truy cập và xử lý dữ liệu, ví dụ `Sach`, `DocGia`, `PhieuMuon`, `NguoiDung`.
- **View:** giao diện HTML/CSS hiển thị dữ liệu và biểu mẫu.
- **Controller:** nhận request, kiểm tra đầu vào/quyền, gọi Model và chọn View hoặc tạo response API.

### Cấu trúc thư mục đề xuất

```text
project/
├── config.php                 # Cấu hình riêng, không đưa lên Git
├── config.example.php         # Mẫu cấu hình không chứa bí mật
├── public/                    # Điểm vào ứng dụng, CSS, JavaScript
├── app/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── routes/                    # Khai báo route trang/API
└── db.php                     # Kết nối cơ sở dữ liệu
```

### Kết quả thống nhất

- Controller không nên chứa toàn bộ truy vấn SQL và HTML trong cùng một tệp.
- Model chịu trách nhiệm truy vấn MySQL; View chỉ hiển thị dữ liệu đã được xử lý và escape.
- Tách API khỏi View: controller API trả JSON, controller trang web trả giao diện.
- Chỉ chuyển sang MVC đầy đủ khi nhóm thống nhất cấu trúc thư mục và có thời gian chuyển mã; không trộn thêm nhiều kiểu tổ chức trong cùng module.

## 5. Tổng kết

Nhóm dự kiến dùng CRUD để chuẩn hóa thao tác trên từng bảng, thiết kế API cho các chức năng cần trao đổi dữ liệu, và tổ chức phần PHP theo hướng MVC để tách truy vấn, điều khiển và giao diện. Ưu tiên bảo toàn lịch sử mượn trả, kiểm tra quyền phía máy chủ, dùng prepared statements và transaction cho các thao tác liên quan nhiều bảng.

