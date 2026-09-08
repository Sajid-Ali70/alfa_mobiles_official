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
        .shop-page-container {
            background: #fff;
            padding: 30px 20px 60px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

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

        .brand-dropdown-container, .series-dropdown-container, .model-dropdown-container {
            margin-bottom: 25px;
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

        .btn-buy-now-large {
            display: block;
            width: 100%;
            background-color: #e31e24;
            color: #fff !important;
            padding: 18px;
            border-radius: 12px;
            text-align: center;
            font-size: 20px;
            font-weight: 800;
            text-decoration: none;
            margin-top: 35px;
            border: none;
            box-shadow: 0 4px 15px rgba(227, 30, 36, 0.2);
            transition: all 0.2s;
        }
        .btn-buy-now-large:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="mobile-wrapper">
        @include('frontend.partials.header')

        <div class="shop-page-container">
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
            <p class="shop-main-p">Choose a brand, series, and model, then tap "Buy Now" to pick your EMI plan.</p>

            <!-- 1. Choose Brand Section -->
            <div class="shop-section-wrapper">
                <span class="section-shop-label">1. Choose Brand</span>
                <div class="brand-dropdown-container">
                    <select class="shop-select-custom" onchange="filterBrand(this.value)">
                        <option value="all">Select Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $brandId == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
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

            <!-- 3. Select Model Section -->
            <div class="shop-section-wrapper">
                <span class="section-shop-label">3. Select Model</span>
                <div class="model-dropdown-container">
                    <select id="mobileSelect" class="shop-select-custom">
                        <option value="all">Select Model ({{ count($mobiles) }} available)</option>
                        @foreach($mobiles as $mobile)
                        <option value="{{ $mobile->id }}">{{ $mobile->name }} ({{ $mobile->storage_name ?? 'Standard' }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="button" class="btn-buy-now-large" onclick="redirectToPlan()">
                BUY NOW <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </div>
    </div>

    <script>
        function filterBrand(brandId) {
            const url = new URL(window.location.href);
            if (brandId === 'all') {
                url.searchParams.delete('brand');
            } else {
                url.searchParams.set('brand', brandId);
            }
            url.searchParams.delete('series');
            url.searchParams.delete('storage');
            window.location.href = url.toString();
        }
        function filterSeries(seriesId) {
            const url = new URL(window.location.href);
            if (seriesId === 'all') url.searchParams.delete('series');
            else url.searchParams.set('series', seriesId);
            window.location.href = url.toString();
        }
        function redirectToPlan() {
            const mobileId = document.getElementById('mobileSelect').value;
            if (mobileId === 'all') {
                alert('Please select a mobile model first.');
                return;
            }
            window.location.href = "{{ route('plan') }}?id=" + mobileId;
        }
    </script>
</body>
</html>
