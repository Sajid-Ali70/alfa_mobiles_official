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
    @php
        $appName = $settings->app_name ?? 'Alfa Mobiles';
    @endphp

    <div class="mobile-wrapper">
        <!-- Header -->
        <header>
            <div class="logo">
                <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="{{ $appName }}">
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

        <!-- Banner Section -->
        <section class="banner-section p-0">
            <img src="{{ $settings->banner_url ?? asset('img/banner.png') }}" alt="Alfa Mobiles Banner" class="w-100 d-block">
        </section>

        <!-- Promo Section -->
        <div class="promo-section">
            <div class="promo-container">
                <i class="fas fa-bullhorn megaphone-icon"></i>
                <h2 class="promo-text">BUY NOW, <span>PAY LATER!</span></h2>
            </div>
        </div>

        <!-- Partners -->
        <div class="partners-section">
            <div class="partner-item">
                <img src="{{ asset('img/logo_payment/statebankofpakistan.webp') }}" class="partner-logo" alt="SBP">
                <span class="partner-name">PAKISTAN ALL BANKS</span>
            </div>
            <div class="partner-item">
                <img src="{{ asset('img/logo_payment/mastercard.png') }}" class="partner-logo" alt="Mastercard">
                <span class="partner-name">MASTERCARD</span>
            </div>
            <div class="partner-item">
                <img src="{{ asset('img/logo_payment/visacard.webp') }}" class="partner-logo" alt="Visa">
                <span class="partner-name">VISA CARD</span>
            </div>
            <div class="partner-item">
                <img src="{{ asset('img/logo_payment/easypaisa.webp') }}" class="partner-logo" alt="Easypaisa">
                <span class="partner-name">EASYPAISA</span>
            </div>
            <div class="partner-item">
                <img src="{{ asset('img/logo_payment/upaisa.png') }}" class="partner-logo" alt="Upaisa">
                <span class="partner-name">UPAISA</span>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="features-section">
            <div class="features-grid">
                <div class="feature-box">
                    <div class="feature-icon-circle f-blue">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>EASY INSTALLMENTS</h3>
                        <p>Up to 60 Months</p>
                    </div>
                </div>
                <div class="feature-box">
                    <div class="feature-icon-circle f-red">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="feature-content">
                        <h3>0% MARKUP</h3>
                        <p>No Hidden Charges</p>
                    </div>
                </div>
                <div class="feature-box">
                    <div class="feature-icon-circle f-green">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="feature-content">
                        <h3>CASH ON DELIVERY</h3>
                        <p>Postpaid</p>
                    </div>
                </div>
                <div class="feature-box">
                    <div class="feature-icon-circle f-orange">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="feature-content">
                        <h3>CARDS ACCEPTED</h3>
                        <p>All Major Cards</p>
                    </div>
                </div>
                <div class="feature-box">
                    <div class="feature-icon-circle f-purple">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="feature-content">
                        <h3>100% ORIGINAL</h3>
                        <p>Official Warranty</p>
                    </div>
                </div>
                <div class="feature-box">
                    <div class="feature-icon-circle f-cyan">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="feature-content">
                        <h3>SECURE PAYMENTS</h3>
                        <p>Safe & Reliable</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Action -->
        <div class="footer-action">
            <a href="{{ route('shop') }}" class="btn-shop-now">
                <i class="fas fa-shopping-cart"></i> Shop Now
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
