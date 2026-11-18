<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Seed 5 danh mục (categories)
        $categories = [
            ['id' => 1, 'name' => 'Văn học', 'slug' => 'van-hoc', 'description' => 'Tiểu thuyết, truyện ngắn, tác phẩm văn học trong nước và thế giới', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Kinh tế', 'slug' => 'kinh-te', 'description' => 'Sách quản trị kinh doanh, tài chính, đầu tư và khởi nghiệp', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Kỹ năng sống', 'slug' => 'ky-nang-song', 'description' => 'Phát triển bản thân, tư duy tích cực, kỹ năng giao tiếp và làm việc', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Công nghệ thông tin', 'slug' => 'cong-nghe-thong-tin', 'description' => 'Lập trình, khoa học dữ liệu, trí tuệ nhân tạo và kiến trúc hệ thống', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'Thiếu nhi', 'slug' => 'thieu-nhi', 'description' => 'Truyện tranh, cổ tích, sách kiến thức khoa học dành cho thiếu nhi', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('categories')->insert($categories);

        // 2. Seed 30 cuốn sách (products) - 6 cuốn/danh mục, có 2 cuốn stock = 0 để test hết hàng
        $books = [
            // Danh mục 1: Văn học
            ['category_id' => 1, 'name' => 'Nhà Giả Kim', 'author' => 'Paulo Coelho', 'publisher' => 'NXB Hội Nhà Văn', 'price' => 79000, 'stock' => 45, 'description' => 'Hành trình theo đuổi vận mệnh và lắng nghe trái tim của chàng chăn cừu Santiago.'],
            ['category_id' => 1, 'name' => 'Mắt Biếc', 'author' => 'Nguyễn Nhật Ánh', 'publisher' => 'NXB Trẻ', 'price' => 110000, 'stock' => 30, 'description' => 'Câu chuyện tình đơn phương sâu lắng gắn liền với ký ức làng Đo Đo.'],
            ['category_id' => 1, 'name' => 'Số Đỏ', 'author' => 'Vũ Trọng Phụng', 'publisher' => 'NXB Văn Học', 'price' => 65000, 'stock' => 25, 'description' => 'Tiểu thuyết trào phúng kinh điển phê phán xã hội tư sản thành thị xưa.'],
            ['category_id' => 1, 'name' => 'Tuổi Thơ Dữ Dội', 'author' => 'Phùng Quán', 'publisher' => 'NXB Kim Đồng', 'price' => 135000, 'stock' => 20, 'description' => 'Bản hùng ca bi tráng về đội thiếu niên trinh sát chiến khu Huế.'],
            ['category_id' => 1, 'name' => 'Rừng Na Uy', 'author' => 'Haruki Murakami', 'publisher' => 'NXB Hội Nhà Văn', 'price' => 150000, 'stock' => 18, 'description' => 'Tác phẩm nổi tiếng về tuổi trẻ, nỗi cô đơn và sự trưởng thành tại Tokyo thập niên 1960.'],
            ['category_id' => 1, 'name' => 'Cây Cam Ngọt Của Tôi', 'author' => 'José Mauro de Vasconcelos', 'publisher' => 'NXB Hội Nhà Văn', 'price' => 108000, 'stock' => 0, 'description' => 'Câu chuyện cảm động về cậu bé Zezé giàu trí tưởng tượng và cây cam ngọt nhỏ.'],

            // Danh mục 2: Kinh tế
            ['category_id' => 2, 'name' => 'Cha Giàu Cha Nghèo', 'author' => 'Robert T. Kiyosaki', 'publisher' => 'NXB Trẻ', 'price' => 125000, 'stock' => 50, 'description' => 'Những bài học nền tảng về tư duy tài chính cá nhân và đầu tư tài sản.'],
            ['category_id' => 2, 'name' => 'Tâm Lý Học Về Tiền', 'author' => 'Morgan Housel', 'publisher' => 'NXB Dân Trí', 'price' => 169000, 'stock' => 35, 'description' => '19 câu chuyện ngắn khám phá cách con người suy nghĩ và hành xử với tiền bạc.'],
            ['category_id' => 2, 'name' => 'Từ Tốt Đến Vĩ Đại', 'author' => 'Jim Collins', 'publisher' => 'NXB Trẻ', 'price' => 185000, 'stock' => 22, 'description' => 'Nghiên cứu chuyên sâu giúp doanh nghiệp bứt phá bền vững.'],
            ['category_id' => 2, 'name' => 'Khởi Nghiệp Tinh Gọn', 'author' => 'Eric Ries', 'publisher' => 'NXB Tổng Hợp TP.HCM', 'price' => 145000, 'stock' => 28, 'description' => 'Phương pháp xây dựng sản phẩm thử nghiệm nhanh và tối ưu nguồn lực startup.'],
            ['category_id' => 2, 'name' => 'Nhà Đầu Tư Thông Minh', 'author' => 'Benjamin Graham', 'publisher' => 'NXB Thế Giới', 'price' => 240000, 'stock' => 15, 'description' => 'Cẩm nang kinh điển về triết lý đầu tư giá trị trên thị trường chứng khoán.'],
            ['category_id' => 2, 'name' => 'Chiến Tranh Tiền Tệ', 'author' => 'Song Hongbing', 'publisher' => 'NXB Lao Động', 'price' => 175000, 'stock' => 19, 'description' => 'Góc nhìn lịch sử về sự vận hành của các định chế tài chính toàn cầu.'],

            // Danh mục 3: Kỹ năng sống
            ['category_id' => 3, 'name' => 'Đắc Nhân Tâm', 'author' => 'Dale Carnegie', 'publisher' => 'NXB Tổng Hợp TP.HCM', 'price' => 86000, 'stock' => 60, 'description' => 'Nghệ thuật thu phục lòng người và ứng xử khéo léo trong giao tiếp.'],
            ['category_id' => 3, 'name' => 'Thói Quen Nguyên Tử', 'author' => 'James Clear', 'publisher' => 'NXB Thế Giới', 'price' => 179000, 'stock' => 40, 'description' => 'Thay đổi nhỏ tạo nên kết quả lớn thông qua hệ thống xây dựng thói quen bền vững.'],
            ['category_id' => 3, 'name' => 'Tuổi Trẻ Đáng Giá Bao Nhiêu', 'author' => 'Rosie Nguyễn', 'publisher' => 'NXB Hội Nhà Văn', 'price' => 90000, 'stock' => 32, 'description' => 'Sách truyền cảm hứng học tập, trải nghiệm và định hướng cho người trẻ Việt.'],
            ['category_id' => 3, 'name' => 'Đời Thay Đổi Khi Chúng Ta Thay Đổi', 'author' => 'Andrew Matthews', 'publisher' => 'NXB Trẻ', 'price' => 75000, 'stock' => 27, 'description' => 'Những nguyên tắc sống lạc quan kèm tranh minh họa hóm hỉnh.'],
            ['category_id' => 3, 'name' => 'Tư Duy Nhanh Và Chậm', 'author' => 'Daniel Kahneman', 'publisher' => 'NXB Thế Giới', 'price' => 235000, 'stock' => 16, 'description' => 'Khám phá hai hệ thống chi phối cách bộ não đưa ra quyết định.'],
            ['category_id' => 3, 'name' => 'Quẳng Gánh Lo Đi Và Vui Sống', 'author' => 'Dale Carnegie', 'publisher' => 'NXB Tổng Hợp TP.HCM', 'price' => 92000, 'stock' => 38, 'description' => 'Giải pháp vượt qua căng thẳng, lo âu trong công việc và đời sống.'],

            // Danh mục 4: Công nghệ thông tin
            ['category_id' => 4, 'name' => 'Clean Code - Mã Sạch', 'author' => 'Robert C. Martin', 'publisher' => 'NXB Dân Trí', 'price' => 295000, 'stock' => 20, 'description' => 'Nguyên tắc viết mã nguồn dễ đọc, dễ bảo trì và chuẩn mực cho lập trình viên.'],
            ['category_id' => 4, 'name' => 'Lập Trình PHP Và Laravel Thực Chiến', 'author' => 'Nguyễn Văn An', 'publisher' => 'NXB Khoa Học Kỹ Thuật', 'price' => 220000, 'stock' => 25, 'description' => 'Hướng dẫn xây dựng ứng dụng web thương mại điện tử hoàn chỉnh với Laravel.'],
            ['category_id' => 4, 'name' => 'Cấu Trúc Dữ Liệu Và Giải Thuật', 'author' => 'Đỗ Xuân Lôi', 'publisher' => 'NXB Đại Học Quốc Gia', 'price' => 155000, 'stock' => 30, 'description' => 'Giáo trình nền tảng về thuật toán, cây, đồ thị và độ phức tạp tính toán.'],
            ['category_id' => 4, 'name' => 'Thiết Kế Hệ Thống Dữ Liệu Lớn', 'author' => 'Martin Kleppmann', 'publisher' => 'NXB Thế Giới', 'price' => 340000, 'stock' => 12, 'description' => 'Kiến trúc cơ sở dữ liệu phân tán, sao lưu và xử lý dữ liệu quy mô lớn.'],
            ['category_id' => 4, 'name' => 'Nhập Môn Trí Tuệ Nhân Tạo', 'author' => 'Stuart Russell', 'publisher' => 'NXB Bách Khoa', 'price' => 280000, 'stock' => 14, 'description' => 'Tổng quan từ thuật toán tìm kiếm đến học máy hiện đại.'],
            ['category_id' => 4, 'name' => 'Thực Hành Git Và Quản Lý Mã Nguồn', 'author' => 'Trần Minh Quân', 'publisher' => 'NXB Thanh Niên', 'price' => 130000, 'stock' => 0, 'description' => 'Quy trình làm việc nhóm hiệu quả với Git, GitHub và Pull Request.'],

            // Danh mục 5: Thiếu nhi
            ['category_id' => 5, 'name' => 'Dế Mèn Phiêu Lưu Ký', 'author' => 'Tô Hoài', 'publisher' => 'NXB Kim Đồng', 'price' => 55000, 'stock' => 55, 'description' => 'Cuộc phiêu lưu kỳ thú qua thế giới loài vật của chú Dế Mèn.'],
            ['category_id' => 5, 'name' => 'Hoàng Tử Bé', 'author' => 'Antoine de Saint-Exupéry', 'publisher' => 'NXB Kim Đồng', 'price' => 75000, 'stock' => 42, 'description' => 'Câu chuyện triết lý nhẹ nhàng về tình bạn và tình yêu thương dành cho mọi lứa tuổi.'],
            ['category_id' => 5, 'name' => 'Kính Vạn Hoa - Tập 1', 'author' => 'Nguyễn Nhật Ánh', 'publisher' => 'NXB Kim Đồng', 'price' => 95000, 'stock' => 33, 'description' => 'Những câu chuyện học trò tinh nghịch của bộ ba Quý Ròm, Tiểu Long và nhỏ Hạnh.'],
            ['category_id' => 5, 'name' => 'Bách Khoa Toàn Thư Vũ Trụ Cho Trẻ Em', 'author' => 'DK Publishing', 'publisher' => 'NXB Kim Đồng', 'price' => 210000, 'stock' => 17, 'description' => 'Khám phá hệ Mặt Trời, các vì sao và tàu vũ trụ qua hình ảnh trực quan.'],
            ['category_id' => 5, 'name' => 'Truyện Cổ Tích Việt Nam Chọn Lọc', 'author' => 'Nhiều Tác Giả', 'publisher' => 'NXB Văn Học', 'price' => 68000, 'stock' => 40, 'description' => 'Tuyển tập các truyện cổ tích dân gian giàu tính nhân văn.'],
            ['category_id' => 5, 'name' => 'Pippi Tất Dài', 'author' => 'Astrid Lindgren', 'publisher' => 'NXB Kim Đồng', 'price' => 88000, 'stock' => 24, 'description' => 'Những trò nghịch ngợm hài hước và đầy lòng nhân ái của cô bé Pippi.'],
        ];

        $productsInsert = [];
        foreach ($books as $index => $book) {
            $productsInsert[] = array_merge($book, [
                'id' => $index + 1,
                'image_url' => 'images/books/book-' . ($index + 1) . '.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        DB::table('products')->insert($productsInsert);

        // 3. Seed 11 tài khoản (1 Admin + 10 Khách hàng, có 1 khách hàng status = 'locked')
        $hashedPassword = Hash::make('123456');
        $users = [
            [
                'id' => 1,
                'full_name' => 'Quản Trị Viên Hệ Thống',
                'email' => 'admin@bookstore.vn',
                'password' => $hashedPassword,
                'phone' => '0901000001',
                'address' => 'Quận 1, TP. Hồ Chí Minh',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $customerNames = [
            'Nguyễn Minh Khang', 'Trần Thị Thu Hà', 'Lê Hoàng Nam', 'Phạm Ngọc Ánh', 'Võ Quốc Bảo',
            'Đặng Thùy Linh', 'Bùi Tuấn Kiệt', 'Hoàng Mai Phương', 'Đỗ Thanh Tùng', 'Ngô Văn Khóa (Tài khoản khóa)',
        ];

        foreach ($customerNames as $i => $name) {
            $num = $i + 1;
            $users[] = [
                'id' => $num + 1,
                'full_name' => $name,
                'email' => "khach{$num}@bookstore.vn",
                'password' => $hashedPassword,
                'phone' => '09020000' . str_pad((string) $num, 2, '0', STR_PAD_LEFT),
                'address' => "Số {$num}0 Đường Lê Lợi, Quận {$num}, TP. Hồ Chí Minh",
                'role' => 'customer',
                'status' => ($num === 10) ? 'locked' : 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('users')->insert($users);

        // 4. Seed 10 đơn hàng (orders) kèm chi tiết (order_items) chia đều 4 trạng thái
        $sampleOrders = [
            ['user_id' => 2, 'status' => 'completed', 'payment_method' => 'COD', 'items' => [[1, 2], [7, 1]]],
            ['user_id' => 3, 'status' => 'completed', 'payment_method' => 'BANKING', 'items' => [[13, 1], [14, 1]]],
            ['user_id' => 4, 'status' => 'completed', 'payment_method' => 'COD', 'items' => [[19, 1], [20, 1]]],
            ['user_id' => 5, 'status' => 'shipping', 'payment_method' => 'COD', 'items' => [[2, 2], [25, 1]]],
            ['user_id' => 6, 'status' => 'shipping', 'payment_method' => 'BANKING', 'items' => [[8, 1], [15, 2]]],
            ['user_id' => 7, 'status' => 'pending', 'payment_method' => 'COD', 'items' => [[3, 1], [4, 1]]],
            ['user_id' => 8, 'status' => 'pending', 'payment_method' => 'COD', 'items' => [[21, 1], [26, 2]]],
            ['user_id' => 9, 'status' => 'pending', 'payment_method' => 'BANKING', 'items' => [[10, 1]]],
            ['user_id' => 10, 'status' => 'cancelled', 'payment_method' => 'COD', 'items' => [[5, 1], [16, 1]]],
            ['user_id' => 2, 'status' => 'cancelled', 'payment_method' => 'COD', 'items' => [[28, 1]]],
        ];

        foreach ($sampleOrders as $orderIdx => $orderData) {
            $user = $users[$orderData['user_id'] - 1];
            $totalAmount = 0;
            $orderItemsRows = [];

            foreach ($orderData['items'] as [$productId, $qty]) {
                $price = $productsInsert[$productId - 1]['price'];
                $totalAmount += $price * $qty;
                $orderItemsRows[] = [
                    'order_id' => $orderIdx + 1,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price_at_purchase' => $price,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('orders')->insert([
                'id' => $orderIdx + 1,
                'user_id' => $user['id'],
                'receiver_name' => $user['full_name'],
                'receiver_phone' => $user['phone'],
                'shipping_address' => $user['address'],
                'total_amount' => $totalAmount,
                'payment_method' => $orderData['payment_method'],
                'status' => $orderData['status'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('order_items')->insert($orderItemsRows);
        }
    }
}