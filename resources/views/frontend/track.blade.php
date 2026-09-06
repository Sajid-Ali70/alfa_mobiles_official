<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
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
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="contact-circle bg-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:{{ $settings->contact_email ?? 'info@alfamobiles.com' }}" class="contact-circle bg-mail">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </header>

        <div class="shop-content">
            <!-- Back Button and Title -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ url('/') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <h1 class="shop-title mb-0" style="font-size: 24px;">Track Your Order</h1>
                    <p class="shop-subtitle mb-0" style="font-size: 13px;">Check real-time verification and TCS delivery status</p>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Track Card -->
            <form action="{{ route('track.status') }}" method="POST" class="track-card">
                @csrf
                <div class="form-group">
                    <label>Order ID</label>
                    <input type="text" name="order_id" class="form-control-alfa" placeholder="e.g. AM-260808-4821" value="{{ request('order_id') }}">
                </div>

                <div class="track-separator">— OR —</div>

                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile_number" class="form-control-alfa" placeholder="XXXXXX-XXXXX">
                </div>

                <button type="submit" class="btn-check-status">
                    <i class="fas fa-search"></i> Check Order Status
                </button>
            </form>

            <!-- Bottom Back Button -->
            <div class="mt-auto pt-5">
                <a href="{{ url('/') }}" class="btn-back-storefront">
                    — Back to Storefront
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
