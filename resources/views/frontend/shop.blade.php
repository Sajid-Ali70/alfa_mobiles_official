<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Mobile - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @php
        $appName = $settings->app_name ?? 'Alfa Mobiles';
    @endphp

    <div class="mobile-wrapper">
        <!-- Header -->
        <header>
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="{{ $appName }}">
                </a>
            </div>
            <div class="header-right">
                <a href="{{ route('track') }}" class="btn-track">
                    <i class="fas fa-truck-moving"></i> Track
                </a>
                <div class="contact-icons">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="contact-circle bg-whatsapp" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:{{ $settings->contact_email ?? 'info@alfamobiles.com' }}" class="contact-circle bg-mail" target="_blank">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </header>

        <div class="shop-content">
            <!-- Step Indicator -->
            <div class="step-indicator-wrapper">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <a href="{{ url('/') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                    <div class="progress-line-container">
                        <div class="line active"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <div class="step-counter-text">01/03 — Select Mobile</div>
                </div>
            </div>

            <h1 class="shop-title">Select Your Mobile</h1>
            <p class="shop-subtitle">Choose a brand and series, then tap "Buy Now —>" on any phone model to pick your EMI plan.</p>

            <!-- 1. Choose Brand -->
            <div class="section-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="section-label mb-0">1. Choose Brand</span>
                    @if($brandId)
                    <a href="{{ route('shop') }}" class="text-decoration-none small text-danger fw-bold">Clear Filters</a>
                    @endif
                </div>
                <div class="brand-grid">
                    @forelse($brands as $brand)
                    <div class="brand-card {{ $brandId == $brand->id ? 'active' : '' }}" onclick="filterBrand({{ $brand->id }})">
                        @if($brandId == $brand->id) <div class="active-check"><i class="fas fa-check"></i></div> @endif
                        <img src="{{ $brand->logo_url ?? 'https://placehold.co/100x100?text='.$brand->name }}" alt="{{ $brand->name }}">
                        <span>{{ $brand->name }}</span>
                    </div>
                    @empty
                    <div class="text-muted p-3">No brands added yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- 2. Select Series -->
            <div class="section-container">
                <span class="section-label">2. Select Series</span>
                <div class="custom-select-wrapper">
                    <select class="series-select" onchange="filterSeries(this.value)">
                        <option value="all">All Series</option>
                        @foreach($series as $s)
                        <option value="{{ $s->id }}" {{ $seriesId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 3. Select Model & Buy Now -->
            <div class="section-container">
                <span class="section-label">3. Select Model & Buy Now ({{ $seriesName }})</span>
                <div class="product-list">
                    @forelse($mobiles as $mobile)
                    <div class="product-card">
                        <div class="product-image-box">
                            <img src="{{ $mobile->image_url ?? 'https://placehold.co/100x100?text=Phone' }}" alt="{{ $mobile->name }}">
                        </div>
                        <div class="product-details">
                            <div class="product-name">{{ $mobile->name }}</div>
                            <div class="product-price">Rs. {{ number_format($mobile->price) }}</div>
                            <div class="product-meta">{{ $mobile->specs }}</div>
                        </div>
                        <a href="{{ route('plan', ['id' => $mobile->id]) }}" class="btn-buy-now-pill">Buy Now —></a>
                    </div>
                    @empty
                    <div class="text-center p-5 border rounded-3 bg-light">
                        <i class="fas fa-mobile-alt fa-3x mb-3 text-muted"></i>
                        <p class="text-secondary fw-bold">No mobiles found.</p>
                        <p class="small text-muted">Try changing your filters or check back later.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterBrand(brandId) {
            const url = new URL(window.location.href);
            url.searchParams.set('brand', brandId);
            url.searchParams.delete('series'); // Reset series when brand changes
            window.location.href = url.toString();
        }

        function filterSeries(seriesId) {
            const url = new URL(window.location.href);
            if (seriesId === 'all') {
                url.searchParams.delete('series');
            } else {
                url.searchParams.set('series', seriesId);
            }
            window.location.href = url.toString();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
