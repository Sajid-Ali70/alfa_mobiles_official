<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Plan - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .plan-page-content {
            padding: 30px 20px 120px;
            background: #fff;
            flex-grow: 1;
        }

        /* Step Progress Header */
        .step-nav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 35px;
        }
        .back-circle-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f8fbff;
            border: 1px solid #eef2f7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #003a70;
            text-decoration: none;
            font-size: 18px;
        }
        .progress-segments {
            display: flex;
            gap: 8px;
            flex-grow: 1;
            margin: 0 20px;
        }
        .p-seg {
            height: 6px;
            flex: 1;
            border-radius: 4px;
            background-color: #f2f2f2;
        }
        .p-seg.completed {
            background-color: #10b981;
        }
        .p-seg.active {
            background-color: #e31e24;
        }
        .step-label-text {
            font-size: 14px;
            font-weight: 800;
            color: #e31e24;
            white-space: nowrap;
        }

        .plan-title {
            font-size: 32px;
            font-weight: 900;
            color: #000;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .plan-subtitle {
            font-size: 16px;
            color: #777;
            margin-bottom: 35px;
            line-height: 1.4;
            font-weight: 500;
        }

        /* Product Box */
        .plan-product-card {
            border: 1px solid #f0f0f0;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 40px;
        }
        .plan-product-img {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }
        .p-summary-name {
            font-size: 24px;
            font-weight: 900;
            color: #000;
            margin-bottom: 5px;
        }
        .p-summary-base {
            font-size: 16px;
            color: #777;
            font-weight: 600;
        }
        .p-summary-base span {
            color: #555;
        }

        .section-shop-label {
            display: block;
            font-size: 18px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        /* Options Group (Colors/Storage) */
        .options-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 40px;
        }
        .pill-option {
            border: 2px solid #eee;
            border-radius: 30px;
            padding: 10px 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .pill-option.active {
            border-color: #e31e24;
            background: #fffcfc;
        }
        .dot-color {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid #ddd;
        }
        .pill-option span {
            font-size: 16px;
            font-weight: 700;
            color: #444;
        }
        .pill-option.active span {
            color: #000;
        }

        /* EMI Tenure Grid */
        .tenure-grid-shop {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 45px;
        }
        .tenure-card-shop {
            border: 2px solid #eee;
            border-radius: 15px;
            padding: 20px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .tenure-card-shop.active {
            border-color: #e31e24;
            background: #fffcfc;
        }
        .tenure-card-shop .t-months {
            font-size: 18px;
            font-weight: 800;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        .tenure-card-shop .t-emi {
            font-size: 14px;
            font-weight: 700;
            color: #10b981;
        }
        .tenure-card-shop.active .t-months {
            color: #e31e24;
        }

        /* Summary Box */
        .plan-summary-box {
            background: #0f172a;
            border-radius: 20px;
            padding: 30px 25px;
            color: #fff;
            margin-bottom: 40px;
        }
        .sum-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .sum-row span:first-child {
            color: #94a3b8;
            font-weight: 600;
        }
        .sum-row span:last-child {
            font-weight: 700;
        }
        .sum-row.total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #1e293b;
            align-items: center;
            margin-bottom: 0;
        }
        .sum-row.total .emi-val {
            color: #22c55e;
            font-size: 26px;
            font-weight: 900;
        }

        /* Footer Fixed Button */
        .btn-next-step {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 900px;
            padding: 22px;
            background: #e31e24;
            color: #fff !important;
            text-decoration: none !important;
            font-size: 20px;
            font-weight: 800;
            text-align: center;
            border: none;
            border-radius: 25px 25px 0 0;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        @media (min-width: 900px) {
            .btn-next-step {
                border-radius: 20px;
                bottom: 20px;
                width: 92%;
            }
        }
    </style>
</head>
<body>
    @php
        $availableColors = array_map('trim', explode(',', $mobile->colors ?? 'Black,Silver,Blue'));
        $price = (int)$mobile->price;
    @endphp

    <div class="mobile-wrapper">
        <!-- Shared Header -->
        @include('frontend.partials.header')

        <div class="plan-page-content">
            <!-- Step Progress Header -->
            <div class="step-nav-header">
                <a href="{{ route('shop') }}" class="back-circle-btn"><i class="fas fa-arrow-left"></i></a>
                <div class="progress-segments">
                    <div class="p-seg completed"></div>
                    <div class="p-seg active"></div>
                    <div class="p-seg"></div>
                    <div class="p-seg"></div>
                    <div class="p-seg"></div>
                    <div class="p-seg"></div>
                </div>
                <div class="step-label-text">02/05 — Select Plan</div>
            </div>

            <h1 class="plan-title">Select Your Plan</h1>
            <p class="plan-subtitle">Customize storage, color, and pick your preferred 0% markup installment tenure.</p>

            <!-- Product Summary Card -->
            <div class="plan-product-card">
                <img src="{{ $mobile->image_url ?? asset('img/mobile-icon.png') }}" alt="{{ $mobile->name }}" class="plan-product-img">
                <div class="p-summary-info">
                    <div class="p-summary-name">{{ $mobile->name }}</div>
                    <div class="p-summary-base">Base Price: <span>Rs. {{ number_format($price) }}</span></div>
                </div>
            </div>

            <form id="planForm" action="{{ route('customer_info') }}" method="GET">
                <input type="hidden" name="mobile_id" value="{{ $mobile->id }}">
                <input type="hidden" name="color" id="selectedColor" value="{{ $availableColors[0] ?? 'Black' }}">
                <input type="hidden" name="tenure" id="selectedTenure" value="12 Months">
                <input type="hidden" name="emi" id="selectedEmi" value="Rs. {{ number_format($price / 12) }}">

                <!-- Select Color -->
                <div class="plan-section">
                    <span class="section-shop-label">Select Color</span>
                    <div class="options-flex">
                        @foreach($availableColors as $index => $color)
                        <div class="pill-option {{ $index == 0 ? 'active' : '' }}" onclick="updateColor('{{ $color }}', this)">
                            <div class="dot-color" style="background-color: {{ strtolower($color) == 'silver' ? '#e2e8f0' : (strtolower($color) == 'white' ? '#fff' : strtolower($color)) }};"></div>
                            <span>{{ $color }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Select Storage -->
                <div class="plan-section">
                    <span class="section-shop-label">Select Storage</span>
                    <div class="options-flex">
                        <div class="pill-option active">
                            <div class="dot-color" style="background-color: #e31e24;"></div>
                            <span>Standard Storage</span>
                        </div>
                    </div>
                </div>

                <!-- Choose EMI Tenure -->
                <div class="plan-section">
                    <span class="section-shop-label">Choose EMI Tenure (0% Markup)</span>
                    <div class="tenure-grid-shop">
                        @foreach([12, 24, 36, 48, 60] as $months)
                        <div class="tenure-card-shop {{ $months == 12 ? 'active' : '' }}" onclick="updateTenure('{{ $months }} Months', '{{ number_format($price / $months) }}', this)">
                            <span class="t-months">{{ $months }} Months</span>
                            <span class="t-emi">Rs. {{ number_format($price / $months) }}/mo</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="plan-summary-box">
                    <div class="sum-row">
                        <span>Total Device Cash Price:</span>
                        <span>Rs. {{ number_format($price) }}</span>
                    </div>
                    <div class="sum-row">
                        <span>Tenure Selected:</span>
                        <span id="displayTenure">12 Months</span>
                    </div>
                    <div class="sum-row total">
                        <span>Monthly EMI (0% Markup):</span>
                        <span class="emi-val" id="displayEmi">Rs. {{ number_format($price / 12) }} / mo</span>
                    </div>
                </div>

                <button type="submit" class="btn-next-step">
                    Next → Proceed to Customer Info
                </button>
            </form>
        </div>
    </div>

    <script>
        function updateColor(color, el) {
            el.parentElement.querySelectorAll('.pill-option').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selectedColor').value = color;
        }

        function updateTenure(tenure, emi, el) {
            document.querySelectorAll('.tenure-card-shop').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selectedTenure').value = tenure;
            document.getElementById('selectedEmi').value = 'Rs. ' + emi;
            document.getElementById('displayTenure').innerText = tenure;
            document.getElementById('displayEmi').innerText = 'Rs. ' + emi + ' / mo';
        }
    </script>
</body>
</html>
