feature/khung-du-an-db
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
## Cài đặt
Clone code và chạy `composer install`.
Copy file `.env.example` thành `.env`, tạo DB rỗng và cấu hình DB.
Chạy `php artisan serve` và vào đường dẫn `/test-db` để kiểm tra.
=======
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
BackEnd
