# Quy tắc Git & Quy trình Pull Request

## 1. Mô hình nhánh
- `main`: Bản phát hành theo mốc (chỉ merge từ `develop` khi gắn tag).
- `develop`: Nhánh tích hợp chính của nhóm (chỉ nhận PR đã được review).
- `feature/TM-xx-mo-ta`: Làm chức năng mới (tạo từ `develop`).
- `fix/TM-xx-mo-ta`: Sửa lỗi (tạo từ `develop`).
- `docs/mo-ta`: Tài liệu, báo cáo (tạo từ `develop`).

## 2. Quy ước Commit
- Cú pháp: `<loại>(<mã chức năng>): <mô tả ngắn>` (`feat`, `fix`, `refactor`, `test`, `docs`, `chore`).
- Có dùng AI sinh mã phải thêm dòng cuối: `AI-assisted: <Tên AI> [AI-xx]`.

## 3. Quy tắc Pull Request
- Luôn `git pull origin develop` trước khi tạo nhánh và trước khi mở PR.
- Điền đủ mẫu PR, gắn link PR vào Trello, có ít nhất 1 người review và Approve.
- Không push `.env`, `node_modules`, `vendor`, `bin/obj`.