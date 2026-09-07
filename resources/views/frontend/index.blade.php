<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="mobile-wrapper home-page-layout">
        <!-- Header -->
        @include('frontend.partials.header')

        <!-- Banner Section -->
        <section class="banner-section">
            <img src="{{ $settings->banner_url ?? asset('img/banner.png') }}" alt="Banner" class="w-100">
        </section>

        <!-- Promo Section -->
        <div class="promo-section-container">
            <div class="promo-flex-box">
                <img src="{{ asset('img/megaphone.png') }}" alt="Megaphone" class="megaphone-img-home" onerror="this.src='https://cdn-icons-png.flaticon.com/512/1997/1997890.png'">
                <h2 class="promo-text-home">BUY NOW, <span>PAY LATER!</span></h2>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-home">
            <a href="{{ route('shop') }}" class="action-card-home bg-blue">
                <div class="action-icon-home"><i class="fas fa-mobile-alt"></i></div>
                <span class="btn-text">Book Your Mobile</span>
                <i class="fas fa-chevron-right chevron-home"></i>
            </a>
            <a href="{{ route('calculator') }}" class="action-card-home bg-purple">
                <div class="action-icon-home"><i class="fas fa-calculator"></i></div>
                <span class="btn-text">Installment Calculator</span>
                <i class="fas fa-chevron-right chevron-home"></i>
            </a>
            <a href="{{ route('refund') }}" class="action-card-home bg-red">
                <div class="action-icon-home"><i class="fas fa-sync-alt"></i></div>
                <span class="btn-text">Refund Payment</span>
                <i class="fas fa-chevron-right chevron-home"></i>
            </a>
        </div>

        <!-- Partners -->
        <div class="partners-section-home">
            <div class="partners-flex-home">
                <div class="partner-logo-box">
                    <img src="{{ asset('img/logo_payment/bankalfalah.png') }}" alt="Bank Alfalah">
                    <span>Bank Alfalah</span>
                </div>
                <div class="partner-logo-box">
                    <img src="{{ asset('img/logo_payment/mastercard.png') }}" alt="Mastercard">
                    <span>Mastercard</span>
                </div>
                <div class="partner-logo-box">
                    <img src="{{ asset('img/logo_payment/visacard.webp') }}" alt="Visa Card">
                    <span>Visa Card</span>
                </div>
                <div class="partner-box-item">
                    <img src="{{ asset('img/logo_payment/easypaisa.webp') }}" alt="Easypaisa">
                    <span>easypaisa</span>
                </div>
                <div class="partner-box-item">
                    <img src="{{ asset('img/logo_payment/upaisa.png') }}" alt="U-Paisa">
                    <span>U-Paisa</span>
                </div>
            </div>
        </div>

        <!-- Features Grid Bottom -->
        <div class="bottom-features-home">
            <div class="bottom-grid-home">
                <div class="feature-card-home">
                    <div class="feature-icon-box blue-bg">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="feature-text-box">
                        <h5>EASY INSTALLMENTS</h5>
                        <p>Up to 6 Months</p>
                    </div>
                </div>
                <div class="feature-card-home">
                    <div class="feature-icon-box red-bg">
                        <i class="fas fa-percent"></i>
                    </div>
                    <div class="feature-text-box">
                        <h5>0% MARKUP</h5>
                        <p>No Hidden Charges</p>
                    </div>
                </div>
                <div class="feature-card-home">
                    <div class="feature-icon-box green-bg">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="feature-text-box">
                        <h5>CASH ON DELIVERY</h5>
                        <p>Nationwide</p>
                    </div>
                </div>
                <div class="feature-card-home">
                    <div class="feature-icon-box purple-bg">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-text-box">
                        <h5>100% ORIGINAL</h5>
                        <p>Official Warranty</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
