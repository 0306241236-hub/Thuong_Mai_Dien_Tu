# NHẬT KÝ SỬ DỤNG AI (AI LOG) – TV2 (BACKEND LEAD)

- **Người thực hiện:** Thân Quốc Huy – TV2 (Backend Lead)
- **Dự án:** Website Thương mại Điện tử Bán sách (`Thuong_Mai_Dien_Tu`)
- **Phạm vi phụ trách:** Kiến trúc 3 lớp, Xác thực & Phân quyền (`TM-04`), Đặt hàng Transaction & Chống bán vượt tồn kho (`TM-06`, `TM-NFR1`), Kiểm thử tự động PHPUnit (`TEST`), Báo cáo Chương 5 & Chương 6.

---

## Buổi 1: Khởi tạo dự án, thiết lập kiến trúc 3 lớp và viết User Story

### 1. Prompt đã sử dụng
- **Prompt 1 (Kiến trúc 3 lớp):**
  > "So sánh cách tổ chức thư mục 3 lớp (Controller - Service - Repository) cho dự án Laravel 9 quy mô nhỏ. Hướng dẫn cách tạo và kiểm chứng với tài liệu chính thức của framework."
- **Prompt 2 (Git & Môi trường):**
  > "Cách xử lý lỗi Git 'entirely different commit histories' khi hợp nhất nhánh khởi tạo dự án với nhánh develop có sẵn trên GitHub."

### 2. Kết quả từ AI & Xác thực
- **Về kiến trúc 3 lớp:** AI xác nhận Laravel mặc định chỉ có Controller. Theo chuẩn thực tế, cần tự tạo thêm thư mục `app/Services` để chứa logic nghiệp vụ và `app/Repositories` để giao tiếp CSDL. Đã đối chiếu với tài liệu Laravel: Laravel không ép buộc cấu trúc, việc mở rộng thư mục `app` là hoàn toàn hợp lệ và chuẩn auto-loading của Composer.
- **Về Git:** AI hướng dẫn sử dụng cờ `--allow-unrelated-histories` khi pull/merge để nối 2 nhánh không chung gốc lại với nhau.

### 3. Cách áp dụng vào dự án
- Chạy `php artisan make:controller` để tạo `AuthController`, `OrderController`.
- Tạo thủ công các lớp nghiệp vụ `app/Services/AuthService.php` và `app/Services/OrderService.php`.
- Xử lý thành công lỗi Git và mở PR #9 để merge nhánh `feature/khung-du-an` vào `BackEnd/develop`.
- Dùng AI hỗ trợ viết chuẩn format User Story cho thẻ `TM-04` và `TM-06` trên Trello để đảm bảo đúng tiêu chí Acceptance Criteria.

---

## Buổi 2: Hoàn thiện Xác thực, Phân quyền Admin (`TM-04`) và Dữ liệu mẫu

### 1. Prompt đã sử dụng
- **Prompt 1 (Xác thực & Băm mật khẩu):**
  > "Viết hàm register và login trong AuthService của Laravel sử dụng Bcrypt để băm mật khẩu, kiểm tra trạng thái tài khoản bị khóa (locked) và ném ngoại lệ rõ ràng để Controller bắt bằng try-catch."
- **Prompt 2 (Phân quyền & Dữ liệu mẫu):**
  > "Cách viết Middleware kiểm tra quyền admin trong Laravel để chặn user thường truy cập các route /admin. Sinh dữ liệu mẫu thực tế cho DatabaseSeeder gồm 5 danh mục, 30 sách tiếng Việt và 11 tài khoản (1 admin, 10 khách hàng)."

### 2. Kết quả từ AI & Xác thực
- **Về bảo mật mật khẩu & ngoại lệ:** AI hướng dẫn dùng `Hash::make()` (thuật toán Bcrypt tự động sinh salt) khi lưu mật khẩu và `Hash::check()` / `Auth::attempt()` khi đăng nhập. Đã kiểm tra thực tế trong bảng `users` của MySQL để xác nhận chuỗi mật khẩu lưu dưới dạng mã băm 60 ký tự, không lưu văn bản thô.
- **Về Middleware & Seeder:** AI sinh khung code sử dụng tên cột mặc định `name` và `is_admin`. Khi đối chiếu lại file migration của nhóm, phát hiện CSDL dùng cột `full_name`, `role` (`'admin'`/`'customer'`) và `status` (`'active'`/`'locked'`), nên đã chỉnh sửa lại toàn bộ code cho khớp với schema thực tế.

