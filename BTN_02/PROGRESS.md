 ### Nhóm 04 
 - Danh sách thành viên:
+ Lò Trung Thành 
+ Tòng Đức Hiệu 
+ Thinnaly Bounchan 
+ Tamon Viseth
### Phân công nhiệm vụ 
- Tamon Viseth :  Nhiệm vụ 1,4 
- Tòng Đức Hiệu : Nhiệm vụ 2,4
- Thinnaly Bounchan : Nhiệm vụ 3,4 
- Lò Trung Thành : Nhiệm vụ 2,4
 ### Nhiệm vụ 1 
- ví dụ A:
Kết quả khi thay đổi giá trị $diem:
5 In ra Cần cố gắng, 6.5 In ra Khá, 8 In ra Giỏi
- khi chạy với $diem = 6.5 thì thuộc nhánh khá vì điều kiện là nếu $diem => 6.5 thì kết quả sẽ cho là khá. và nếu nhỏ hơn 6.5 thì kết quả sẽ thành nhánh khác. Đổi $diem = 8 thì sẽ thuộc nhánh giỏi vì điều kiện cho là nếu =>8 thì kết quả sẽ là giỏi.
- ví dụ B:
vai trò của default là xác định các trạng thái không ở trong 2 trạng thái 1 và 2. Bỏ break sau case 2 thì trạng thái số 2 sẽ không được thực hiện và sẽ hiển thị trạng thái ở nhánh default.
- Ví dụ C: 
dự đoán : 12345
Số lần lặp: 5 lần.
Giá trị $i sau vòng lặp: $i = 6
So sánh $i <= 5 với i < 5:
$i <= 5: Vòng lặp chạy 5 lần (in từ 1 đến 5).
$i < 5: Vòng lặp chạy 4 lần (in từ 1 đến 4).
- ví dụ :
dự đoán : 10 7 4 1 
số lần lặp : 4 lần.
Điều kiện để vòng lặp tiếp tục chạy là $sn > 0.
+Nếu dùng phép trừ ($sn--), giá trị của $sn sẽ giảm dần từ 5 về 0. Khi $sn = 0, điều kiện $sn > 0 thành Sai và vòng lặp dừng lại.
+Nếu đổi thành phép cộng ($sn++), giá trị của $sn sẽ liên tục tăng lên (5,6,7,…), khiến điều kiện $sn > 0 luôn luôn Đúng → dẫn đến vòng lặp vô tận (không bao giờ dừng).

### Nhiệm Vụ 2 
-  sau khi đối chiếu kết quả của 2 cách thì kết quả cho ra đều giống nhau.
- vai trò của break giúp đảm bảo rằng chỉ có đúng 1 khối lệnh tương ứng với trạng thái được tìm thấy 
- Đầu vào và kết quả: cả 2 cách sau khi thay đầu vào = 1 thì kết quả đều cho ra là "mới tạo", thay = 2 thì kết quả cho ra là " đang xử lý", thay = 9 thì kết quả cho ra là " không xác định".

### Nhiệm vụ 3 
- giá trị khởi tạo ($i = 1) , biến bắt đầu từ 1 để công việc đầu tiên.
- Điều kiện tiếp tục ($i <= $soluong) 
- Bước tăng $i++ 
- Vòng lặp sẽ dừng khi biểu thức điều kiện ($i <= $soluong) trả về giá trị sai. 
- Sau khi thử cả 2 cách với $soluong 0, 1, 5 thì kết quả cả 2 cách đều giống nhau: 
    - ($soluong = 0) thì kết quả in ra không xuất hiện gì.
    - ($soluong = 1) thì kết quả in ra công việc 1.
    - ($soluong = 5) thì kết quả in ra công việc 1, công việc 2, công việc 3, công việc 4, công việc 5.
### Nhiệm Vụ 4
-
| đầu vào |kết quả mong đợi| kết quả thực tế |đạt / chưa đạt|
| --- | --- | --- | ---|
| 1 | Mới tạo | Mới tạo | đạt |
| 2 | đang xử lý  | đang xử lý | đạt |
| 9 | không xác định  | không xác định | đạt |

