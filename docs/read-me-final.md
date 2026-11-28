# GIỚI THIỆU WEBSITE THƯƠNG MẠI ĐIỆN TỬ SÁCH SINH VIÊN

## 1. Giới thiệu website

Website Sách Sinh Viên là một hệ thống thương mại điện tử được xây dựng nhằm cung cấp nền tảng mua bán sách trực tuyến dành cho sinh viên và những người có nhu cầu tìm kiếm, tham khảo và mua sách.

Website giúp người dùng dễ dàng tìm kiếm sách theo tên sách, tác giả hoặc môn học. Ngoài ra, người dùng có thể khám phá sách theo danh mục, xem thông tin chi tiết của từng cuốn sách, thêm sách vào giỏ hàng và tiến hành đặt hàng.

Hệ thống còn cung cấp chức năng quản trị dành cho Admin, giúp quản lý sản phẩm, danh mục sách và các hoạt động liên quan đến website.

Mục tiêu của website là xây dựng một môi trường mua sách trực tuyến thuận tiện, dễ sử dụng, giúp sinh viên tiết kiệm thời gian tìm kiếm và lựa chọn tài liệu học tập.

## 2. Các chức năng chính của website

### 2.1. Chức năng dành cho khách hàng

- Trang chủ: Hiển thị thông tin giới thiệu website, danh mục sách và các sách mới cập nhật.
- Tìm kiếm sách: Cho phép tìm kiếm sách theo tên sách, tác giả hoặc môn học.
- Danh mục sách: Hiển thị danh sách sách và hỗ trợ lọc theo danh mục.
- Lọc và sắp xếp: Hỗ trợ lọc sách theo từ khóa, danh mục, khoảng giá và sắp xếp theo thời gian.
- Chi tiết sách: Hiển thị thông tin về sách như tên sách, tác giả, giá bán và các thông tin liên quan.
- Giỏ hàng: Cho phép thêm sách vào giỏ hàng, cập nhật số lượng và xóa sách khỏi giỏ hàng.
- Đặt hàng: Cho phép người dùng tiến hành đặt hàng sau khi kiểm tra giỏ hàng.
- Đăng ký tài khoản: Người dùng có thể tạo tài khoản mới bằng cách nhập họ tên, email và mật khẩu.
- Đăng nhập: Người dùng đăng nhập bằng email và mật khẩu để sử dụng các chức năng dành cho tài khoản.

### 2.2. Chức năng dành cho quản trị viên (Admin)

- Trang quản trị: Hiển thị giao diện quản trị sau khi Admin đăng nhập và vượt qua lớp bảo vệ quyền truy cập.
- Quản lý sản phẩm: Hỗ trợ quản lý các sản phẩm sách trên website.
- Quản lý danh mục: Hỗ trợ quản lý các danh mục sách.
- Đăng xuất: Cho phép Admin kết thúc phiên làm việc.

## 3. Công nghệ sử dụng

### 3.1. Công nghệ Backend

- PHP: Ngôn ngữ lập trình phía máy chủ, xử lý các yêu cầu từ người dùng và thực hiện các nghiệp vụ của website.
- Laravel: Framework PHP được sử dụng để xây dựng hệ thống website. Laravel hỗ trợ tổ chức mã nguồn theo mô hình MVC, quản lý định tuyến, xử lý dữ liệu và bảo vệ các chức năng quản trị.
- Middleware: Được sử dụng để kiểm tra quyền truy cập vào các trang quản trị. Trong website có lớp bảo vệ CheckAdmin Middleware, giúp kiểm tra quyền Admin trước khi cho phép truy cập trang quản trị.

### 3.2. Công nghệ Frontend

- HTML: Xây dựng cấu trúc các trang web như trang chủ, danh sách sách, giỏ hàng, đăng nhập và đăng ký.
- CSS: Thiết kế giao diện, bố cục, màu sắc, khoảng cách và các thành phần hiển thị trên website.
- JavaScript: Có thể sử dụng để hỗ trợ các tương tác phía người dùng như cập nhật giao diện và xử lý các thao tác trên trang web.

### 3.3. Cơ sở dữ liệu

- MySQL: Hệ quản trị cơ sở dữ liệu quan hệ được sử dụng để lưu trữ thông tin của website.
- Laravel Migration: Quản lý cấu trúc các bảng trong cơ sở dữ liệu thông qua các tệp migration.

### 3.4. Công cụ phát triển

- Composer: Công cụ quản lý các thư viện và gói phụ thuộc của dự án PHP/Laravel.
- Laravel Artisan: Công cụ dòng lệnh hỗ trợ thực hiện các tác vụ phát triển và quản lý ứng dụng Laravel.

## 4. Cấu trúc cơ sở dữ liệu

Cơ sở dữ liệu của website có tên là thuong_mai_dien_tu.

Dựa trên cấu trúc cơ sở dữ liệu, hệ thống có các bảng sau:

- users: Lưu thông tin tài khoản người dùng.
- products: Lưu thông tin các sản phẩm sách.
- categories: Lưu thông tin danh mục sách.
- cart_items: Lưu các sản phẩm trong giỏ hàng.
- orders: Lưu thông tin đơn hàng.
- order_items: Lưu chi tiết các sản phẩm thuộc đơn hàng.
- password_resets: Hỗ trợ chức năng đặt lại mật khẩu.
- personal_access_tokens: Quản lý token xác thực truy cập.
- failed_jobs: Lưu thông tin các tác vụ nền bị lỗi.
- migrations: Quản lý lịch sử migration của Laravel.

### Mối quan hệ giữa các bảng

Một danh mục có thể chứa nhiều sản phẩm sách.

Một người dùng có thể tạo nhiều đơn hàng.

Một đơn hàng có thể chứa nhiều sản phẩm.

Bảng order_items lưu thông tin chi tiết sản phẩm trong từng đơn hàng.

Bảng cart_items lưu thông tin sách và số lượng sách mà người dùng thêm vào giỏ hàng.

## 5. Quy trình hoạt động của website

Bước 1: Người dùng đăng ký tài khoản hoặc đăng nhập vào hệ thống.

Bước 2: Người dùng tìm kiếm và lựa chọn sách
