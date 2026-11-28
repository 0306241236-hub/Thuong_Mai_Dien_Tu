### Test Case 1 (TC-01)
* **ID:** TC-01[cite: 18, 19]
* **Mã chức năng:** TM-05[cite: 18, 19]
* **Bước thực hiện:** 
  1. Đăng nhập hệ thống[cite: 18, 19].
  2. Truy cập trang chi tiết một cuốn sách[cite: 18, 19].
  3. Chọn số lượng muốn mua[cite: 18, 19].
  4. Nhấn nút "Thêm vào giỏ hàng"[cite: 18, 19].
* **Dữ liệu:** Sách: *"Lập trình C++ cơ bản"* (Tồn kho: 10); Số lượng: 2[cite: 18, 19].
* **Kết quả mong đợi:** 
  - Sản phẩm được thêm thành công vào giỏ hàng[cite: 18, 19].
  - Biểu tượng giỏ hàng trên Header cập nhật số lượng = 2[cite: 18, 19].
  - Hiển thị thông báo "Thêm vào giỏ hàng thành công"[cite: 18, 19].
* **Kết quả thực tế:** Đang cập nhật[cite: 18, 19].

---

### Test Case 2 (TC-02)
* **ID:** TC-02[cite: 18, 19]
* **Mã chức năng:** TM-05[cite: 18, 19]
* **Bước thực hiện:** 
  1. Thêm sản phẩm A (số lượng 1) vào giỏ hàng[cite: 18, 19].
  2. Quay lại trang chi tiết sản phẩm A, chọn số lượng 2[cite: 18, 19].
  3. Nhấn "Thêm vào giỏ hàng" lần nữa[cite: 18, 19].
* **Dữ liệu:** Sách: *"Lập trình C++ cơ bản"*[cite: 18, 19].
* **Kết quả mong đợi:** 
  - Số lượng của sản phẩm A trong giỏ hàng được cộng dồn thành 3 (1 + 2)[cite: 18, 19].
  - Không sinh ra dòng sản phẩm trùng lặp trong giỏ hàng[cite: 18, 19].
* **Kết quả thực tế:** Đang cập nhật[cite: 18, 19].

---

### Test Case 3 (TC-03)
* **ID:** TC-03[cite: 18, 19]
* **Mã chức năng:** TM-05[cite: 18, 19]
* **Bước thực hiện:** 
  1. Truy cập vào trang Giỏ hàng[cite: 18, 19].
  2. Thay đổi trực tiếp ô số lượng của một sản phẩm từ 2 lên 5[cite: 18, 19].
  3. Nhấn nút "Cập nhật"[cite: 18, 19].
* **Dữ liệu:** Sản phẩm: Sách C++; Số lượng mới: 5[cite: 18, 19].
* **Kết quả mong đợi:** 
  - Tổng giá tiền của sản phẩm đó được tính lại chính xác theo số lượng mới[cite: 18, 19].
  - Tổng tiền thanh toán toàn giỏ hàng được cập nhật lại đúng[cite: 18, 19].
* **Kết quả thực tế:** Đang cập nhật[cite: 18, 19].

---

### Test Case 4 (TC-04)
* **ID:** TC-04[cite: 18, 19]
* **Mã chức năng:** TM-05[cite: 18, 19]
* **Bước thực hiện:** 
  1. Truy cập trang Giỏ hàng (đang có ít nhất 1 sản phẩm)[cite: 18, 19].
  2. Nhấn nút "Xóa" (biểu tượng thùng rác) ở dòng sản phẩm tương ứng[cite: 18, 19].
  3. Xác nhận xóa (nếu có hộp thoại)[cite: 18, 19].
* **Dữ liệu:** Sản phẩm muốn xóa: Bất kỳ[cite: 18, 19].
* **Kết quả mong đợi:** 
  - Sản phẩm biến mất khỏi danh sách giỏ hàng[cite: 18, 19].
  - Số lượng hiển thị trên icon giỏ hàng giảm đi[cite: 18, 19].
  - Tổng tiền giỏ hàng cập nhật lại tương ứng[cite: 18, 19].
