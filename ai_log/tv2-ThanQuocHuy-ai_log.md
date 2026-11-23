# AI Log - Buổi 1
**Người thực hiện:** TV2 (Backend Lead)
**Nhiệm vụ:** Khởi tạo dự án, thiết lập kiến trúc 3 lớp và viết User Story.

## 1. Prompt đã sử dụng
**Prompt 1 (Kiến trúc 3 lớp):** 
> "So sánh cách tổ chức thư mục 3 lớp (Controller - Service - Repository) cho dự án Laravel 9 quy mô nhỏ. Hướng dẫn cách tạo và kiểm chứng với tài liệu chính thức của framework."

**Prompt 2 (Git & Môi trường):**
> "Cách xử lý lỗi Git 'entirely different commit histories' khi hợp nhất nhánh khởi tạo dự án với nhánh develop có sẵn trên Github."

## 2. Kết quả từ AI & Xác thực
- **Về kiến trúc 3 lớp:** AI xác nhận Laravel mặc định chỉ có Controller. Theo chuẩn thực tế, cần tự tạo thêm thư mục `app/Services` để chứa logic nghiệp vụ và `app/Repositories` để giao tiếp CSDL. Đã đối chiếu với tài liệu Laravel: Laravel không ép buộc cấu trúc, việc mở rộng thư mục `app` là hoàn toàn hợp lệ và chuẩn chuẩn auto-loading của Composer.
- **Về Git:** AI hướng dẫn sử dụng cờ `--allow-unrelated-histories` khi pull/merge để nối 2 nhánh không chung gốc lại với nhau.

## 3. Cách áp dụng vào dự án
- Đã chạy `php artisan make:controller` cho AuthController, OrderController.
- Đã tạo thủ công `app/Services/AuthService.php`, `OrderService.php`.
- Xử lý thành công lỗi Git và mở PR #9 để merge nhánh `feature/khung-du-an` vào `BackEnd`/`develop`.
- Dùng AI hỗ trợ viết chuẩn format User Story cho thẻ TM-04 và TM-06 trên Trello để đảm bảo đúng tiêu chí Acceptance Criteria.
