# Thuong_Mai_Dien_Tu
1. Yêu cầu trước khi bắt đầu
Cài đặt các công cụ sau:
- Git: dùng để tải mã nguồn từ GitHub.
- PHP: phiên bản phù hợp với dự án. Kiểm tra yêu cầu trong file composer.json.
- Composer: dùng để cài các thư viện PHP.
- MySQL hoặc MariaDB: dùng để lưu dữ liệu.
- Node.js và npm: cần thiết nếu dự án sử dụng Vite hoặc có package.json để biên dịch giao diện.
- Visual Studio Code (khuyến nghị): dùng để mở và chỉnh sửa mã nguồn.
Có thể kiểm tra Git, PHP, Composer và Node.js đã được cài bằng các lệnh:

git --version
php -v
composer --version
node -v
npm -v

Nếu dự án không sử dụng Node.js/Vite thì có thể bỏ qua hai lệnh kiểm tra Node.js và npm.
2. Tải mã nguồn từ GitHub
  1. Mở trang GitHub của dự án.
  2. Nhấn nút Code.
  3. Sao chép đường dẫn HTTPS của repository.
  4. Mở Terminal, Command Prompt hoặc PowerShell tại thư mục muốn lưu dự án.
  5. Chạy lệnh sau, thay đường dẫn mẫu bằng đường dẫn repository thật:

  6. git clone https://github.com/0306241236-hub/Thuong_Mai_Dien_Tu.git

  7. Di chuyển vào thư mục dự án vừa tải:
  
  8. cd Thuong_Mai_Dien_Tu

3. Cài đặt thư viện của dự án
- Tại thư mục gốc của dự án (thư mục có file artisan và composer.json), chạy:
  composer install
- Nếu repository có file package.json và sử dụng Vite, chạy thêm:
  npm install
- Mở Terminal thứ nhất tại thư mục dự án và chạy:
  php artisan serve
- Mở trình duyệt và truy cập:
  http://127.0.0.1:8000
-Nếu dự án sử dụng Vite để chạy giao diện trong môi trường phát triển, mở Terminal thứ hai và chạy:
  npm run dev
  
 Cài đặt và cấu hình:
1. Cài Git: https://git-scm.com/downloads (Windows chọn mặc định, có Git Bash).
2. Tạo tài khoản GitHub bằng email sinh viên.
3. Cấu hình tên và email trùng với tài khoản GitHub (nếu sai, commit sẽ không được
tính cho bạn):

git config --global user.name "Nguyen Van A"
git config --global user.email "email-sinh-vien@truong.edu.vn"