* **Kết quả thực tế:** Đang cập nhật[cite: 18, 19].

---

### Test Case 5 (TC-05)
* **ID:** TC-05[cite: 18, 19]
* **Mã chức năng:** TM-05[cite: 18, 19]
* **Bước thực hiện:** 
  1. Truy cập trang chi tiết sách có giới hạn tồn kho thấp[cite: 18, 19].
  2. Nhập số lượng mua lớn hơn số lượng thực tế trong kho[cite: 18, 19].
  3. Nhấn "Thêm vào giỏ hàng"[cite: 18, 19].
* **Dữ liệu:** Sách có tồn kho: 5; Số lượng nhập mua: 10[cite: 18, 19].
* **Kết quả mong đợi:** 
  - Hệ thống ngăn chặn thao tác và hiển thị thông báo lỗi/cảnh báo (*"Số lượng vượt quá tồn kho cho phép"*)[cite: 18, 19].
  - Không cho phép thêm vượt mức tồn kho vào giỏ hàng[cite: 18, 19].
* **Kết quả thực tế:** Đang cập nhật[cite: 18, 19].

* Test Case ID: TM-04-01
Module / Luồng: Đăng ký
Tên Test Case: Đăng ký tài khoản mới thành công với thông tin hợp lệ
Điều kiện tiên quyết: Người dùng chưa có tài khoản; đang ở trang Đăng ký.
Các bước thực hiện:
1. Nhập họ tên, email chưa tồn tại và mật khẩu hợp lệ.
2. Nhập lại mật khẩu khớp.
3. Nhấn nút Đăng ký.
Kết quả mong đợi: Hệ thống tạo tài khoản mới, gán vai trò mặc định (ví dụ: User), lưu dữ liệu an toàn và chuyển hướng tới trang đăng nhập hoặc trang chủ kèm thông báo thành công.

--------------------------------------------------

Test Case ID: TM-04-02
Module / Luồng: Đăng ký
Tên Test Case: Chặn đăng ký khi email đã tồn tại trên hệ thống
Điều kiện tiên quyết: Email user@example.com đã được đăng ký trước đó.
Các bước thực hiện:
1. Nhập email user@example.com cùng thông tin hợp lệ khác.
2. Nhấn nút Đăng ký.
Kết quả mong đợi: Hệ thống không tạo tài khoản trùng lặp và hiển thị thông báo lỗi rõ ràng (ví dụ: "Email đã được sử dụng").

--------------------------------------------------

Test Case ID: TM-04-03
Module / Luồng: Đăng nhập
Tên Test Case: Đăng nhập thất bại khi sai mật khẩu
Điều kiện tiên quyết: Tài khoản đã tồn tại và đang ở trạng thái hoạt động.
Các bước thực hiện:
1. Nhập đúng email đã đăng ký.
2. Nhập sai mật khẩu.
3. Nhấn nút Đăng nhập.
Kết quả mong đợi: Hệ thống từ chối truy cập, không tạo phiên đăng nhập và hiển thị thông báo lỗi chung (ví dụ: "Email hoặc mật khẩu không đúng").

--------------------------------------------------

Test Case ID: TM-04-04
Module / Luồng: Đăng xuất
Tên Test Case: Đăng xuất khỏi hệ thống và vô hiệu hóa phiên làm việc
Điều kiện tiên quyết: Người dùng đang đăng nhập hợp lệ trên hệ thống.
Các bước thực hiện:
1. Nhấn nút Đăng xuất trên giao diện.
2. Nhấn nút Back trên trình duyệt hoặc truy cập trực tiếp URL trang cá nhân.
Kết quả mong đợi: Phiên đăng nhập/token bị hủy, người dùng được đưa về trang Đăng nhập và không thể truy cập lại trang yêu cầu xác thực nếu chưa đăng nhập lại.

