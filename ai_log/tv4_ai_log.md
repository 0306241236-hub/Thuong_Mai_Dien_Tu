## AI-01: Kiểm tra chuẩn hóa và quan hệ sơ đồ ERD (erd-v1)

- **Ngày thực hiện:** 09/11/2026
- **Người thực hiện:** Nguyễn Minh Khang
- **Công cụ AI sử dụng:** Gemini
- **Tác vụ liên quan:** `[DB] ERD` — Rà soát thiết kế cơ sở dữ liệu bản phác (`erd-v1.png`)

### 1. Câu lệnh (Prompt) đã sử dụng
> "Đây là danh sách 6 bảng và cột của tôi:
> 1. `users (id, name, email, password)`
> 2. `categories (id, name, description)`
> 3. `products (id, category_id, name, price, stock)`
> 4. `cart_items (id, user_id, product_id, quantity)`
> 5. `orders (id, user_id, total_price, status, created_at)`
> 6. `order_items (id, order_id, product_id, quantity, price_at_purchase)`
>
> Hãy chỉ ra vi phạm chuẩn hóa và quan hệ thiếu."

### 2. Tóm tắt phản hồi của AI
- **Về chuẩn hóa:** Cấu trúc 6 bảng cơ bản đạt chuẩn 3NF; tuy nhiên cột `orders.total_price` là thuộc tính suy diễn từ `order_items`, cần đảm bảo đồng bộ chặt chẽ ở tầng xử lý code để tránh sai lệch tổng tiền.
- **Về ràng buộc và cột thiếu:** Thiếu ràng buộc `UNIQUE` cho `users.email` và cặp `(user_id, product_id)` trong `cart_items`; thiếu các cột phục vụ nghiệp vụ web như `users.role`, `users.phone`, `orders.shipping_address` và `products.image_url`.
- **Về quan hệ:** Gợi ý tách thêm bảng `carts` làm bảng cha của `cart_items` và bổ sung các bảng riêng cho thanh toán, vận chuyển.

### 3. Đánh giá và hướng xử lý (Kiểm chứng của thành viên)
- **Ý kiến hữu ích được tiếp thu (áp dụng nâng cấp lên `erd-v2.png` vào Ngày 2):**
  1. Bổ sung ràng buộc `UNIQUE` cho cột `email` (bảng `users`) và cặp `(user_id, product_id)` (bảng `cart_items`) để tránh trùng lặp tài khoản hoặc tách nhiều dòng cho cùng một sản phẩm trong giỏ hàng.
  2. Bổ sung các cột nghiệp vụ cần thiết cho giao diện và quy trình đặt hàng gồm: `role`, `phone`, `address` (bảng `users`); `shipping_address` (bảng `orders`); `image_url`, `description` (bảng `products`).
- **Điểm AI gợi ý sai / dư thừa so với phạm vi đồ án (bác bỏ):**
  - AI đề xuất tách thêm bảng `carts` (quản lý phiên giỏ hàng) cùng các bảng phụ cho thanh toán và đơn vị vận chuyển. Đề xuất này **dư thừa** vì phạm vi đồ án giới hạn cứng trong **6 bảng**, đồng thời mỗi người dùng chỉ sở hữu một giỏ hàng duy nhất nên việc nối khóa ngoại `user_id` trực tiếp vào `cart_items` như thiết kế hiện tại đã tối ưu và gọn nhẹ hơn.
  ## AI-02: Kiểm tra chuẩn 3NF (erd-v2) và tạo tài liệu đặc tả bảng (mo-ta-bang.md)

- **Ngày thực hiện:** 10/11/2026 
- **Người thực hiện:** Nguyễn Minh Khang
- **Công cụ AI sử dụng:** Gemini
- **Tác vụ liên quan:** `[DB] ERD` — Hoàn thiện sơ đồ chuẩn 3NF (`erd-v2.png`) và viết đặc tả chi tiết 6 bảng (`docs/database/mo-ta-bang.md`)

