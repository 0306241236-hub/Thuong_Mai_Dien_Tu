<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Danh sách Sản phẩm (Sách)</h3>
        <div>
            <a href="/admin" class="btn btn-outline-secondary me-2">Trang Admin</a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Thêm sách mới</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
<div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Nhập tên sách cần tìm..."
                           value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <select name="category_id" class="form-select">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Đặt lại</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Ảnh bìa</th>
                        <th>Tên sách</th>
                        <th>Danh mục</th>
                        <th>Giá bán</th>
                        <th>Tồn kho</th>
                        <th>Trạng thái</th>
                        <th width="160">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if(!empty($product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh bìa" width="60" height="80" style="object-fit: cover;" class="rounded border">
                                @else
                                    <span class="text-muted small">Chưa có ảnh</span>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $product->name ?? $product->title }}</td>
                            <td>{{ $product->category->name ?? 'Chưa phân loại' }}</td>
                            <td>{{ number_format($product->price ?? 0, 0, ',', '.') }} đ</td>
                            <td>{{ $product->stock ?? $product->quantity ?? 0 }}</td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">Hiển thị</span>
                                @else
                                    <span class="badge bg-secondary">Đang ẩn</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa sách này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Không tìm thấy sách phù hợp.".</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(method_exists($products, 'links'))
    <div class="mt-3">{{ $products->links('pagination::bootstrap-5') }}</div>
@endif
</div>
</body>
</html>