### 3. Cách áp dụng vào dự án
- Hoàn thiện `app/Services/AuthService.php` và bọc `try-catch` xử lý lỗi thân thiện trong `AuthController.php`.
- Tạo middleware `CheckAdmin` và gắn vào nhóm route `/admin` trong `routes/web.php`.
- Hoàn thiện `database/seeders/DatabaseSeeder.php` (có 2 sách `stock = 0` và tài khoản `khach10@bookstore.vn` trạng thái `locked` để phục vụ kiểm thử), chạy `php artisan migrate:fresh --seed` và kiểm tra đăng nhập thực tế trên trình duyệt.

---

## Buổi 3: Đặt hàng trong Transaction (`TM-06`) và Chống bán vượt tồn kho (`TM-NFR1`)

### 1. Prompt đã sử dụng
- **Prompt 1 (Transaction đặt hàng):**
  > "Hướng dẫn sử dụng DB::transaction() trong Laravel cho nghiệp vụ đặt hàng gồm 3 bước: tạo bản ghi orders, lưu chi tiết order_items và trừ tồn kho products.stock sao cho tự động rollback khi có sản phẩm hết hàng."
- **Prompt 2 (Chống tranh chấp đồng thời):**
  > "Giải thích hiện tượng Race Condition khi 2 người dùng đặt mua cùng lúc cuốn sách cuối cùng (stock = 1) và cách dùng khóa dòng trong MySQL/Laravel để ngăn tồn kho bị âm."

### 2. Kết quả từ AI & Xác thực
- **Về cơ chế Rollback:** AI cung cấp cú pháp `DB::transaction(function () { ... })` tự động hoàn tác mọi truy vấn nếu có `Exception` phát sinh. Để kiểm chứng thực tế thay vì chỉ tin vào lý thuyết, tôi đã chủ động chèn một dòng `throw new \Exception('Test rollback')` ngay sau lệnh `Order::create()` và kiểm tra MySQL, xác nhận không có bản ghi đơn hàng rác nào bị lưu lại.
- **Về khóa bi quan (Pessimistic Locking):** AI giải thích cơ chế `lockForUpdate()` (tương đương `SELECT ... FOR UPDATE` trong InnoDB) giúp khóa dòng sản phẩm đang xử lý cho đến khi transaction kết thúc, buộc phiên giao dịch thứ hai phải chờ phiên thứ nhất cập nhật xong tồn kho mới được đọc tiếp.

### 3. Cách áp dụng vào dự án
- Cài đặt hoàn chỉnh phương thức `OrderService::placeOrder()` kết hợp `DB::transaction()` và `Product::where('id', $id)->lockForUpdate()->first()`.
- Xây dựng luồng đặt hàng end-to-end từ form nhập thông tin nhận hàng (`OrderController`) đến trang xác nhận đặt hàng thành công (`status = 'pending'`).
- Commit bản sửa lỗi đồng thời `fix(TM-06): chong ban vuot ton kho` và cập nhật kết quả kiểm thử `TM-NFR1` lên thẻ Trello `[TM-06]`.

---

## Buổi 4: Kiểm thử tự động PHPUnit và Kiểm thử bảo mật chéo

### 1. Prompt đã sử dụng
- **Prompt 1 (Khung Unit Test):**
  > "Sinh khung kiểm thử PHPUnit (Feature/Unit Test) trong Laravel cho các kịch bản: (1) đăng ký email trùng bị từ chối, (2) đăng nhập tài khoản locked bị chặn, (3) đặt hàng thành công tạo đơn pending, (4) đặt vượt tồn kho bị rollback toàn bộ, (5) user thường truy cập /admin bị từ chối."
- **Prompt 2 (Test đồng thời):**
  > "Cách mô phỏng kịch bản đặt hàng liên tiếp/đồng thời vào 1 sản phẩm có stock = 1 trong PHPUnit để kiểm chứng tồn kho dừng ở 0 và không âm."

### 2. Kết quả từ AI & Xác thực
- **Sửa lỗi dữ liệu giả lập từ AI:** Code test do AI sinh ra ban đầu chạy bị lỗi `QueryException` và `AssertionError` do AI tự đặt giá trị trạng thái đơn hàng là `'Chờ xác nhận'` thay vì giá trị `ENUM` `'pending'` trong CSDL, đồng thời thiếu các trường bắt buộc như `receiver_phone`, `shipping_address`. Tôi đã đối chiếu lại cấu trúc bảng trong `database/migrations` để chuẩn hóa toàn bộ dữ liệu đầu vào cho các hàm test.
- **Xác thực bảo mật:** Tự thực hiện kiểm thử thủ công trên trình duyệt với các chuỗi nhập liệu SQL Injection cơ bản ở form đăng nhập/đặt hàng (xác nhận Eloquent ORM tự động bind tham số an toàn) và thử truy cập trực tiếp URL `/admin` bằng tài khoản khách hàng (xác nhận bị chặn hoàn toàn).

