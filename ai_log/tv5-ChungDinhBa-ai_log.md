# AI log – TV5 – Chung Đình Bá

> Mỗi thành viên một tệp trong `ai-logs/`. Ghi một mục ngay sau mỗi lần dùng AI có ảnh hưởng đến sản phẩm, commit cùng thay đổi liên quan. Cả đồ án tối thiểu 6 mục có nội dung thực chất. Mã mục tăng dần: AI-01, AI-02, ...

| Mục | Thông tin |
| --- | --- |
| Họ tên, MSSV | Chung Đình Bá – 0306241261 |
| Nhóm, đề tài | Nhóm 5 – Thương Mại Điện Tử |
| Vai trò | TV5 – GT (Git & Tester) |
| Công cụ AI dùng | [ChatGPT / Claude / Gemini |

## Bảng tổng hợp

| Mã | Ngày | Giai đoạn | Nội dung | Commit / PR |
| --- | --- | --- | --- | --- |
| AI-01 | [14/11] | Lập kế hoạch | Thiết lập Git workflow, quy ước commit và mẫu PR | [PR 0 ] |
| AI-02 | [21/11] | Kiểm thử | Sinh bộ test case và kịch bản kiểm thử chức năng chính | [PR 8] |

---

### [AI-01] Thiết lập Git workflow, quy ước commit và mẫu Pull Request
- Ngày / Người dùng: [14/11/2026] / [Chung Đình Bá]
- Công cụ: [ChatGPT (GPT-x) / Claude / Gemini]
- Giai đoạn: Lập kế hoạch
- Task / Commit / PR: [CONFIG] Cấu hình Git & PR template / [a1b2c3d] / [PR #1]
- Mục đích: Xây dựng quy trình phân nhánh (branching), quy tắc đặt tên commit và checklist review PR cho nhóm 5 người làm trong 3 tuần để hạn chế xung đột code (merge conflict).
- Prompt chính (nguyên văn hoặc link chia sẻ hội thoại): "Nhóm 5 sinh viên làm website [Thuong-Mai-Dien-Tu] trong 3 tuần trên GitHub. Hãy đề xuất mô hình phân nhánh Git đơn giản, quy tắc đặt tên branch/commit chuẩn Conventional Commits, và một file pull_request_template.md ngắn gọn để Tester kiểm tra trước khi merge."
- Kết quả AI trả về (tóm tắt): [AI đề xuất mô hình nhánh main/develop/feature/fix, quy ước commit feat/fix/docs/test và mẫu PR gồm 8 mục kiểm tra]
- Đánh giá: [Đúng một phần – mô hình nhánh phù hợp nhưng mẫu PR quá dài, chứa nhiều bước chưa áp dụng ngay trong 3 tuần]
- Đã chỉnh sửa gì: [Rút gọn mẫu PR còn 4 mục cốt lõi (mô tả thay đổi, đã test local, không lỗi console, ảnh chụp màn hình) và bổ sung quy tắc bắt buộc Tester/Leader review trước khi merge vào develop]
- Cách kiểm chứng: Tạo thử nhánh feature mẫu, mở Pull Request để kiểm tra hiển thị template trên GitHub; thống nhất quy ước với cả nhóm trong buổi họp Sprint 1
- Tỷ lệ nội dung AI còn giữ lại (ước lượng): [60]%
- Điều học được: [Cần nêu rõ quy mô nhóm và thời gian thực hiện để AI không đề xuất quy trình Git quá phức tạp]

### [AI-02] Sinh bộ test case và kịch bản kiểm thử chức năng chính.
- Ngày / Người dùng: 21/11/2026 / Chung Đình Bá
- Công cụ: [ChatGPT / Gemini]
- Giai đoạn: Kiểm thử
- Task / Commit / PR: [TEST] Bộ test case chức năng chính / [e4f5g6h] / [PR 8]
- Mục đích: Liệt kê đầy đủ các trường hợp kiểm thử (luồng chính, ngoại lệ, kiểm tra dữ liệu đầu vào) cho chức năng chính trước khi nghiệm thu PR.
- Prompt chính (nguyên văn hoặc link chia sẻ hội thoại): "Dựa trên mô tả chức năng sau: '[dán user story và tiêu chí chấp nhận]'. Hãy viết bảng test case gồm ID, kịch bản kiểm thử, điều kiện tiên quyết, các bước thực hiện, dữ liệu test và kết quả mong đợi (gồm trường hợp hợp lệ, bỏ trống và nhập sai định dạng)."
