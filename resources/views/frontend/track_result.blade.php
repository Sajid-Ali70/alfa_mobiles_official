<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="mobile-wrapper">
        <!-- Header -->
        <header>
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="Logo">
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
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('track') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                <h1 class="shop-title mb-0" style="font-size: 24px;">Order Status</h1>
            </div>

            <div class="track-card">
                <div class="text-center mb-4">
                    <div class="step-counter-text mb-2">Order #{{ $order->order_number }}</div>
                    <span class="badge-status badge-{{ strtolower($order->status) }} px-4 py-2" style="font-size: 1rem;">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="section-container border-top pt-3">
                    <div class="price-row text-dark mb-2">
                        <span class="fw-bold">Customer:</span>
                        <span>{{ $order->full_name }}</span>
                    </div>
                    <div class="price-row text-dark mb-2">
                        <span class="fw-bold">Item Details:</span>
                        <span>{{ $order->color }}</span>
                    </div>
                    <div class="price-row text-dark">
                        <span class="fw-bold">Monthly EMI:</span>
                        <span class="text-success fw-bold">{{ $order->monthly_emi }}</span>
                    </div>
                </div>

                <div class="alert alert-info mt-4 mb-0" style="font-size: 13px;">
                    <i class="fas fa-info-circle me-2"></i>
                    Your request is being processed. Our agent will contact you on <strong>{{ $order->mobile_number }}</strong> shortly for verification.
                </div>
            </div>

            <a href="{{ url('/') }}" class="btn-back-storefront mt-4">— Back to Storefront</a>
        </div>
    </div>
</body>
</html>
