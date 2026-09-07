<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Mobile - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Scoped styles to match the screenshot exactly */
        .shop-page-container {
            background: #fff;
            padding: 30px 20px 60px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* Top Progress Bar & Back Navigation */
        .shop-step-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 35px;
        }
        .back-circle-nav {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #003a70;
            text-decoration: none;
            font-size: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .step-dots-flex {
            display: flex;
            gap: 8px;
            flex-grow: 1;
            margin: 0 20px;
        }
        .dot-seg {
            height: 6px;
            flex: 1;
            background-color: #f2f2f2;
            border-radius: 4px;
        }
        .dot-seg.active {
            background-color: #e31e24;
        }
        .step-label-indicator {
            font-size: 14px;
            font-weight: 800;
            color: #e31e24;
            white-space: nowrap;
        }

        /* Headlines */
        .shop-main-h {
            font-size: 32px;
            font-weight: 900;
            color: #000;
            margin-bottom: 8px;
        }
        .shop-main-p {
            font-size: 16px;
            color: #666;
            margin-bottom: 35px;
            line-height: 1.4;
            font-weight: 500;
        }

        .section-shop-label {
            display: block;
            font-size: 18px;
            font-weight: 800;
            color: #333;
            margin-bottom: 20px;
        }

        /* Brand Grid - 3 Column Layout */
        .brand-grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 45px;
        }
        .brand-card-box {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .brand-card-box.active {
            border: 2px solid #e31e24;
        }
        .brand-card-box img {
            height: 45px;
            max-width: 80%;
            object-fit: contain;
        }
        .brand-card-box span {
            font-size: 14px;
            font-weight: 700;
            color: #555;
            text-align: center;
        }

        /* Series Select Picker */
        .series-dropdown-container {
            margin-bottom: 45px;
        }
        .shop-select-custom {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") no-repeat right 1rem center/16px 12px;
            appearance: none;
        }

        /* Product List Card (Horizontal) */
        .mobile-list-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .mobile-row-card {
            background: #fff;
            border: 1px solid #f5f5f5;
            border-radius: 20px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.02);
        }
        .mobile-img-thumb {
            width: 70px;
            height: 70px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mobile-img-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .mobile-details-info {
            flex-grow: 1;
        }
        .mobile-name-h {
            font-size: 18px;
            font-weight: 900;
            color: #000;
            margin-bottom: 2px;
        }
        .mobile-price-h {
            font-size: 18px;
            font-weight: 900;
            color: #e31e24;
            margin-bottom: 2px;
        }
        .mobile-meta-h {
            font-size: 13px;
            color: #999;
            font-weight: 700;
        }
        .btn-buy-red-pill {
            background-color: #e31e24;
            color: #fff !important;
            border-radius: 25px;
            padding: 10px 25px;
            font-size: 15px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
            border: none;
        }

        @media (max-width: 480px) {
            .brand-grid-container { gap: 10px; }
            .brand-card-box { padding: 12px 2px; }
            .mobile-row-card { padding: 12px; gap: 12px; }
            .mobile-img-thumb { width: 45px; height: 45px; }
            .btn-buy-red-pill { padding: 7px 14px; font-size: 11px; }
        }
    </style>
</head>
<body>
    <div class="mobile-wrapper">
        <!-- Reusable Header -->
        @include('frontend.partials.header')

        <div class="shop-page-container">
            <!-- Step Navigation Indicator -->
            <div class="shop-step-header">
                <a href="{{ url('/') }}" class="back-circle-nav"><i class="fas fa-arrow-left"></i></a>
                <div class="step-dots-flex">
                    <div class="dot-seg active"></div>
                    <div class="dot-seg active"></div>
                    <div class="dot-seg"></div>
                    <div class="dot-seg"></div>
                    <div class="dot-seg"></div>
                    <div class="dot-seg"></div>
                </div>
                <div class="step-label-indicator">01/03 — Select Mobile</div>
            </div>

            <h1 class="shop-main-h">Select Your Mobile</h1>
            <p class="shop-main-p">Choose a brand and series, then tap "Buy Now" on any phone model to pick your EMI plan.</p>

            <!-- 1. Choose Brand Section -->
            <div class="shop-section-wrapper">
                <span class="section-shop-label">1. Choose Brand</span>
                <div class="brand-grid-container">
                    @foreach($brands as $brand)
                    <div class="brand-card-box {{ $brandId == $brand->id ? 'active' : '' }}" onclick="filterBrand({{ $brand->id }})">
                        <img src="{{ $brand->logo_url ?? asset('img/brands/'.strtolower($brand->name).'.png') }}" alt="{{ $brand->name }}" onerror="this.src='https://placehold.co/100x100?text={{ $brand->name }}'">
                        <span>{{ $brand->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- 2. Select Series Section -->
            <div class="shop-section-wrapper">
                <span class="section-shop-label">2. Select Series</span>
                <div class="series-dropdown-container">
                    <select class="shop-select-custom" onchange="filterSeries(this.value)">
                        <option value="all">Select Series</option>
                        @foreach($series as $s)
                        <option value="{{ $s->id }}" {{ $seriesId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 3. Model Listing Section -->
            <div class="shop-section-wrapper">
                <span class="section-shop-label">3. Select Model & Buy Now</span>
                <div class="mobile-list-group">
                    @foreach($mobiles as $mobile)
                    <div class="mobile-row-card">
                        <div class="mobile-img-thumb">
                            <img src="{{ $mobile->image_url ?? asset('img/mobile-icon.png') }}" alt="{{ $mobile->name }}" onerror="this.src='https://cdn-icons-png.flaticon.com/512/0/191.png'">
                        </div>
                        <div class="mobile-details-info">
                            <div class="mobile-name-h">{{ $mobile->name }}</div>
                            <div class="mobile-price-h">Rs. {{ number_format($mobile->price) }}</div>
                            <div class="mobile-meta-h">{{ $mobile->specs ?? 'Official Warranty' }}</div>
                        </div>
                        <a href="{{ route('plan', ['id' => $mobile->id]) }}" class="btn-buy-red-pill">Buy Now</a>
                    </div>
                    @endforeach

                    @if($mobiles->isEmpty())
                        <div class="text-center py-5">
                            <p class="text-muted" style="font-size: 14px;">No models found for your selection.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterBrand(brandId) {
            const url = new URL(window.location.href);
            url.searchParams.set('brand', brandId);
            url.searchParams.delete('series');
            window.location.href = url.toString();
        }
        function filterSeries(seriesId) {
            const url = new URL(window.location.href);
            if (seriesId === 'all') url.searchParams.delete('series');
            else url.searchParams.set('series', seriesId);
            window.location.href = url.toString();
        }
    </script>
</body>
</html>
