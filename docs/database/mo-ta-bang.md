# Đặc tả Cơ sở dữ liệu (Chuẩn 3NF)

## 1. Quy tắc chuẩn hóa & Thiết kế nghiệp vụ
- **Chuẩn 3NF:** Mọi thuộc tính không khóa đều phụ thuộc trực tiếp vào khóa chính, không có phụ thuộc bắc cầu.
- **Vì sao `order_items` lưu `price_at_purchase`:** Giá sách trong bảng `products` thường xuyên biến động (tăng giá, giảm giá, khuyến mãi). Nếu `order_items` không lưu lại đơn giá tại thời điểm khách chốt đơn mà tham chiếu trực tiếp sang `products.price`, toàn bộ lịch sử doanh thu và hóa đơn cũ sẽ bị sai lệch mỗi khi admin cập nhật giá sách.
- **Kiểu dữ liệu tiền tệ:** Sử dụng `DECIMAL(12,2)` thay cho `FLOAT/DOUBLE` để tránh sai số làm tròn số thực.

## 2. Danh sách chỉ mục (Indexes) tối ưu truy vấn
- `products(name)`: Tăng tốc độ tìm kiếm sách theo tên ở thanh tìm kiếm.
- `products(category_id)`: Tăng tốc độ lọc danh sách sách theo từng danh mục.
- `orders(user_id, status)`: Tối ưu truy vấn lịch sử đơn hàng của một khách hàng kết hợp lọc theo trạng thái đơn.

## 3. Chi tiết các bảng dữ liệu

### 3.1. Bảng `users` (Người dùng)
| Cột | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, AUTO_INCREMENT | Mã người dùng |
| `full_name` | VARCHAR(100) | NOT NULL | Họ và tên |
| `email` | VARCHAR(150) | UNIQUE, NOT NULL | Email đăng nhập (duy nhất) |
| `password` | VARCHAR(255) | NOT NULL | Mật khẩu đã băm (bcrypt) |
| `phone` | VARCHAR(20) | NULL | Số điện thoại |
| `address` | TEXT | NULL | Địa chỉ mặc định |
| `role` | VARCHAR(20) | NOT NULL, DEFAULT 'customer' | Vai trò (`admin` / `customer`) |
| `status` | VARCHAR(20) | NOT NULL, DEFAULT 'active' | Trạng thái (`active` / `locked`) |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Thời điểm tạo tài khoản |

### 3.2. Bảng `categories` (Danh mục sách)
| Cột | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, AUTO_INCREMENT | Mã danh mục |
| `name` | VARCHAR(100) | NOT NULL | Tên danh mục |
| `slug` | VARCHAR(120) | UNIQUE, NOT NULL | Đường dẫn thân thiện SEO |
| `description` | TEXT | NULL | Mô tả danh mục |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Thời điểm tạo |

### 3.3. Bảng `products` (Sách)
| Cột | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, AUTO_INCREMENT | Mã sách |
| `category_id` | INT | FK -> `categories.id`, NOT NULL | Thuộc danh mục nào |
| `name` | VARCHAR(200) | NOT NULL, INDEX | Tên sách |
| `author` | VARCHAR(100) | NULL | Tác giả |
| `publisher` | VARCHAR(100) | NULL | Nhà xuất bản |
| `price` | DECIMAL(12,2) | NOT NULL | Giá bán hiện tại |
| `stock` | INT | NOT NULL, DEFAULT 0, CHECK (`stock >= 0`) | Số lượng tồn kho (không âm) |
| `description` | TEXT | NULL | Giới thiệu nội dung sách |
| `image_url` | VARCHAR(255) | NULL | Đường dẫn ảnh bìa |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Thời điểm thêm sách |

### 3.4. Bảng `cart_items` (Giỏ hàng)
| Cột | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, AUTO_INCREMENT | Mã mục giỏ hàng |
| `user_id` | INT | FK -> `users.id`, NOT NULL | Chủ giỏ hàng |
| `product_id` | INT | FK -> `products.id`, NOT NULL | Sách được thêm vào giỏ |
| `quantity` | INT | NOT NULL, DEFAULT 1, CHECK (`quantity > 0`) | Số lượng mua |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Thời điểm thêm vào giỏ |

### 3.5. Bảng `orders` (Đơn hàng)
| Cột | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, AUTO_INCREMENT | Mã đơn hàng |
| `user_id` | INT | FK -> `users.id`, NOT NULL, INDEX | Khách hàng đặt mua |
| `receiver_name` | VARCHAR(100) | NOT NULL | Tên người nhận hàng |
| `receiver_phone` | VARCHAR(20) | NOT NULL | SĐT người nhận hàng |
| `shipping_address` | TEXT | NOT NULL | Địa chỉ giao hàng |
| `total_amount` | DECIMAL(12,2) | NOT NULL | Tổng tiền đơn hàng |
| `payment_method` | VARCHAR(50) | NOT NULL, DEFAULT 'COD' | Hình thức thanh toán |
| `status` | VARCHAR(30) | NOT NULL, DEFAULT 'pending', INDEX | Trạng thái (`pending`, `shipping`, `completed`, `cancelled`) |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Thời điểm đặt hàng |

### 3.6. Bảng `order_items` (Chi tiết đơn hàng)
| Cột | Kiểu dữ liệu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | INT | PK, AUTO_INCREMENT | Mã chi tiết đơn |
| `order_id` | INT | FK -> `orders.id`, NOT NULL | Thuộc đơn hàng nào |
| `product_id` | INT | FK -> `products.id`, NOT NULL | Sách được đặt |
| `quantity` | INT | NOT NULL, CHECK (`quantity > 0`) | Số lượng đặt |
| `price_at_purchase` | DECIMAL(12,2) | NOT NULL | Đơn giá sách tại thời điểm mua |
```[cite: 15]