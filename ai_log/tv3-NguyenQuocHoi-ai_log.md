# AI log – TV3 – Nguyễn Quốc Hội

| Mục | Thông tin |
| Họ tên, MSSV | Nguyễn Quốc Hội – 0306231376 |
| Nhóm, đề tài | Nhóm 5 – Đồ án Web Thương Mại Điện Tử (Bán Sách) |
| Vai trò | TV3 – Frontend Lead |
| Công cụ AI dùng | Gemini |

## Bảng tổng hợp

| Mã | Ngày | Giai đoạn | Nội dung | Commit / PR |
| AI-01 | 13/11 | Thiết kế/Lập trình | Dựng Layout chung (Header, Nav, Footer) | PR #3 |
| AI-02 | 13/11 | Lập trình | Cấu trúc HTML/CSS Grid cho [TM-01] Trang chủ | PR [Số PR mới nhất] |
| AI-03 | 14/11 | Lập trình | Dựng form Đăng ký/Đăng nhập và kiểm tra accessibility (TM-04) | PR [Số PR Ngày 4] |
| AI-04 | 14/11 | Kiểm thử | Sửa lỗi liên kết href="#" không chuyển được trang | PR [Số PR Ngày 4] |
| AI-05 | 16/11 | Lập trình | Dùng JavaScript đổ dữ liệu thật cho [TM-01] Trang chủ | PR [Số PR Ngày 6] |
---

### [AI-01] Dựng Layout chung (Header, Nav, Footer)
- Ngày / Người dùng: 2026-11-13 / Nguyễn Quốc Hội
- Công cụ: Gemini
- Giai đoạn: Thiết kế / Lập trình
- Task / Commit / PR: Dựng Layout chung / PR #3 (nhánh `feature/layout`)
- Mục đích: Lấy khung HTML semantic (header, main, footer) và CSS cơ bản để tạo giao diện tổng thể ban đầu cho dự án, có thanh tìm kiếm và menu.
- Prompt chính (nguyên văn hoặc link chia sẻ hội thoại): "Hướng dẫn tạo layout HTML CSS cho trang web bán sách bao gồm top bar, header, menu và footer" *(Ghi chú: Nội dung prompt thực tế trước ngày 3)*
- Kết quả AI trả về (tóm tắt): AI cung cấp file `index.html` chứa cấu trúc thẻ Semantic và `style.css` định dạng Flexbox cho Header/Footer, kèm media query cho mobile (768px).
- Đánh giá: Đúng - Cấu trúc rõ ràng, đáp ứng tốt yêu cầu layout ban đầu, tiết kiệm thời gian dựng khung.
- Đã chỉnh sửa gì: Chỉnh sửa lại nội dung văn bản (Tên nhà sách, liên hệ) và tích hợp vào dự án qua Git.
- Cách kiểm chứng: Mở `index.html` trên trình duyệt xem thử, kiểm tra Responsive qua DevTools ở mức 768px.
- Tỷ lệ nội dung AI còn giữ lại (ước lượng): 85%
- Điều học được: Cách sử dụng Flexbox để dàn trang Header và Footer nhanh chóng, cùng với quy trình tạo branch `feature/layout` trên Git.

### [AI-02] Cấu trúc HTML/CSS Grid cho [TM-01] Trang chủ và Thẻ sản phẩm
- Ngày / Người dùng: 2026-11-13 / Nguyễn Quốc Hội
- Công cụ: Gemini
- Giai đoạn: Lập trình
- Task / Commit / PR: [TM-01] Trang chủ / `feat (TM-01): trang chu du lieu gia` / PR mới nhất
- Mục đích: Cắt HTML/CSS cho khối "Sách mới cập nhật", xây dựng component "Thẻ sản phẩm" và cấu hình CSS Grid để giao diện responsive (tự nhảy cột) từ 1366px xuống 360px.
- Prompt chính (nguyên văn hoặc link chia sẻ hội thoại): "Code dùm tôi luôn đi nhớ dựa vào ảnh mà tôi đã gửi ở trên... làm tiếp tục phần còn lại hết của TV3 đi"
- Kết quả AI trả về (tóm tắt): Cung cấp đoạn mã `<section>` chứa lưới sản phẩm dùng `display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));`. Cung cấp CSS cho thẻ sản phẩm (hiệu ứng hover) và `@media (max-width: 576px)` ép thành 2 cột cho mobile.
- Đánh giá: Đúng - Component thẻ sản phẩm đẹp, đúng chuẩn. Lưới Grid hoạt động cực kỳ linh hoạt mà không cần viết quá nhiều Media Query.
- Đã chỉnh sửa gì: Tái sử dụng component thẻ sản phẩm để nhân bản ra thêm khối "Sách Chuyên Ngành CNTT" theo đúng yêu cầu Trello [TM-01].
- Cách kiểm chứng: Mở trực tiếp file `index.html` trên trình duyệt, dùng DevTools kiểm tra hiển thị ở 2 mức kích thước 1366px (lên được 4-5 cột) và 360px (ép về 2 cột gọn gàng) mà không bị vỡ khung. Đã chụp ảnh báo cáo lên Pull Request.
- Tỷ lệ mã AI còn giữ lại (ước lượng): 95%
- Điều học được: Cách khôi phục file bị ẩn khi chuyển nhánh nhầm trên Git. Hiểu được sức mạnh của hàm `minmax()` trong CSS Grid giúp tự động chia cột thông minh.

### [AI-03] Dựng form Đăng ký/Đăng nhập và kiểm tra accessibility (TM-04)