### 1. Câu lệnh (Prompt) đã sử dụng
> "Tôi đã cập nhật sơ đồ ERD lên phiên bản v2 với 6 bảng và các cột bổ sung sau:
> 1. `users (id, name, email [UNIQUE], password, phone, address, role)`
> 2. `categories (id, name, description)`
> 3. `products (id, category_id, name, price, stock, image_url, description)`
> 4. `cart_items (id, user_id, product_id, quantity)` — có ràng buộc `UNIQUE(user_id, product_id)`
> 5. `orders (id, user_id, total_price, status, shipping_address, created_at)`
> 6. `order_items (id, order_id, product_id, quantity, price_at_purchase)`
>
> Hãy kiểm tra lại xem thiết kế này đã đạt chuẩn 3NF hoàn toàn chưa, đồng thời xuất giúp tôi bảng đặc tả chi tiết (tên cột, kiểu dữ liệu, ràng buộc PK/FK/NOT NULL, mô tả) định dạng Markdown để lưu vào file `mo-ta-bang.md`."

### 2. Tóm tắt phản hồi của AI
- **Đánh giá chuẩn hóa (1NF, 2NF, 3NF):** AI xác nhận toàn bộ 6 bảng đã đạt chuẩn **3NF** (mỗi cột chỉ chứa giá trị đơn, không có phụ thuộc bộ phận hay phụ thuộc bắc cầu giữa các thuộc tính không khóa; địa chỉ giao hàng `shipping_address` lưu ở `orders` là hợp lý về mặt nghiệp vụ để giữ nguyên lịch sử đơn hàng khi khách đổi địa chỉ ở `users`).
- **Đề xuất đặc tả bảng (`mo-ta-bang.md`):** AI xuất ra 6 bảng đặc tả Markdown đầy đủ kiểu dữ liệu, khóa chính (`PK`), khóa ngoại (`FK`), giá trị mặc định (`DEFAULT`), đồng thời gợi ý đổi toàn bộ khóa chính `id` sang kiểu `UUID` và dùng kiểu `ENUM` cho cột `status` và `role`.

### 3. Đánh giá và hướng xử lý (Kiểm chứng của thành viên)
- **Ý kiến hữu ích được tiếp thu (đã đưa vào `erd-v2.png` và `mo-ta-bang.md`):**
  1. Giữ nguyên cột `shipping_address` độc lập trong bảng `orders` thay vì lấy động từ `users.address`, đảm bảo tính toàn vẹn lịch sử giao hàng khi người dùng cập nhật hồ sơ cá nhân.
  2. Tận dụng khung bảng Markdown của AI để trình bày rõ ràng các ràng buộc (`NOT NULL`, `UNIQUE`, `DEFAULT 0` cho `stock`, `DEFAULT 'pending'` cho `orders.status`) và quy tắc khóa ngoại (`ON DELETE RESTRICT` với `order_items` để tránh mất dữ liệu hóa đơn khi xóa sản phẩm), giúp TV2 (Backend) dễ dàng ánh xạ sang code.
- **Điểm AI gợi ý dư thừa / chưa phù hợp thực tế (đã chỉnh sửa lại):**
  - AI đề xuất chuyển toàn bộ khóa chính `id` từ `INT` sang `UUID` (`CHAR(36)`) và dùng kiểu `ENUM` cứng trong CSDL cho `orders.status`. Nhóm đã thống nhất **không áp dụng** vì `INT` tự tăng (`AUTO_INCREMENT`) gọn nhẹ, dễ truy vấn và đủ đáp ứng quy mô đồ án 6 bảng; đồng thời dùng `VARCHAR` cho `status` giúp TV2 linh hoạt thêm/sửa trạng thái đơn hàng ở tầng code mà không phải chạy lệnh sửa cấu trúc bảng CSDL.