### 3. Cách áp dụng vào dự án
- Hoàn thiện 3 file kiểm thử trong thư mục `tests/`: `AuthServiceTest.php`, `OrderServiceTest.php`, `AdminAccessTest.php`.
- Chạy `php artisan test` và tinh chỉnh đến khi đạt **11/11 test cases PASS** (xanh toàn bộ).
- Đánh dấu hoàn thành checklist phần việc của TV2 trên thẻ `[TEST] Unit test` của Trello.

---

## Buổi 5: Giải quyết xung đột nhánh và Hoàn thiện Báo cáo Chương 5 & Chương 6

### 1. Prompt đã sử dụng
- **Prompt 1 (Xử lý xung đột Git):**
  > "Hướng dẫn nguyên tắc phân tích và xử lý xung đột (merge conflict) trên file routes/web.php và app/Services/AuthService.php khi gộp nhánh backend vào develop để giữ nguyên logic đã test mà không làm mất route chức năng của thành viên khác."
- **Prompt 2 (Tài liệu kỹ thuật Chương 5 & 6):**
  > "Chuyển đổi luồng xử lý của hàm OrderService::placeOrder() sử dụng DB::transaction và lockForUpdate sang dạng mã giả (pseudocode) chuẩn học thuật và phân tích độ phức tạp thời gian, không gian theo ký hiệu Big-O."

### 2. Kết quả từ AI & Xác thực
- **Về giải quyết xung đột Git:** AI hướng dẫn tách biệt quy tắc xử lý: với file nghiệp vụ lõi (`AuthService.php`), ưu tiên giữ bản code mới nhất đã vượt qua Unit Test; với file định tuyến chung (`routes/web.php`), giữ lại các route đã gắn middleware chuẩn của `backend` đồng thời rà soát hợp nhất các route mới của thành viên khác. Tôi đã đối chiếu từng cụm xung đột trong PR #36 và chạy lại `php artisan route:list` cùng `php artisan test` để đảm bảo không lỗi cú pháp.
- **Về tài liệu Chương 5 & 6:** AI hỗ trợ trình bày sơ đồ luồng Request qua 3 lớp và cấu trúc mã giả. Tôi đã rà soát lại toàn bộ tên lớp (`AuthController`, `OrderController`, `AuthService`, `OrderService`), tên phương thức và độ phức tạp `O(n)` (với `n` là số mặt hàng trong giỏ) để đảm bảo tài liệu khớp 100% với mã nguồn thực tế trên nhánh `develop`.

### 3. Cách áp dụng vào dự án
- Xử lý dứt điểm xung đột và gộp thành công PR #36 từ `backend` vào `develop` trên GitHub.
- Chuẩn hóa cấu hình `.env` (`APP_KEY`, kết nối MySQL `book_store`) và đồng bộ nhánh `develop` về máy.
- Hoàn thiện nội dung Chương 5 (Kiến trúc hệ thống 3 lớp), Chương 6 (Mẫu thiết kế, mã giả & độ phức tạp `placeOrder`), thực hiện đọc chéo Chương 6–7 và tổng hợp Nhật ký AI nộp cho TV1.

---

## Tổng kết Phản tư sử dụng AI (AI Reflection – TV2)

- **Hiệu quả đạt được:** Công cụ AI giúp tăng tốc rõ rệt ở giai đoạn dựng khung kiến trúc 3 lớp, tra cứu cú pháp giao dịch CSDL (`DB::transaction`, `lockForUpdate`), sinh khung kiểm thử PHPUnit và chuẩn hóa cách diễn đạt kỹ thuật cho báo cáo.
- **Hạn chế nhận diện được:** AI không tự nắm được các ràng buộc đặc thù của dự án nhóm (tên cột `full_name`, giá trị `ENUM` `'pending'`/`'locked'`, cấu trúc route chung của nhiều thành viên) nên mã nguồn gợi ý thường phát sinh lỗi nếu áp dụng nguyên văn.
- **Nguyên tắc kiểm soát chất lượng:** Mọi đoạn mã do AI đề xuất đều được đối chiếu lại với schema CSDL, chủ động tạo tình huống lỗi giả để kiểm chứng `rollback`, chạy qua bộ kiểm thử tự động `php artisan test` (11/11 PASS) và kiểm tra thủ công trên trình duyệt trước khi hợp nhất vào nhánh chung của nhóm.
