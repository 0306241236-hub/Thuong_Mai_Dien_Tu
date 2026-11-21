# Danh sách Test Case – Dự án Website Bán Sách

| ID | Mã chức năng | Bước thực hiện | Dữ liệu | Kết quả mong đợi | Kết quả thực tế |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC-01 | TM-05 | 1. Mở trang chi tiết sách còn hàng.<br>2. Chọn số lượng hợp lệ.<br>3. Bấm nút "Thêm vào giỏ hàng". | Sách ID: 1 (Tồn kho: 10), Số lượng: 2 | Thêm thành công vào giỏ hàng, biểu tượng giỏ hàng tăng thêm 2 sản phẩm. | Chưa chạy |
| TC-02 | TM-05 | 1. Mở trang chi tiết sách đã có sẵn 2 cuốn trong giỏ.<br>2. Bấm "Thêm vào giỏ hàng" thêm 3 cuốn nữa. | Sách ID: 1 (đã có 2), Thêm mới: 3 | Không tạo dòng mới trùng lặp, cộng dồn số lượng thành 5 và cập nhật lại tổng tiền. | Chưa chạy |
| TC-03 | TM-05 | 1. Mở trang chi tiết sách.<br>2. Nhập số lượng lớn hơn số lượng tồn kho.<br>3. Bấm "Thêm vào giỏ hàng". | Sách ID: 1 (Tồn kho: 5), Số lượng: 10 | Hệ thống từ chối thêm, hiển thị thông báo "Số lượng vượt quá tồn kho hiện có". | Chưa chạy |
| TC-04 | TM-05 | 1. Mở trang Giỏ hàng.<br>2. Thay đổi số lượng sản phẩm từ 2 thành 4. | Sách ID: 1, Đơn giá: 100.000đ, SL mới: 4 | Cập nhật số lượng thành 4, thành tiền dòng đó là 400.000đ và cập nhật tổng đơn. | Chưa chạy |
| TC-05 | TM-05 | 1. Mở trang Giỏ hàng.<br>2. Bấm nút "Xóa" (thùng rác) tại dòng sản phẩm và xác nhận. | Sách ID: 1 trong giỏ hàng | Sản phẩm biến mất khỏi danh sách giỏ hàng, tổng tiền được tính lại chính xác. | Chưa chạy |


| TC-06 | TM-04 | 1. Mở trang Đăng ký.<br>2. Nhập đầy đủ họ tên, email chưa tồn tại, mật khẩu hợp lệ.<br>3. Bấm "Đăng ký". | Tên: Nguyễn Văn A, Email: `a@gmail.com`, MK: `Pass@123` | Tạo tài khoản thành công, mật khẩu trong CSDL được lưu dưới dạng chuỗi đã băm (hash), chuyển hướng đăng nhập. | Chưa chạy |
| TC-07 | TM-04 | 1. Mở trang Đăng ký.<br>2. Nhập email đã có người đăng ký trước đó.<br>3. Bấm "Đăng ký". | Email đã tồn tại trong bảng `users` | Hệ thống từ chối đăng ký, hiển thị thông báo lỗi tiếng Việt "Email đã được sử dụng". | Chưa chạy |
| TC-08 | TM-04 | 1. Mở trang Đăng ký.<br>2. Nhập email sai định dạng (thiếu `@` hoặc tên miền).<br>3. Bấm "Đăng ký". | Email: `nguyenvana.gmail.com` | Không gửi/lưu dữ liệu, hiển thị thông báo lỗi định dạng email hợp lệ. | Chưa chạy |
| TC-09 | TM-04 | 1. Mở trang Đăng ký.<br>2. Bỏ trống trường bắt buộc hoặc nhập mật khẩu quá ngắn (< 6 ký tự).<br>3. Bấm "Đăng ký". | Email: `b@gmail.com`, MK: `123` | Hệ thống chặn lại và báo lỗi yêu cầu nhập đủ thông tin / độ dài mật khẩu tối thiểu. | Chưa chạy |
| TC-10 | TM-04 | 1. Đăng ký thành công tài khoản mới.<br>2. Kiểm tra file log server và bảng `users` trong CSDL. | Email: `c@gmail.com`, MK: `Secret@123` | Không xuất hiện chuỗi mật khẩu gốc `Secret@123` trong console/file log; cột mật khẩu dùng thuật toán băm an toàn. | Chưa chạy |