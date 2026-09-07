<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order - {{ $settings->app_name ?? 'Alfa Mobiles' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .mobile-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        header {
            background: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }
        .btn-track-header {
            background: #001f3f;
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .contact-label {
            font-size: 12px;
            font-weight: 800;
            color: #333;
            display: block;
            text-align: right;
            margin-bottom: 4px;
        }
        .contact-icons {
            display: flex;
            gap: 10px;
        }
        .contact-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            font-size: 20px;
        }
        .bg-whatsapp { background-color: #25d366; }
        .bg-mail { background-color: #e31e24; }

        .shop-content {
            padding: 40px 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .back-btn-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #003a70;
            text-decoration: none;
            font-size: 20px;
        }

        .shop-title {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .shop-subtitle {
            font-size: 16px;
            color: #777;
            margin-bottom: 40px;
            font-weight: 500;
        }

        .track-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border: 1px solid #f8f9fa;
        }

        .form-group {
            margin-bottom: 30px;
        }
        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #333;
        }
        .form-control-alfa {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid #eee;
            border-radius: 12px;
            font-size: 16px;
            background: #fff;
            color: #333;
        }
        .form-control-alfa::placeholder {
            color: #bbb;
        }

        .track-separator {
            text-align: center;
            font-size: 14px;
            color: #bbb;
            margin: 15px 0 30px;
            font-weight: 600;
        }

        .btn-check-status {
            width: 100%;
            background: #c00000;
            color: #fff;
            padding: 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 18px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 15px;
            box-shadow: 0 6px 15px rgba(192, 0, 0, 0.2);
        }

        .footer-spacer {
            margin-top: auto;
            padding-bottom: 40px;
        }
        .btn-back-storefront {
            display: block;
            text-align: center;
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 40px;
        }
    </style>
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
                    <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="{{ $appName }}" style="height: 50px;">
                </a>
            </div>
            <div class="header-right d-flex align-items-center gap-3">
                <a href="{{ route('track') }}" class="btn-track-header">
                    <i class="fas fa-truck-moving" style="font-size: 16px;"></i> Track
                </a>
                <div class="contact-us-box">
                    <span class="contact-label">CONTACT US</span>
                    <div class="contact-icons">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="contact-circle bg-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:{{ $settings->contact_email ?? 'info@alfamobiles.com' }}" class="contact-circle bg-mail" target="_blank">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="shop-content">
            <!-- Back Button and Title -->
            <div class="d-flex align-items-center gap-4">
                <a href="{{ url('/') }}" class="back-btn-circle"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <h1 class="shop-title">Track Your Order</h1>
                    <p class="shop-subtitle">Check real-time verification and TCS delivery status</p>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger py-3 mt-4">{{ session('error') }}</div>
            @endif

            <!-- Track Card -->
            <form action="{{ route('track.status') }}" method="POST" class="track-card mt-4">
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

            <div class="footer-spacer">
                <a href="{{ url('/') }}" class="btn-back-storefront">
                    — Back to Storefront
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