- Ngày / Người dùng: 2026-11-14 / Nguyễn Quốc Hội
- Công cụ: Gemini
- Giai đoạn: Lập trình
- Task / Commit / PR: [TM-04] Trang đăng ký/đăng nhập giao diện / `feat (TM-04): giao dien dang ky dang nhap` / PR [Số PR Ngày 4]
- Mục đích: Tạo 2 file `login.html`, `register.html` dựa trên layout chung; thêm chỗ trống hiển thị lỗi; cập nhật header có nút đăng xuất và tên người dùng; đảm bảo form đạt chuẩn accessibility.
- Prompt chính (nguyên văn hoặc link chia sẻ hội thoại): "3,4 đưa code tôi chép", yêu cầu code form theo hướng dẫn ngày 4.
- Kết quả AI trả về (tóm tắt): Sinh ra code HTML hoàn chỉnh cho 2 trang, bổ sung class `error-message`, thêm thẻ `label for="..."` và thuộc tính `autocomplete` (`email`, `current-password`, `new-password`) vào các input.
- Đánh giá: Đúng - Giao diện trực quan, code form đầy đủ thuộc tính chuẩn giúp trình duyệt tự động điền (autofill) dễ dàng hơn.
- Đã chỉnh sửa gì: Copy và chèn trực tiếp vào thư mục dự án Front_end, thêm CSS đi kèm vào file `style.css`.
- Cách kiểm chứng: Mở trực tiếp trên trình duyệt, kiểm tra trực quan giao diện form và header.
- Tỷ lệ mã AI còn giữ lại (ước lượng): 95%
- Điều học được: Cách ứng dụng thuộc tính `autocomplete` để tăng cường trải nghiệm người dùng (UX) và accessibility cho web.

### [AI-04] Sửa lỗi liên kết href="#" không chuyển được trang

- Ngày / Người dùng: 2026-11-14 / Nguyễn Quốc Hội
- Công cụ: Gemini
- Giai đoạn: Kiểm thử
- Task / Commit / PR: [TM-04] Trang đăng ký/đăng nhập giao diện / `feat (TM-04): giao dien dang ky dang nhap` / PR [Số PR Ngày 4]
- Mục đích: Sửa lỗi click vào nút "Đăng nhập" trên thanh menu nhưng không chuyển sang trang `login.html` mà URL chỉ bị thêm dấu `#`.
- Prompt chính (nguyên văn hoặc link chia sẻ hội thoại): "sao tôi bấm chỗ đăng nhập thì không được" (kèm ảnh chụp màn hình trình duyệt có đuôi `#`).
- Kết quả AI trả về (tóm tắt): Phân tích ảnh và giải thích do thuộc tính `href` đang đặt là giá trị giữ chỗ `#`, hướng dẫn đổi thành `href="login.html"`.
- Đánh giá: Chính xác và nhanh gọn, bắt trúng lỗi cơ bản của việc liên kết các trang HTML tĩnh.
- Đã chỉnh sửa gì: Sửa thẻ `<a>` ở file `index.html`.
- Cách kiểm chứng: Reload lại trang chủ, click nút Đăng nhập và thấy chuyển trang thành công.
- Tỷ lệ mã AI còn giữ lại (ước lượng): 100% logic.
- Điều học được: Nhớ thay thế các giá trị link tạm thời (`#`) bằng đường dẫn file thực tế khi phát triển giao diện nhiều trang.

### [AI-05] Hỗ trợ viết mã JavaScript đổ dữ liệu mảng ra trang chủ
- Ngày / Người dùng: 2026-11-16 / Nguyễn Quốc Hội
- Công cụ: Gemini
- Giai đoạn: Lập trình
- Task / Commit / PR: [TM-01] Trang chủ / `feat (TM-01): trang chu du lieu that bang JS` / PR [Số PR Ngày 6]
- Mục đích: Thay thế dữ liệu HTML gõ cứng bằng JavaScript để tự động render danh sách Danh mục và 4 sách mới nhất từ CSDL giả lập (mảng dữ liệu).
- Prompt chính (nguyên văn hoặc link chia sẻ hội thoại): "Giờ làm sao, code à", cung cấp ảnh ERD CSDL và mã nguồn HTML tĩnh hiện tại để nhờ AI hướng dẫn cách tích hợp dữ liệu.
- Kết quả AI trả về (tóm tắt): AI cung cấp đoạn script Vanilla JS sử dụng mảng dữ liệu giả lập, dùng `document.getElementById` và `innerHTML` để chèn động các thẻ `<li>` (danh mục) và `<article>` (sách) vào đúng vị trí. Đồng thời hướng dẫn dọn dẹp các thẻ cứng cũ.
- Đánh giá: Code chạy chính xác ngay lần đầu, dữ liệu render đúng vị trí, giá tiền được format chuẩn VNĐ.
- Đã chỉnh sửa gì: Thêm các thuộc tính `id="category-menu"` và `id="latest-books"` vào file `index.html` hiện tại, xóa các phần tử HTML cứng cũ, và chèn thẻ `<script>` vào cuối `<body>`.
- Cách kiểm chứng: Mở trực tiếp file `index.html` trên trình duyệt, nhấn F5, kiểm tra thấy dữ liệu (4 cuốn sách và menu danh mục) tự động load thành công mà không bị vỡ layout.
- Tỷ lệ nội dung AI còn giữ lại (ước lượng): 95%
- Điều học được: Hiểu được quy trình cơ bản để thao tác DOM bằng JavaScript, dùng vòng lặp `forEach` để sinh HTML động thay vì viết tĩnh, tạo tiền đề tốt cho việc ghép API thật (Fetch API) từ Backend sau này.
