@php
    $id = data_get($book, 'id', 1);
    $title = data_get($book, 'name') ?? data_get($book, 'title', 'Tên sách');
    $author = data_get($book, 'author', 'Đang cập nhật');
    $price = data_get($book, 'price', 0);
    $image = data_get($book, 'image_url') ?? data_get($book, 'image');
    $imageSrc = $image
        ? (str_starts_with($image, 'http') ? $image : asset($image))
        : null;
@endphp

<div class="card h-100 border rounded-2 shadow-none">
    <!-- Khung ảnh bìa sách -->
    <a href="{{ url('/products/' . $id) }}" class="text-decoration-none p-3 pb-0 d-block">
        @if (!empty($image) && file_exists(public_path($image)))
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-100 object-fit-cover rounded-2" style="height: 170px;">
        @else
            <div class="book-cover-placeholder d-flex flex-column align-items-center justify-content-center text-center small">
                <span>Bìa sách</span>
                <span>Ảnh minh họa</span>
            </div>
        @endif
    </a>

    <!-- Thông tin sách -->
    <div class="card-body d-flex flex-column pt-3">
        <h3 class="card-title fw-bold fs-6 mb-2">
            <a href="{{ url('/products/' . $id) }}" class="text-dark text-decoration-none">
                {{ $title }}
            </a>
        </h3>
        <p class="text-secondary small mb-1 mt-auto">{{ $author }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold">{{ number_format($price, 0, ',', '.') }} đ</span>
            <a href="{{ url('/products/' . $id) }}" class="text-dark small text-decoration-underline">
                Chi tiết &rarr;
            </a>
        </div>
    </div>
</div>