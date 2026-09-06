<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Plan - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
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
                    <a href="{{ route('shop') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                    <div class="progress-line-container">
                        <div class="line active"></div>
                        <div class="line current"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <div class="step-counter-text">02/03 — Select Plan</div>
                </div>
            </div>

            <h1 class="shop-title">Select Your Plan</h1>
            <p class="shop-subtitle">Customize storage, color, and pick your preferred 0% markup installment tenure.</p>

            <!-- Selected Product Info -->
            <div class="selected-product-summary">
                <img src="{{ $mobile->image_url ?? 'https://placehold.co/100x100?text=Phone' }}" alt="{{ $mobile->name }}">
                <div class="product-info-text">
                    <div class="summary-name">{{ $mobile->name }}</div>
                    <div class="summary-base-price">Base Price: <span>Rs. {{ number_format($mobile->price) }}</span></div>
                </div>
            </div>

            <form id="planForm" action="{{ route('customer_info') }}" method="GET">
                <input type="hidden" name="color" id="selectedColor" value="Black">
                <input type="hidden" name="tenure" id="selectedTenure" value="12 Months">
                <input type="hidden" name="emi" id="selectedEmi" value="Rs. {{ number_format($mobile->price / 12) }}">
                <input type="hidden" name="total" value="Rs. {{ number_format($mobile->price) }}">

                <!-- Select Color -->
                <div class="section-container">
                    <span class="section-label">Select Color</span>
                    <div class="options-group">
                        <div class="option-btn active" onclick="updateColor('Black', this)">
                            <div class="dot bg-black"></div>
                            <span>Black</span>
                        </div>
                        <div class="option-btn" onclick="updateColor('Silver', this)">
                            <div class="dot bg-silver"></div>
                            <span>Silver</span>
                        </div>
                        <div class="option-btn" onclick="updateColor('Blue', this)">
                            <div class="dot bg-blue"></div>
                            <span>Blue</span>
                        </div>
                    </div>
                </div>

                <!-- Select Storage -->
                <div class="section-container">
                    <span class="section-label">Select Storage</span>
                    <div class="options-group">
                        <div class="option-btn active">
                            <span>Standard Storage</span>
                        </div>
                    </div>
                </div>

                <!-- Choose EMI Tenure -->
                <div class="section-container">
                    <span class="section-label">Choose EMI Tenure (0% Markup)</span>
                    <div class="tenure-grid">
                        @php $price = (int)str_replace(',', '', $mobile->price); @endphp
                        @foreach([12, 24, 36, 48, 60] as $months)
                        <div class="tenure-card {{ $months == 12 ? 'active' : '' }}" onclick="updateTenure('{{ $months }} Months', '{{ number_format($price / $months) }}', this)">
                            <div class="tenure-months">{{ $months }} Months</div>
                            <div class="tenure-emi">Rs. {{ number_format($price / $months) }}/mo</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="final-price-box">
                    <div class="price-row">
                        <span>Total Device Cash Price:</span>
                        <span>Rs. {{ number_format($price) }}</span>
                    </div>
                    <div class="price-row">
                        <span>Tenure Selected:</span>
                        <span id="displayTenure">12 Months</span>
                    </div>
                    <div class="emi-row">
                        <span class="emi-label">Monthly EMI (0% Markup):</span>
                        <span class="emi-value" id="displayEmi">Rs. {{ number_format($price / 12) }} / mo</span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Action -->
        <div class="footer-action">
            <button type="submit" form="planForm" class="btn-shop-now border-0 w-100">
                Next → Proceed to Customer Info
            </button>
        </div>
    </div>

    <script>
        function updateColor(color, el) {
            document.querySelectorAll('#planForm .option-btn').forEach(b => {
                if(b.querySelector('.dot')) b.classList.remove('active');
            });
            el.classList.add('active');
            document.getElementById('selectedColor').value = color;
        }

        function updateTenure(tenure, emi, el) {
            document.querySelectorAll('.tenure-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selectedTenure').value = tenure;
            document.getElementById('selectedEmi').value = 'Rs. ' + emi;
            document.getElementById('displayTenure').innerText = tenure;
            document.getElementById('displayEmi').innerText = 'Rs. ' + emi + ' / mo';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
