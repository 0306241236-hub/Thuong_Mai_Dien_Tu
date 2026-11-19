## AI-01: Kiểm tra chuẩn hóa và quan hệ sơ đồ ERD (erd-v1)

- **Ngày thực hiện:** 09/11/2026
- **Người thực hiện:** Nguyễn Minh Khang (TV4 - Phụ trách CSDL & Backend)
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

  # AI-03: Khởi tạo Database Migration & Seeder cho hệ thống Book Store

- **Ngày thực hiện:** 11/11/2026
---

## 1. Mục tiêu công việc
- Cài đặt môi trường Laravel từ khung dự án của nhóm và kết nối với cơ sở dữ liệu MySQL (`book_store_db`) trên XAMPP.
- Xây dựng 6 tệp Laravel Migration chuẩn hóa theo thiết kế ERD v2 (`users`, `categories`, `products`, `cart_items`, `orders`, `order_items`) đảm bảo đúng kiểu dữ liệu, khóa ngoại và đánh chỉ mục (index).
- Viết `DatabaseSeeder` khởi tạo dữ liệu mẫu phục vụ kiểm thử toàn bộ luồng nghiệp vụ cho Backend và Frontend.

---

## 2. Tóm tắt các Prompt đã sử dụng
1. **Cấu hình môi trường & kết nối CSDL:** *"Hướng dẫn cấu hình tệp `.env`, sinh khóa ứng dụng Laravel và kết nối với cơ sở dữ liệu MySQL trên XAMPP."*
2. **Tạo mã nguồn 6 bảng Migration theo ERD v2:** *"Viết mã nguồn 6 tệp Laravel Migration cho hệ thống bán sách gồm: `users`, `categories`, `products`, `cart_items`, `orders`, `order_items` với kiểu tiền tệ `DECIMAL(12,2)`, ràng buộc khóa ngoại `onDelete('cascade')` và các index tối ưu truy vấn."*
3. **Viết Seeder dữ liệu mẫu tiếng Việt:** *"Viết `DatabaseSeeder.php` sử dụng Query Builder (`DB::table`) để nạp 5 danh mục, 30 đầu sách (bao gồm sách hết hàng `stock = 0`), 11 tài khoản (1 Admin, 10 Customer có 1 tài khoản `locked`) và 10 đơn hàng chia đều 4 trạng thái."*
4. **Quy trình kiểm thử & bàn giao Git:** *"Kiểm tra thứ tự chạy migration, xuất tệp `book_store_db.sql` trên phpMyAdmin và hướng dẫn tạo Pull Request từ `feature/database` vào nhánh `BackEnd`."*

---

## 3. Kết quả từ AI
AI đã hỗ trợ sinh mã nguồn và cấu trúc hoàn chỉnh cho 7 tệp trong thư mục `database/`:
- `database/migrations/2014_10_12_000000_create_users_table.php`
- `database/migrations/2026_11_18_161127_create_categories_table.php`
- `database/migrations/2026_11_18_161140_create_products_table.php`
- `database/migrations/2026_11_18_161150_create_cart_items_table.php`
- `database/migrations/2026_11_18_161322_create_orders_table.php`
- `database/migrations/2026_11_18_161330_create_order_items_table.php`
- `database/seeders/DatabaseSeeder.php`

---

## 4. Kiểm tra, chỉnh sửa & xác minh thực tế của thành viên
- **Đồng bộ tên CSDL và cột khóa ngoại với TV2:** Đối chiếu thông tin trao đổi trong nhóm để thống nhất tên database là `book_store_db` (bảng mã `utf8mb4_unicode_ci`), đồng thời giữ chuẩn tên bảng `products` và cột khóa ngoại `product_id` thay vì `book_id` để khớp với ERD v2.
- **Bảo toàn bảng hệ thống Laravel:** Kiểm tra và giữ nguyên 3 tệp migration mặc định (`password_resets`, `failed_jobs`, `personal_access_tokens`) nhằm tránh ảnh hưởng đến tính năng xác thực đăng nhập của khung dự án.
- **Kiểm thử dữ liệu trên XAMPP:** Chạy thành công lệnh `php artisan migrate:fresh --seed`, kiểm tra trực tiếp cấu trúc bảng, khóa ngoại và dữ liệu mẫu trên phpMyAdmin, sau đó xuất tệp `book_store_db.sql` bàn giao cho thành viên Backend.
- **Tuân thủ quy trình Git:** Kiểm tra `git status` để loại trừ tệp `.env`, đẩy mã nguồn lên nhánh `feature/database` và điều chỉnh nhánh đích (`base`) của Pull Request sang `BackEnd`.

---

## 5. Đánh giá hiệu quả
- **Mức độ hỗ trợ của AI:** ~75% (hỗ trợ sinh nhanh bộ khung migration và dữ liệu mẫu phong phú, giúp rút ngắn thời gian nhập liệu thủ công).
- **Phần tự chủ của thành viên:** 100% mã nguồn được rà soát từng cột dữ liệu, kiểm thử thực tế trên MySQL/phpMyAdmin và đối chiếu chuẩn xác với các thành viên trong nhóm trước khi nộp Pull Request.

# AI-04 + AI-05: Xây dựng chức năng Quản lý danh mục sản phẩm (TM-11)

- **Ngày thực hiện:** 12/11/2026
- **Thẻ Trello:** TM-11 (Quản lý danh mục)
- **Nhánh làm việc:** `feature/TM-11-quan-ly-danh-muc` (Pull Request vào `BackEnd`)

