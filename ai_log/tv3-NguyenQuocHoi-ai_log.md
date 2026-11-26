# [AI Log] - Buổi 1
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Phác thảo wireframe 6 màn hình, chọn thư viện UI, viết User Story (TM-01, TM-02, TM-03) và thiết lập quy trình Git/PR.

## 1. Prompt đã sử dụng
**Prompt 1 (Bố cục giao diện & Wireframe):**
> "Gợi ý bố cục trang danh sách sách có tìm kiếm, lọc, phân trang, hiển thị tốt trên điện thoại cho website bán sách thương mại điện tử."

**Prompt 2 (Git & Quy trình làm việc nhóm):**
> "Hướng dẫn cách chuyển từ repo cũ sang repo mới Thuong_Mai_Dien_Tu, tạo nhánh docs/wireframe, đưa 6 ảnh wireframe vào thư mục docs/wireframes và mở Pull Request vào nhánh develop."

## 2. Kết quả từ AI & Xác thực
- **Về bố cục Wireframe & UI:** AI gợi ý sử dụng hệ thống lưới (Grid) 4 cột trên màn hình máy tính và thu gọn còn 2 cột trên điện thoại (360px), kết hợp thanh tìm kiếm ở Header và bộ lọc danh mục/khoảng giá thu gọn. Đã đối chiếu với yêu cầu đề tài để đảm bảo đủ các thành phần cho 6 màn hình (Trang chủ, Danh sách, Chi tiết sách, Giỏ hàng, Đặt hàng, Quản trị).
- **Về Git:** AI hướng dẫn quy trình clone repo mới về máy, đồng bộ nhánh `develop`, tách nhánh riêng `docs/wireframe` để tránh xung đột mã nguồn và tạo Pull Request chờ duyệt.

