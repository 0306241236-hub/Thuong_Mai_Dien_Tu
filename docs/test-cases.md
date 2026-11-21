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