--------------------------------------------------

Test Case ID: TM-04-05
Module / Luồng: Phân quyền
Tên Test Case: Chặn người dùng thường truy cập chức năng dành cho Admin
Điều kiện tiên quyết: Người dùng đã đăng nhập với vai trò User (không có quyền Admin).
Các bước thực hiện:
1. Đăng nhập bằng tài khoản User.
2. Truy cập trực tiếp đường dẫn quản trị (ví dụ: /admin/users) hoặc gọi API quản trị.
Kết quả mong đợi: Hệ thống từ chối quyền truy cập (trả về lỗi 403 Forbidden hoặc chuyển hướng về trang thông báo không có quyền), dữ liệu quản trị được bảo vệ.


Test Case ID: TM-07-01
Module / Luồng: Đơn của tôi
Tên Test Case: Hiển thị danh sách đơn hàng của người dùng đang đăng nhập
Điều kiện tiên quyết: Người dùng đã đăng nhập và có ít nhất 1 đơn hàng trong hệ thống.
Các bước thực hiện:
1. Truy cập mục Đơn của tôi trên trang cá nhân.
Kết quả mong đợi: Hệ thống hiển thị đầy đủ các đơn hàng của tài khoản này (mã đơn, ngày đặt, tổng tiền, trạng thái) theo thứ tự mới nhất trước.

--------------------------------------------------

Test Case ID: TM-07-02
Module / Luồng: Đơn của tôi
Tên Test Case: Lọc đơn hàng theo trạng thái
Điều kiện tiên quyết: Người dùng có nhiều đơn hàng ở các trạng thái khác nhau (Chờ xác nhận, Đang giao, Hoàn thành, Đã hủy).
Các bước thực hiện:
1. Tại trang Đơn của tôi, chọn tab/bộ lọc trạng thái Đang giao.
Kết quả mong đợi: Danh sách chỉ hiển thị các đơn hàng có trạng thái Đang giao; số lượng hiển thị khớp với dữ liệu thực tế.

--------------------------------------------------

Test Case ID: TM-07-03
Module / Luồng: Đơn của tôi
Tên Test Case: Xem chi tiết thông tin một đơn hàng
Điều kiện tiên quyết: Đang ở danh sách Đơn của tôi và có đơn hàng hợp lệ.
Các bước thực hiện:
1. Nhấn vào một đơn hàng bất kỳ hoặc chọn Xem chi tiết.
Kết quả mong đợi: Hệ thống mở trang chi tiết đơn hàng, hiển thị đúng danh sách sản phẩm, số lượng, đơn giá, phí vận chuyển, địa chỉ nhận hàng và phương thức thanh toán.

--------------------------------------------------

Test Case ID: TM-07-04
Module / Luồng: Đơn của tôi
Tên Test Case: Hủy đơn hàng thành công khi đơn đang ở trạng thái chờ xử lý
Điều kiện tiên quyết: Người dùng có đơn hàng ở trạng thái Chờ xác nhận (chưa giao cho đơn vị vận chuyển).
Các bước thực hiện:
1. Mở chi tiết đơn hàng Chờ xác nhận.
2. Nhấn nút Hủy đơn hàng, chọn lý do và xác nhận.
Kết quả mong đợi: Trạng thái đơn chuyển sang Đã hủy, hiển thị thông báo hủy thành công, đồng thời hoàn lại số lượng tồn kho (nếu có).

--------------------------------------------------

Test Case ID: TM-07-05
Module / Luồng: Đơn của tôi
Tên Test Case: Chặn xem chi tiết đơn hàng của người dùng khác (IDOR)
Điều kiện tiên quyết: Đã đăng nhập tài khoản User A; biết mã/ID đơn hàng của User B.
Các bước thực hiện:
1. Thay đổi ID đơn hàng trên thanh địa chỉ URL (ví dụ: /my-orders/999) sang mã đơn thuộc về User B.
2. Nhấn Enter để tải trang.
Kết quả mong đợi: Hệ thống từ chối truy cập (trả về lỗi 403 Forbidden hoặc 404 Not Found), tuyệt đối không hiển thị thông tin đơn hàng của User B.

