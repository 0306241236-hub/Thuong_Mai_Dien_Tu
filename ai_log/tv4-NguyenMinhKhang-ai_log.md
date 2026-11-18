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