---

## 1. Mục tiêu công việc
- Xây dựng trọn bộ chức năng CRUD (Xem danh sách, Thêm mới, Chỉnh sửa, Xóa) cho danh mục sản phẩm trên trang quản trị Admin.
- Đảm bảo đầy đủ các tiêu chí chấp nhận trên Trello: tự động tạo `slug` chuẩn hóa từ tên danh mục, kiểm tra dữ liệu đầu vào (bắt buộc nhập, chống trùng tên danh mục) và **chặn xóa danh mục nếu đang chứa sản phẩm**.
- Thiết kế bộ giao diện quản trị trực quan bằng Bootstrap 5 và viết kịch bản kiểm thử tự động (`CategoryManagementTest`) để xác minh toàn bộ luồng nghiệp vụ.

---

## 2. Tóm tắt các Prompt đã sử dụng
1. **Khởi tạo Model & Controller xử lý nghiệp vụ TM-11:** *"Viết mã nguồn Eloquent Model `Category`, `Product` với quan hệ `hasMany`/`belongsTo` và `Admin\CategoryController` đầy đủ CRUD, tự động sinh `slug` bằng `Str::slug()`, validate trùng tên tiếng Việt và chặn xóa nếu danh mục đang có sản phẩm."*
2. **Đăng ký Route & Xây dựng giao diện Blade:** *"Khai báo `Route::resource` cho trang quản trị danh mục và viết 3 tệp giao diện Blade (`index.blade.php`, `create.blade.php`, `edit.blade.php`) sử dụng Bootstrap 5 hiển thị số lượng sách trong từng danh mục và thông báo lỗi/thành công."*
3. **Viết kiểm thử tự động (Feature Test):** *"Viết `CategoryManagementTest` kiểm thử tự động cả 2 kịch bản: thêm/sửa/xóa danh mục rỗng thành công và hệ thống từ chối xóa danh mục đang có sách trực thuộc."*

---

## 3. Kết quả từ AI
AI đã hỗ trợ sinh khung mã nguồn cho 8 tệp thuộc tính năng Quản lý danh mục:
- **Models:**
  - `app/Models/Category.php`
  - `app/Models/Product.php`
- **Controller & Routes:**
  - `app/Http/Controllers/Admin/CategoryController.php`
  - `routes/web.php`
- **Giao diện (Blade Views):**
  - `resources/views/admin/categories/index.blade.php`
  - `resources/views/admin/categories/create.blade.php`
  - `resources/views/admin/categories/edit.blade.php`
- **Kiểm thử (Feature Test):**
  - `tests/Feature/CategoryManagementTest.php`

---

## 4. Kiểm tra, chỉnh sửa & xác minh thực tế của thành viên
- **Chuẩn hóa mã nguồn Route:** Rà soát và sắp xếp lại vị trí khai báo `use App\Http\Controllers\Admin\CategoryController;` lên đầu tệp `routes/web.php` theo đúng chuẩn PSR-12 của Laravel[cite: 6].
- **Kiểm thử giao diện trực tiếp trên trình duyệt:** Tạo đúng cấu trúc thư mục `resources/views/admin/categories/`[cite: 8], chạy máy chủ `php artisan serve` và kiểm tra trực tiếp tại đường dẫn `http://127.0.0.1:8000/admin/categories` với bộ dữ liệu mẫu của `book_store_db`.
- **Chạy kiểm thử tự động PHPUnit:** Thực thi lệnh `php artisan test --filter CategoryManagementTest` và đạt kết quả **PASS 2/2 test cases** (`admin can crud empty category` và `cannot delete category that contains products`)[cite: 10].
- **Khôi phục dữ liệu mẫu sau kiểm thử:** Do trait `RefreshDatabase` làm sạch dữ liệu khi chạy test, thành viên đã chạy lại `php artisan migrate:fresh --seed` để nạp lại đầy đủ 5 danh mục, 30 đầu sách, 11 tài khoản và 10 đơn hàng mẫu trước khi đẩy code.

---

## 5. Đánh giá hiệu quả
- **Mức độ hỗ trợ của AI:** ~75% (hỗ trợ sinh nhanh bộ khung Controller, giao diện Bootstrap 5 và các ca kiểm thử PHPUnit, giúp rút ngắn đáng kể thời gian lập trình lặp lại).
- **Phần tự chủ của thành viên:** 100% mã nguồn được rà soát chuẩn hóa, tổ chức đúng cấu trúc thư mục dự án, chạy kiểm thử thực tế trên cả trình duyệt lẫn PHPUnit và khôi phục nguyên vẹn cơ sở dữ liệu mẫu trước khi tạo Pull Request.

### [AI-06] Hoàn thiện kiểm tra trùng slug, phân quyền Admin và Unit Test (TM-11)
- **Công cụ:** Gemini
- **Mục đích:** Bổ sung hàm sinh slug tự động tránh trùng lặp (`generateUniqueSlug`) trong `CategoryService`, đăng ký alias middleware `admin` (`CheckAdmin`) trong `Kernel.php` để bảo vệ nhóm route `/admin/categories`, và cập nhật giả lập tài khoản Admin trong `CategoryManagementTest`.
- **Kết quả kiểm thử:** Chạy `php artisan test --filter CategoryManagementTest` đạt **2/2 PASS** (`admin can crud empty category`, `cannot delete category that contains products`).