Test Case ID: TM-13-01
Module / Luồng: Quản lý đơn
Tên Test Case: Hiển thị danh sách toàn bộ đơn hàng trên trang quản trị
Điều kiện tiên quyết: Đã đăng nhập tài khoản có quyền Admin/Nhân viên và hệ thống có dữ liệu đơn hàng.
Các bước thực hiện:
1. Truy cập menu Quản lý đơn hàng trên trang quản trị.
Kết quả mong đợi: Hệ thống hiển thị danh sách tất cả đơn hàng của khách hàng (mã đơn, tên khách hàng, ngày đặt, tổng tiền, trạng thái) kèm phân trang chính xác.

--------------------------------------------------

Test Case ID: TM-13-02
Module / Luồng: Quản lý đơn
Tên Test Case: Tìm kiếm và lọc đơn hàng theo mã đơn hoặc trạng thái
Điều kiện tiên quyết: Đang ở trang Quản lý đơn hàng và có nhiều đơn hàng ở các trạng thái khác nhau.
Các bước thực hiện:
1. Nhập mã đơn hàng hợp lệ vào ô tìm kiếm và nhấn Tìm kiếm.
2. Xóa từ khóa và chọn bộ lọc trạng thái (ví dụ: Chờ xác nhận).
Kết quả mong đợi: Kết quả trả về khớp chính xác với mã đơn đã nhập và lọc đúng danh sách đơn theo trạng thái được chọn.

--------------------------------------------------

Test Case ID: TM-13-03
Module / Luồng: Quản lý đơn
Tên Test Case: Cập nhật trạng thái đơn hàng theo quy trình hợp lệ
Điều kiện tiên quyết: Có đơn hàng đang ở trạng thái Chờ xác nhận.
Các bước thực hiện:
1. Mở chi tiết đơn hàng Chờ xác nhận.
2. Chuyển trạng thái đơn sang Đang giao hàng và nhấn Lưu/Cập nhật.
Kết quả mong đợi: Hệ thống lưu thành công trạng thái mới, hiển thị thông báo cập nhật thành công và đồng bộ trạng thái này sang phía khách hàng.

--------------------------------------------------

Test Case ID: TM-13-04
Module / Luồng: Quản lý đơn
Tên Test Case: Chặn chuyển ngược trạng thái đơn hàng đã hoàn thành hoặc đã hủy
Điều kiện tiên quyết: Có đơn hàng đang ở trạng thái Đã hoàn thành hoặc Đã hủy.
Các bước thực hiện:
1. Mở chi tiết đơn hàng đã hoàn thành/đã hủy.
2. Thử chuyển trạng thái đơn ngược lại thành Chờ xác nhận hoặc Đang giao.
Kết quả mong đợi: Hệ thống vô hiệu hóa tùy chọn chuyển ngược trạng thái hoặc hiển thị thông báo lỗi không cho phép cập nhật sai quy trình.

--------------------------------------------------

Test Case ID: TM-13-05
Module / Luồng: Quản lý đơn
Tên Test Case: Hủy đơn hàng từ phía quản trị và hoàn lại số lượng tồn kho
Điều kiện tiên quyết: Có đơn hàng ở trạng thái Chờ xác nhận (ví dụ: đặt 2 sản phẩm A, tồn kho hiện tại là 10).
Các bước thực hiện:
1. Mở chi tiết đơn hàng, chọn trạng thái Đã hủy, nhập lý do hủy và xác nhận.
2. Kiểm tra lại số lượng tồn kho của sản phẩm A trong mục Quản lý sản phẩm.
Kết quả mong đợi: Đơn hàng chuyển sang trạng thái Đã hủy và số lượng tồn kho của sản phẩm A được cộng hoàn lại đúng bằng 12.