## 3. Cách áp dụng vào dự án
- Hoàn thiện 6 bản phác thảo wireframe và đẩy lên thư mục `docs/wireframes/` qua nhánh `docs/wireframe` (PR #32).
- Thống nhất chọn thư viện **Bootstrap 5** để xây dựng giao diện responsive nhanh và đồng bộ với cấu trúc Blade của Laravel.
- Tạo đầy đủ 3 thẻ User Story cho chức năng **TM-01** (Trang chủ), **TM-02** (Tìm kiếm, lọc sách) và **TM-03** (Chi tiết sản phẩm) trên bảng Trello của nhóm.

---

# [AI Log] - Buổi 2
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Dựng bộ khung layout chung (Header, Menu danh mục, Footer), tối ưu hiển thị responsive 360px và tạo trang mẫu tái sử dụng cho cả nhóm[cite: 20, 21].

## 1. Prompt đã sử dụng
**Prompt 1 (Cấu trúc Layout & Partial View trong Laravel Blade):**
> "Gợi ý cấu trúc component/partial view cho layout chung trong Laravel Blade sử dụng Bootstrap 5 gồm header (logo, ô tìm kiếm, giỏ hàng, đăng nhập), menu danh mục và footer, tự kiểm tra hiển thị tốt ở màn hình điện thoại 360px."

**Prompt 2 (Chuyển đổi thiết kế Wireframe sang mã giao diện):**
> "Dựa trên bản phác thảo wireframe Sách Sinh Viên (tông màu tối giản trắng - xám nhạt - đen than #3a3a3a), viết mã Blade cho file layout chính (app.blade.php), header, footer và trang mẫu trang chủ để các thành viên khác kế thừa bằng @extends."

## 2. Kết quả từ AI & Xác thực
- **Về tổ chức Partial View:** AI đề xuất tách nhỏ giao diện thành các tệp dùng chung trong `resources/views/partials/` (`header.blade.php`, `footer.blade.php`) và nhúng vào khung sườn chính `resources/views/layouts/app.blade.php` bằng chỉ thị `@include` và `@yield('content')`. Đã kiểm chứng trên tài liệu Blade của Laravel: cách chia này giúp tránh lặp mã HTML khi các thành viên phát triển các trang chức năng riêng biệt.
- **Về thiết kế & Responsive 360px:** AI sử dụng lớp `navbar-expand-lg` của Bootstrap 5 để tự động thu gọn thanh điều hướng thành nút menu trên màn hình hẹp và hệ thống lưới `row-cols-*` để chia cột linh hoạt. Đã tự kiểm tra thực tế trên trình duyệt bằng DevTools ở kích thước **360px**: giao diện hiển thị gọn, chữ không tràn khung ngang.

## 3. Cách áp dụng vào dự án
- Tạo đầy đủ bộ khung giao diện chung đồng bộ với 6 bản wireframe tại `resources/views/layouts/app.blade.php`, `resources/views/partials/header.blade.php` và `resources/views/partials/footer.blade.php`[cite: 20, 23].
- Xây dựng trang mẫu `resources/views/sample.blade.php` (kèm route kiểm thử `/layout-mau`) theo đúng thiết kế Màn hình 01 để làm mẫu tái sử dụng cho cả nhóm[cite: 21, 23].
- Đẩy mã nguồn lên nhánh `feature/layout` với commit `feat: layout chung header footer`, mở Pull Request vào `develop` và cập nhật tiến độ thẻ `[FE] Layout chung` trên Trello[cite: 21, 22].

---

# [AI Log] - Buổi 3
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Dựng trang chủ tĩnh trên layout chung (`TM-01`) và tách component thẻ sản phẩm dùng chung.

## 1. Prompt đã sử dụng
**Prompt 1 (Component thẻ sản phẩm & Giao diện Trang chủ):**
> "Gợi ý cấu trúc Blade partial thẻ sản phẩm (ảnh bìa, tên sách, tác giả, giá, link chi tiết) dùng Bootstrap 5 để tái sử dụng cho nhiều trang, và dựng giao diện trang chủ gồm khối tìm kiếm, danh mục sách, sách nổi bật, sách mới cập nhật hiển thị responsive ở 360px và 1366px."

**Prompt 2 (Cấu hình Route & Quản lý nhánh Git):**
> "Hướng dẫn cách cập nhật route trang chủ `/` trong `routes/web.php` mà không làm mất các route đăng nhập/đăng ký của nhóm, đồng thời tạo nhánh `feature/TM-01-trang-chu` kế thừa bộ layout đã làm."

## 2. Kết quả từ AI & Xác thực
- **Về giao diện & Responsive:** AI gợi ý tách file `product-card.blade.php` nhận biến `$book` và chia lưới Bootstrap 5 (`row-cols-1 row-cols-sm-2 row-cols-lg-4`). Đã tự tinh chỉnh lại màu sắc, bo góc, khung placeholder bìa sách khớp với Wireframe 01 và kiểm tra hiển thị thực tế trên trình duyệt ở **360px** (1 cột, không tràn ngang) và **1366px** (4 cột cân đối).
- **Về Route & Git:** AI hướng dẫn thay thế khối `Route::get('/')` test ban đầu bằng `view('home')` và giữ nguyên toàn bộ các route chức năng phía dưới trong `routes/web.php`; tách nhánh `feature/TM-01-trang-chu` đúng quy trình làm việc nhóm.

## 3. Cách áp dụng vào dự án
- Tạo component dùng chung `resources/views/partials/product-card.blade.php` để tái sử dụng cho chức năng **TM-02** (Danh sách sách) và **TM-03** (Chi tiết sản phẩm).
- Hoàn thiện trang chủ `resources/views/home.blade.php` với dữ liệu mẫu và cập nhật `routes/web.php` trên nhánh `feature/TM-01-trang-chu` (commit `feat(TM-01): trang chu du lieu gia`).

---

# [AI Log] - Buổi 4
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Dựng giao diện trang đăng nhập, đăng ký (`TM-04`) theo layout chung và cập nhật trạng thái người dùng trên Header.

## 1. Prompt đã sử dụng
**Prompt 1 (Giao diện Đăng nhập, Đăng ký & Accessibility):**
> "Dựng giao diện form Đăng nhập và Đăng ký kế thừa layout chung dùng Bootstrap 5, có đầy đủ thuộc tính accessibility (`label`, `autocomplete`), hiển thị thông báo lỗi validate từ server (`@error`, `session`)."

**Prompt 2 (Trạng thái Header & Đồng bộ nhánh Git):**
> "Hướng dẫn hiển thị tên người dùng và nút đăng xuất trên Header khi đã đăng nhập, đồng thời gộp toàn bộ code giao diện từ nhánh `develop` và các nhánh `feature` sang nhánh `FrontEnd` trên GitHub."

## 2. Kết quả từ AI & Xác thực
- **Về Form & Validation:** AI gợi ý tích hợp `@csrf`, `old()`, `@error` và các thuộc tính `label for`, `autocomplete`. Đã đối chiếu và giữ nguyên thuộc tính `action` cùng tên các trường `name` của input để khớp hoàn toàn với Controller xử lý của Backend (TV2), sau đó kiểm thử thực tế khi bỏ trống hoặc nhập sai dữ liệu.
- **Về Header & Git:** AI gợi ý kiểm tra tên hiển thị linh hoạt (`Auth::user()->full_name ?? Auth::user()->name`) trên `header.blade.php` và hướng dẫn lệnh `git merge` để đồng bộ mã nguồn sang nhánh `FrontEnd`.

## 3. Cách áp dụng vào dự án
- Hoàn thiện giao diện `resources/views/auth/login.blade.php` và `resources/views/auth/register.blade.php` trên nhánh `feature/TM-04-giao-dien` (commit `feat(TM-04): giao dien dang ky dang nhap`).
- Cập nhật `resources/views/partials/header.blade.php` hiển thị đúng tên người dùng và nút đăng xuất sau khi đăng nhập thành công.
- Đồng bộ toàn bộ mã nguồn giao diện từ Buổi 1 đến Buổi 4 lên nhánh `FrontEnd` trên GitHub.

---

# [AI Log] - Buổi 5
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Trình bày Wireframe Mốc 1 và dựng khung trang Danh sách & Lọc sách (`TM-02`).

## 1. Prompt đã sử dụng
**Prompt 1 (Giao diện Danh sách & Bộ lọc sản phẩm):**
> "Dựng khung trang danh sách sách (`TM-02`) dùng Bootstrap 5 gồm cột bộ lọc bên trái (từ khóa, danh mục, khoảng giá, sắp xếp) tự động thu gọn thành nút bấm trên màn hình 360px, lưới hiển thị sách tái sử dụng partial `product-card.blade.php` và thanh phân trang."

## 2. Kết quả từ AI & Xác thực
- **Về giao diện & Bộ lọc:** AI gợi ý bố cục 2 cột (`col-lg-3` cho sidebar lọc, `col-lg-9` cho lưới sản phẩm) kết hợp `collapse` của Bootstrap trên màn hình nhỏ. Đã kiểm tra thực tế trên trình duyệt tại `http://127.0.0.1:8000/products` ở cả 2 kích thước **360px** và **1366px**, thử lọc theo từ khóa và danh mục hoạt động mượt mà với dữ liệu mẫu.

## 3. Cách áp dụng vào dự án
- Tạo view `resources/views/products/index.blade.php` tái sử dụng component `partials/product-card.blade.php`.
- Thêm route `/products` trong `routes/web.php` trên nhánh `feature/TM-02-danh-sach` (commit `feat(TM-02): khung trang danh sach`) và đồng bộ lên nhánh `FrontEnd`.

---

# [AI Log] - Buổi 6
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Thay dữ liệu giả ở Trang chủ (TM-01) bằng dữ liệu thật từ CSDL (danh mục, 8 sách mới nhất, sách theo từng danh mục), đồng bộ giao diện và mở Pull Request cho TV4 review.

## 1. Prompt đã sử dụng
**Prompt 1 (Truy vấn dữ liệu thật Trang chủ TM-01):**
> "Dựa vào 2 Model Category và Product đã có quan hệ hasMany/belongsTo, viết truy vấn Eloquent trong routes/web.php cho trang chủ lấy danh mục kèm số sách đang bán, 8 sách mới nhất và sách theo từng danh mục."

**Prompt 2 (Cập nhật Blade View & Xử lý ảnh bìa):**
> "Cập nhật product-card.blade.php và home.blade.php để đọc dữ liệu từ đối tượng Eloquent thay vì mảng tĩnh, đồng thời xử lý hiển thị khung giữ chỗ khi thư mục public chưa có file ảnh thật."

**Prompt 3 (Xử lý xung đột Git & Đồng bộ giao diện):**
> "Hỗ trợ xử lý xung đột gộp nhánh trong routes/web.php, AuthService.php và đồng bộ tên trường full_name giữa giao diện đăng ký auth/register.blade.php với Backend."

## 2. Kết quả từ AI & Xác thực
- **Về truy vấn dữ liệu (TM-01):** AI gợi ý sử dụng `Category::withCount('products')`, `Product::where('is_active', true)->latest()->take(8)->get()` và `Category::with('products')` để lấy dữ liệu thật từ CSDL. Đã đối chiếu trực tiếp tên cột trong `app/Models/Product.php` (`name`, `author`, `price`, `image_url`, `is_active`) và kiểm thử thực tế trên trình duyệt tại `http://127.0.0.1:8000` hiển thị đúng 5 danh mục và 8 đầu sách mới nhất.
- **Về giao diện & Xử lý ảnh:** AI hướng dẫn dùng hàm `data_get()` và `file_exists(public_path($image))` trong `product-card.blade.php` để tự động chuyển sang khung giữ chỗ wireframe khi thiếu file ảnh vật lý, giúp giao diện không bị lỗi vỡ hình.
- **Về Git & Đồng bộ code:** Đã rà soát và xóa bỏ toàn bộ dấu đánh dấu xung đột (`<<<<<<<`, `=======`, `>>>>>>>`) trong `routes/web.php` và `AuthService.php`, sửa `name="full_name"` ở trang đăng ký và kiểm thử đăng ký tài khoản mới thành công.

## 3. Cách áp dụng vào dự án
- Hoàn thiện chức năng **TM-01** (Trang chủ lấy dữ liệu thật từ CSDL) trên `routes/web.php`, `resources/views/home.blade.php` và `resources/views/partials/product-card.blade.php`.
- Đồng bộ lại giao diện đăng ký (`TM-04`) và danh sách sản phẩm (`TM-02`) giữa nhánh `FrontEnd` và `feature/TM-01-trang-chu`.
- Đẩy mã nguồn kèm trailer `AI-assisted: Gemini [AI-06]` lên nhánh `feature/TM-01-trang-chu` và mở Pull Request chờ TV4 review.

---

# [AI Log] - Buổi 7
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Xây dựng chức năng tìm kiếm, lọc, sắp xếp và phân trang phía server (TM-02), đồng bộ giao diện đăng nhập/đăng ký (TM-04) và đẩy mã nguồn lên nhánh `feature/TM-02-tim-kiem`.

## 1. Prompt đã sử dụng
**Prompt 1 (Xây dựng ProductService::search & Phân trang phía server):**
> "Viết hàm ProductService::search(keyword, categoryId, minPrice, maxPrice, sort, page) trong Laravel phân trang 12 sách/trang, sử dụng truy vấn tham số hóa, tận dụng chỉ mục trên bảng products và giữ nguyên tham số bộ lọc trên URL."

**Prompt 2 (Giao diện bộ lọc & Sắp xếp trang danh sách sách):**
> "Cập nhật resources/views/products/index.blade.php với bộ lọc từ khóa, danh mục (kèm số lượng sách), khoảng giá, sắp xếp (mới nhất, giá tăng/giảm) và hiển thị thông báo khi không tìm thấy kết quả."

**Prompt 3 (Đồng bộ giao diện Đăng nhập/Đăng ký & Xử lý lỗi namespace):**
> "Sửa lỗi TypeError thiếu use LengthAwarePaginator trong ProductService.php và đồng bộ lại giao diện Bootstrap 5 cho trang /login và /register trong routes/web.php."

## 2. Kết quả từ AI & Xác thực
- **Về truy vấn tìm kiếm & lọc (TM-02):** AI sinh hàm `search()` sử dụng Eloquent Query Builder kết hợp tham số hóa (`LIKE` với biến ràng buộc) để chống SQL Injection, lọc theo các cột có chỉ mục (`is_active`, `category_id`, `price`) và dùng `->paginate(12)->withQueryString()`. Đã kiểm thử thực tế trên trình duyệt tại `/products` với các bộ lọc từ khóa, khoảng giá và sắp xếp hoạt động chính xác, giữ nguyên tham số trên URL.
- **Về xử lý lỗi & giao diện:** Đã bổ sung `use Illuminate\Contracts\Pagination\LengthAwarePaginator;` để khắc phục lỗi `TypeError` và cập nhật `routes/web.php` trả về `view('auth.login')`, `view('auth.register')` giúp toàn bộ hệ thống đồng nhất giao diện Bootstrap 5.

## 3. Cách áp dụng vào dự án
- Hoàn thiện chức năng **TM-02** trên `app/Services/ProductService.php`, `routes/web.php` và `resources/views/products/index.blade.php`.
- Đồng bộ đầy đủ giao diện `TM-01`, `TM-02`, `TM-04` sang nhánh `FrontEnd` và đẩy mã nguồn kèm trailer `AI-assisted: Gemini [AI-07]` lên nhánh `feature/TM-02-tim-kiem`.

---

# [AI Log] - Buổi 8
**Người thực hiện:** TV3 - Nguyễn Quốc Hội (Frontend Lead)
**Nhiệm vụ:** Xây dựng trang chi tiết sách (TM-03), hiển thị sách cùng danh mục (4 cuốn), kết nối nút thêm vào giỏ hàng (TM-05), review PR TM-12 cho TV4 và họp chốt kịch bản demo Mốc 2.

## 1. Prompt đã sử dụng
**Prompt 1 (Route lấy chi tiết sách & Sách cùng danh mục):**
> "Viết route GET /products/{id} trong Laravel lấy thông tin chi tiết sách đang mở bán kèm danh mục (báo 404 nếu không tồn tại) và truy vấn tối đa 4 cuốn sách cùng danh mục (trừ cuốn hiện tại)."

**Prompt 2 (Giao diện trang chi tiết sách resources/views/products/show.blade.php):**
> "Tạo giao diện Blade Bootstrap 5 cho trang chi tiết sách hiển thị ảnh bìa (có khung giữ chỗ nếu thiếu ảnh), giá định dạng 120.000 ₫, tình trạng tồn kho, mô tả nội dung, form thêm vào giỏ hàng kết nối TM-05 và lưới 4 cuốn sách cùng danh mục."

## 2. Kết quả từ AI & Xác thực
- **Về truy vấn & định tuyến (TM-03):** AI gợi ý sử dụng `Product::with('category')->where('is_active', true)->findOrFail($id)` kết hợp ràng buộc `->whereNumber('id')` để tránh xung đột URL, và lọc 4 cuốn sách liên quan theo `category_id`. Đã kiểm thử thực tế trên trình duyệt tại `/products/1` hiển thị đúng thông tin sách và trả về lỗi 404 khi nhập ID không tồn tại.
- **Về giao diện & Trải nghiệm người dùng:** AI sinh giao diện dùng chung layout `layouts.app`, hiển thị giá định dạng `number_format($book->price, 0, ',', '.') . ' ₫'`, kiểm tra số lượng tồn kho để bật/tắt nút **Thêm vào giỏ hàng** (`POST /cart/add`) và tái sử dụng component `partials.product-card` cho mục **Sách cùng danh mục**.

## 3. Cách áp dụng vào dự án
- Hoàn thiện chức năng **TM-03** trên `routes/web.php` và `resources/views/products/show.blade.php`.
- Đồng bộ đầy đủ giao diện (`TM-01`, `TM-02`, `TM-03`, `TM-04`) sang nhánh `FrontEnd`, đẩy mã nguồn kèm trailer `AI-assisted: Gemini [AI-08]` lên nhánh `feature/TM-03-chi-tiet` và mở Pull Request vào `develop`.
- Hoàn thành review PR **TM-12** cho TV4 và tham gia họp nhóm 20:00 chốt kịch bản demo Mốc 2.

---