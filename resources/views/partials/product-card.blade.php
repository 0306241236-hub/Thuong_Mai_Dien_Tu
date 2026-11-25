<div class="card h-100 border rounded-2 shadow-none">
    <!-- Khung ảnh bìa sách -->
    <a href="{{ url('/products/' . ($book['id'] ?? 1)) }}" class="text-decoration-none p-3 pb-0 d-block">
        @if (!empty($book['image']))
            <img src="{{ asset($book['image']) }}" alt="{{ $book['title'] }}" class="w-100 object-fit-cover rounded-2" style="height: 170px;">
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
            <a href="{{ url('/products/' . ($book['id'] ?? 1)) }}" class="text-dark text-decoration-none">
                {{ $book['title'] }}
            </a>
        </h3>
        <p class="text-secondary small mb-1 mt-auto">{{ $book['author'] }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold">{{ number_format($book['price'], 0, ',', '.') }} ₫</span>
            <a href="{{ url('/products/' . ($book['id'] ?? 1)) }}" class="text-dark small text-decoration-underline">
                Chi tiết &rarr;
            </a>
        </div>
    </div>
</div>